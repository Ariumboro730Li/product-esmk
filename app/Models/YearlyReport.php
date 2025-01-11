<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyReport extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function dispositionBy()
    {
        return $this->belongsTo(User::class, 'disposition_by');
    }
    public function dispositionTo()
    {
        return $this->belongsTo(User::class, 'disposition_to');
    }
}
