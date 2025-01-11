<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    public function company_service_types()
    {
        return $this->hasMany(CompanyServiceType::class);
    }

    public function companies()
    {
        return $this->BelongsToMany(Company::class, 'company_service_types');
    }


}
