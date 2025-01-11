<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\KeyGenerate;

class Notification extends Model
{
    use HasFactory, KeyGenerate;

    protected $table        = 'notifications';

    protected $primaryKey   = 'id';

    public $incrementing    = false;

    public $timestamps      = true;

    protected $fillable = [
        'id',
        'topic',
        'type',
        'user_id',
        'path_url',
        'title',
        'description',
        'data',
        'delivery_at',
        'read_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'delivery_at' => 'datetime'
    ];
}
