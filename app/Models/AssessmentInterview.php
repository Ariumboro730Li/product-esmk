<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentInterview extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function assessorHead()
    {
        return $this->belongsTo(User::class, 'assessor_head')->select('id', 'name', 'nip');
    }

    public function assessor1()
    {
        return $this->belongsTo(User::class, 'assessor_1')->select('id', 'name', 'nip');
    }

    public function assessor2()
    {
        return $this->belongsTo(User::class, 'assessor_2')->select('id', 'name', 'nip');
    }

    public function certificateRequest()
    {
        return $this->belongsTo(CertificateRequest::class);
    }

    public function assessors()
    {
        return $this->BelongsToMany(User::class, 'interview_assessors', 'assessment_interview_id', 'assessor')->whereNull('interview_assessors.deleted_at');
    }

    public function interview_assessors()
    {
        return $this->assessors()->whereNull('deleted_at');
    }
}