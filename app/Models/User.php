<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guard = 'employee';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'info_company' => 'json',

        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function certificate_request_disposisition()
    {
        return $this->hasMany(CertificateRequest::class, 'disposition_to');
    }

    public function certificate_request_disposition_process()
    {
        return $this->hasMany(CertificateRequest::class, 'disposition_to')
            ->whereIn(
                'status',
                [
                    'disposition',
                    'not_passed_assessment',
                    'submission_revision',
                    'passed_assessment',
                    'not_passed_assessment_verification',
                    'need_recheck_assessment',
                    'passed_assessment_verification',
                    'scheduling_interview',
                    'scheduled_interview',
                    'completed_interview',
                    'verification_director'
                ]
            );
    }


    // current use 'interview_completed' to show total of completed
    public function certificate_request_completed()
    {
        return $this->hasMany(CertificateRequest::class, 'disposition_to')
            ->where('status', 'certificate_validation');
    }

    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class, 'work_unit_id');
    }

    // Add these two methods
    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
}
