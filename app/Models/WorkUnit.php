<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function eselon1()
    {
        return $this->belongsTo(WorkUnit::class, 'work_unit_level_1_id');
    }

    public function eselon2()
    {
        return $this->belongsTo(WorkUnit::class, 'work_unit_level_2_id');
    }

    public function serviceTypes()
    {
        return $this->belongsToMany(ServiceType::class, 'work_unit_has_services', 'work_unit_id', 'service_type_id')->whereNull('work_unit_has_services.deleted_at');
    }
}
