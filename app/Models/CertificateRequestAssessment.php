<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateRequestAssessment extends Model
{
    use HasFactory;
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];
    public function assessment_interviews()
    {
        return $this->hasMany(AssessmentInterview::class, 'certificate_request_id', 'certificate_request_id');
    }

    public function certificate_request()
    {
        return $this->belongsTo(CertificateRequest::class);
    }
}
