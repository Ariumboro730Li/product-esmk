<?php

namespace App\Http\Controllers\Internal;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Jobs\NotificationUser;
use App\Models\AssessmentInterview;
use App\Models\CertificateRequest;
use App\Models\CertificateRequestAssessment;
use App\Models\CertificateSmk;
use App\Models\CertificateTemplate;
use App\Models\Signer;
use App\Models\YearlyReportLog;
use App\Services\FileService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PengesahanDokumenController extends Controller
{

    public function createCertificateRelease(Request $request)
    {

        $request->validate([
            'number_of_certificate'  => ['required'],
            'publish_date'           => ['required'],
            'certificate_file'       => ['required'],
            'sk_file'                => ['required'],
            'rov_file'               => ['required'],
            'sign_by'                => ['required'],
        ]);

        $request['request_status'] = 'certificate_validation';
        $request['expired_date'] = Carbon::parse($request->publish_date)->addYears(5)->format('Y-m-d');
        $request['due_date'] = Carbon::parse($request->publish_date)->addYears(1)->format('Y-m-d');
        $request['year'] = Carbon::parse($request->publish_date)->addYears(1)->format('Y');


        $certificate = $this->certificateRelease($request);

        if ($certificate) {
            return response()->json([
                'status' => HttpStatusCodes::HTTP_OK,
                'message' => 'Berhasil membuat sertifikat',
                'data' => $certificate
            ], HttpStatusCodes::HTTP_OK);
        }

        return response()->json([
            'status' => HttpStatusCodes::HTTP_BAD_REQUEST,
            'message' => 'Gagal membuat sertifikat'
        ], HttpStatusCodes::HTTP_BAD_REQUEST);
    }

    private function certificateRelease($request)

    {
        $signer = $this->getSignerByID($request['sign_by']);

        $requestStatus = $this->changeRequestStatus($request->id, $request['request_status']);

        $certificateDigital = $this->generateCertificate($request, $requestStatus->company, $signer);

        $certificate = $this->storeCertificate($requestStatus->company_id, $request->id, $request, $certificateDigital);

        $this->storeYearlyReportLog($requestStatus->company_id, $request);

        $this->generateNotificationByStatus($request['request_status'], [
            'company' => [
                'id' => $requestStatus->company_id,
                'name' => $requestStatus->company->name
            ]
        ]);

        return $certificate;
    }

    private function getSignerByID($id)
    {
        return Signer::findOrFail($id);
    }

    private function changeRequestStatus($id, $status)
    {

        $oldData = CertificateRequest::where('id', $id)->firstOrFail();
        $oldData->status = $status;
        $oldData->save();

        return $oldData;
    }
    public function getCertificateTemplate()
    {

        $template = CertificateTemplate::select()
            ->first();


        return $template;
    }
    private function generateCertificate($request, $company, $signer)
    {

        // Mengambil template sertifikat
        $templateCertificate = $this->getCertificateTemplate();
        $templateHtml = $templateCertificate->content;

        // Format sertifikat
        $certificateNumberSpan = "<span>{$request['number_of_certificate']}</span>";

        // Generate QR code dan ubah menjadi base64
        $qrCode = QrCode::size(75)->generate($request['number_of_certificate']);
        $svgQrCode = base64_encode(explode("\n", $qrCode)[1]);
        $svgQrCodeImg = '<img src="data:image/svg+xml;base64,' . $svgQrCode . '" />';

        // Format tanggal publikasi
        $publishDate = Carbon::parse($request['publish_date'])->locale('id')->translatedFormat('j F Y');

        // Data yang akan dicari dan digantikan dalam template
        $search = [
            '{{certificate_number}}',
            '{{company_name}}',
            '{{company_address}}',
            '{{release_date}}',
            '{{signer_position}}',
            '{{signer_name}}',
            '{{signer_identity_type}}',
            '{{signer_identity_number}}',
            '{{qrCode}}'
        ];

        // Data pengganti untuk template
        $replace = [
            $certificateNumberSpan,
            $company->name,
            $company->address,
            $publishDate,
            $signer->position,
            $signer->name,
            $signer->identity_type,
            $signer->identity_number,
            $svgQrCodeImg
        ];

        $templateHtml = str_replace($search, $replace, $templateHtml);
        // Mengganti template HTML dengan data aktual
        $dompdf = Pdf::loadHtml($templateHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = base64_encode($dompdf->output());
        $filename = "sertifikat-{$company->name}-{$request->number_of_certificate}.pdf";

        $uploadService  = new FileService();
        $uploadCertificate = $uploadService->uploadFileDompfd($pdfContent, $filename);

        return $uploadCertificate;
    }

    private function storeCertificate($companyID, $certificateRequestID, $validatedData, $certificateDigital)
    {

        $newCertificate = new CertificateSmk();
        $newCertificate->number_of_certificate = $validatedData['number_of_certificate'];
        $newCertificate->publish_date = $validatedData['publish_date'];
        $newCertificate->certificate_file = $validatedData['certificate_file'];
        $newCertificate->sk_file = $validatedData['sk_file'];
        $newCertificate->rov_file = $validatedData['rov_file'];
        $newCertificate->certificate_request_id = $certificateRequestID;
        $newCertificate->company_id = $companyID;
        $newCertificate->is_active = true;
        $newCertificate->sign_by = $validatedData['sign_by'];
        $newCertificate->certificate_digital_url = $certificateDigital;
        $newCertificate->expired_date = $validatedData['expired_date'] ?? null;

        $newCertificate->save();

        return $newCertificate;
    }

    private function storeYearlyReportLog($companyID, $validatedData)
    {
        $yearlyReportLog = new YearlyReportLog();
        $yearlyReportLog->company_id = $companyID;
        $yearlyReportLog->year = $validatedData['year'];
        $yearlyReportLog->due_date = $validatedData['due_date'];
        $yearlyReportLog->save();
    }

    public function getGenerateSK(Request $request)
    {
        // Memastikan parameter 'signer' dan 'sk_number' ada
        if (!$request->signer || !$request->sk_number) {
            return '';
        }

        // Ambil data berdasarkan certificate_request_id
        $data = CertificateRequestAssessment::where('certificate_request_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Decode element_properties dari data yang pertama
        $elementProperties = $data->isEmpty() ? collect() : json_decode($data->first()->element_properties, true);

        $elementTitles = collect();
        $elementCount = 0; // Variabel untuk menghitung jumlah elemen

        // Ambil judul elemen dari question schema jika tersedia
        if (isset($elementProperties['question_schema']['properties'])) {
            foreach ($elementProperties['question_schema']['properties'] as $elementKey => $elementValue) {
                if (isset($elementValue['title'])) {
                    // Mengubah setiap huruf pertama menjadi huruf besar
                    $title = ucwords($elementValue['title']);
                    $elementTitles->put($elementKey, $title);

                    // Tambah hitungan elemen setiap kali ditemukan
                    $elementCount++;
                }
            }
        }

        // Ambil detail sertifikat, signer, dan assessment interview
        $smkCertificatepdf = $this->getDetailByID($request->id);
        $signer = $this->getSignerByID($request->signer);
        $assessmentInterview = $this->getLatestAssessmentInterviewByRequestID($request->id);

        // Jika signer ditemukan, buat PDF
        if ($signer) {
            $data = [
                'count_element' => $elementCount, // Menyimpan jumlah elemen yang ditemukan
                'companies_name' => $smkCertificatepdf->company->name,
                'address' => $smkCertificatepdf->company->address,
                'pic_name' => $smkCertificatepdf->company->pic_name,
                'name_dirjen' => $signer->name,
                'number_of_application_letter' => $smkCertificatepdf->number_of_application_letter,
                'sk_number' => $request->sk_number,
                'date_of_application_letter' => isset($smkCertificatepdf->date_of_application_letter) ? Carbon::parse($smkCertificatepdf->date_of_application_letter)->translatedFormat('d F Y') : '-',
                'rov_number' => $assessmentInterview->number_of_letter,
                'interview_schedule' => isset($assessmentInterview->schedule) ? Carbon::parse($assessmentInterview->schedule)->translatedFormat('d F Y') : '-',
                'letterhead' => "data:image/png;base64," . base64_encode(file_get_contents(public_path('assets/images/cover.jpg'))),
                'penyebut' => function ($nilai) {
                    return $this->penyebut($nilai);
                }, // Tambahkan penyebut sebagai callable function
            ];

            // Generate PDF menggunakan data yang sudah dikumpulkan
            $pdf = PDF::loadView('pdf.print_sk', compact('data'))->setPaper('letter');
            return $pdf->stream();
        }
    }


    public function getDetailByID($requestID)
    {
        // Get the certificate request with related entities
        $data = CertificateRequest::with([
            'company',
            'company.serviceTypes',
            'company.province',
            'company.city',
            'dispositionBy',
            'dispositionTo',
        ])
            ->join('certificate_request_assessments', function ($join) {
                $join->on('certificate_requests.id', 'certificate_request_assessments.certificate_request_id')
                    ->where('certificate_request_assessments.is_active', true);
            })
            ->leftJoin('application_letters', 'certificate_requests.id', 'application_letters.certificate_request_id')
            ->select(
                'certificate_requests.*',
                'certificate_request_assessments.assessor as certificate_request_assessor',
                'element_properties',
                'answers',
                'assessments',
                'revision',
                'certificate_request_assessments.status as assessment_status',
                'certificate_request_assessments.validation_notes as validation_notes',
                'application_letters.number_of_application_letter as number_of_application_letter',
                'application_letters.date_of_letter as date_of_application_letter',
                'application_letters.file as file_of_application_letter'
            )
            ->where('certificate_requests.id', $requestID)
            ->first();

        // Add an additional check for null or empty collections if needed
        if (!$data) {
            // Return empty object or handle the case where no data is found
            return null;  // Or handle accordingly if $data is null
        }

        return $data;
    }

    public function getLatestAssessmentInterviewByRequestID($certificateRequestID)
    {
        $data = AssessmentInterview::with([
            'assessorHead',
            'assessors'
        ])
            ->select('*')
            ->where('certificate_request_id', $certificateRequestID)
            ->where('is_active', '=', true)
            ->first();
        return $data;
    }

    public function generateNotificationByStatus($status, $recipients, $information = [])
    {
        $currentDate = Carbon::now()->timestamp;
        $topicForCompany = 'notification-company';
        $topicForEmployee = 'notification-employee';

        $data = array();

        if ($status === 'rejected') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = array(
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Pengajuan ditolak',
                'description' => 'Pengajuan ditolak, silahkan cek kembali data yang dikirim!.',
                'data' => json_encode([]),
                'delivery_at' => $currentDate
            );

            array_push($data, $forCompany);
        } else if ($status === 'disposition') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Disposisi',
                'description' => 'Pengajuan sertifikat SMK sedang proses disposisi',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Anda disposisi oleh untuk melakukan penilaian {$recipients['company']['name']}";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'Disposisi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'not_passed_assessment') {

            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Tidak lulus penilaian',
                'description' => 'Pengajuan tidak lulus penilaian dan dibutuhkan perbaikan dokumen',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);
        } else if ($status === 'passed_assessment') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Lulus penilaian',
                'description' => 'Dokumen sudah dinilai dan diteruskan untuk verifikasi penilaian.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Dokumen {$recipients['company']['name']} lulus penilaian, dan dibutuhkan verifikasi";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'not_passed_assessment_verification') {

            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'warning',
                'title' => 'Penilaian dokumen tidak lulus verifikasi',
                'description' => 'Penilaian dokumen tidak lulus verifikasi dan akan dilakukan penilaian ulang.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Penilaian dokumen {$recipients['company']['name']} tidak lulus verifikasi dan diharuskan penilaian ulang";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'wanning',
                'title' => 'Penilaian dokumen tidak lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'passed_assessment_verification') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Penilaian dokumen lulus verifikasi',
                'description' => 'Penilaian dokumen lulus verifikasi dan akan dijadwalkan verifikasi lapangan.',
                'delivery_at' => $currentDate
            ];

            $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee']['id']}";
            $descriptionForEmployee = "Penilaian dokumen {$recipients['company']['name']} lulus verifikasi";
            $forInternal = [
                'topic' => $newTopicForEmployee,
                'type' => 'success',
                'title' => 'Penilaian dokumen lulus verifikasi',
                'description' => $descriptionForEmployee,
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany, $forInternal);
        } else if ($status === 'scheduled_interview') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Penjadwalan verifikasi lapangan',
                'description' => 'Anda dijadwalkan verifikasi lapangan pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Penjadwalan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'update_inteview_assessment') {
            if ($information['send_to_company']) {
                $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";
                $forCompany = [
                    'topic' => $newTopicForCompany,
                    'type' => 'success',
                    'title' => 'Perubahan verifikasi lapangan',
                    'description' => 'Perubahaan verifikasi lapangan pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.',
                    'delivery_at' => $currentDate
                ];

                array_push($data, $forCompany);
            }

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = "Perubahaan verifikasi lapangan Perusahaan {$recipients['company']['name']}.";

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Perubahan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'new_assessor_interview') {

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Anda dijadwalkan verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' pada Hari ' . Carbon::parse($information['schedule'])->locale('id')->dayName . ', Tanggal ' . Carbon::parse($information['schedule'])->format('d F Y') . '.';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Penjadwalan verifikasi lapangan',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'completed_interview') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";

            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Verifikasi lapangan telah selesai',
                'description' => 'Verifikasi lapangan telah selesai, saat ini dokumen Anda sedang proses tahap penerbitan Berita Acara',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);

            for ($i = 0; $i < count($recipients['employee']); $i++) {

                $newTopicForEmployee = "{$topicForEmployee}-{$recipients['employee'][$i]['id']}";
                $newDescription = 'Verifikasi lapangan Perusahaan ' . $recipients['company']['name'] . ' sudah selesai';

                $forInternals = [
                    'topic' => $newTopicForEmployee,
                    'type' => 'success',
                    'title' => 'Verifikasi lapangan telah selesai',
                    'description' => $newDescription,
                    'delivery_at' => $currentDate
                ];


                array_push($data, $forInternals);
            }
        } else if ($status === 'certificate_validation') {
            $newTopicForCompany = "{$topicForCompany}-{$recipients['company']['id']}";

            $forCompany = [
                'topic' => $newTopicForCompany,
                'type' => 'success',
                'title' => 'Pengesahan Sertifikat',
                'description' => 'Selamat! Sertifikat SMK anda sudah terbit.',
                'delivery_at' => $currentDate
            ];

            array_push($data, $forCompany);
        }

        dispatch(new NotificationUser($data))->delay(Carbon::now()->addSeconds(3));
    }
    public function print(Request $request)
    {
        Carbon::setLocale('id'); // Set locale ke Bahasa Indonesia

        $data = CertificateRequestAssessment::where('certificate_request_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $dataInterview = AssessmentInterview::with('assessors')
            ->where('certificate_request_id', $request->id)
            ->first() ?? collect();

        $element = $data->isEmpty() ? collect() : json_decode($data->first()->assessments, true);
        $elementProperties = $data->isEmpty() ? collect() : json_decode($data->first()->element_properties, true);

        $elementTitles = collect();

        // Ambil judul elemen dari question schema
        if (isset($elementProperties['question_schema']['properties'])) {
            foreach ($elementProperties['question_schema']['properties'] as $elementKey => $elementValue) {
                if (isset($elementValue['title'])) {
                    // Ubah setiap huruf pertama menjadi huruf besar
                    $title = ucwords($elementValue['title']);
                    $elementTitles->put($elementKey, $title);
                }
            }
        }

        $nilai = collect(); // Untuk menyimpan hasil nilai
        $maxAssessment = $elementProperties['max_assesment'] ?? []; // Ambil data max_assesment

        // Hitung nilai elemen
        if ($element && is_array($element)) {

            foreach ($element as $key => $subElements) {
                if (Str::startsWith($key, 'element_')) {

                    foreach ($subElements as $subKey => $subValue) {
                        $actualValue = isset($subValue['value']) ? intval($subValue['value']) : 0;
                        $maxValue = isset($maxAssessment[$key][$subKey]) ? intval($maxAssessment[$key][$subKey]) : 0;

                        if ($maxValue > 0) {
                            if ($actualValue >= $maxValue) {
                                $score = 10; // Jika actualValue sama atau lebih besar dari maxValue
                            } else {
                                $score = ($actualValue / $maxValue) * 10; // Proporsi nilai berdasarkan actualValue
                            }
                        } else {
                            $score = 0; // Jika maxValue tidak valid, nilai skor adalah 0
                        }

                    }

                    $score = round($score, 2);
                    $nilai->put($key, $score);
                }
            }

        }


        $interviews = $data->isEmpty() ? collect() : $data->first()->assessment_interviews->first();
        $company = $data->isEmpty() ? collect() : $data->first()->certificate_request->company;

        // Format jadwal
        $schedule = isset($interviews->schedule) ? Carbon::createFromFormat('Y-m-d H:i:s', $interviews->schedule) : null;

        $pdf = Pdf::loadView('pdf.print_berita_acara', [
            'element' => $element,
            'nilai' => $nilai, // Kirim semua skor elemen dalam skala 1-10
            'elementTitles' => $elementTitles, // Kirim judul elemen
            'number_of_letter' => $interviews->number_of_letter ?? '-',
            'assessor_head' => $interviews->assessorHead->name ?? '-',
            'assessor_head_nip' => $interviews->assessorHead->nip ?? '-',
            'assessors' => $dataInterview->assessors ?? [],
            'schedule_day' => $schedule ? $schedule->translatedFormat('l') : '-', // Nama hari dalam Bahasa Indonesia
            'schedule_day_text' => $schedule ? $this->terbilang(intval($schedule->format('d'))) : '-', // Tanggal dalam format terbilang
            'schedule_month' => $schedule ? $schedule->translatedFormat('F') : '-', // Nama bulan dalam Bahasa Indonesia
            'schedule_year' => $schedule ? $this->terbilang(intval($schedule->format('Y'))) : '-', // Tahun dalam format terbilang
            'company_name' => $company->name ?? '-',
            'company_pic' => $company->pic_name ?? '-',
            'company_address' => $company->address ?? '-',
            'logo' => "data:image/png;base64," . base64_encode(file_get_contents(public_path('assets/images/cover.jpg')))
        ])->setPaper('a4');

        return $pdf->stream();
    }


    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " Milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    private function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "Minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
}
