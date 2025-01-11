<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NibOss extends Model
{
    use HasFactory;

    protected $table = 'nib_oss';

    protected $fillable = [
        'nib',
        'data_nib',
    ];

    protected $casts = [
        'data_nib' => 'json'
    ];
}
