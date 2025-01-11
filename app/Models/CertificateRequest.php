<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function certificateRequestAssessments()
    {
        return $this->hasMany(CertificateRequestAssessment::class)->orderBy('created_at', 'asc');
    }

    public function assessmentInterviews()
    {
        return $this->hasMany(AssessmentInterview::class)->where('is_active', true)->orderBy('created_at', 'desc');
    }

    public function dispositionBy()
    {
        return $this->belongsTo(User::class, 'disposition_by');
    }

    public function dispositionTo()
    {
        return $this->belongsTo(User::class, 'disposition_to');
    }

    public function smkCertificate()
    {
        return $this->hasMany(CertificateSmk::class, 'company_id');
    }
}
