<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewAssessor extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing    = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];
    
    public function assessmentInterview()
    {
        return $this->belongsTo(AssessmentInterview::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor');
    }

    public function dispositionBy()
    {
        return $this->belongsTo(User::class, 'disposition_by');
    }
}