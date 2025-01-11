<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'service_type_id',
    ];
}
