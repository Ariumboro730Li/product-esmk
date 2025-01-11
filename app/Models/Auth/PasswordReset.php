<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table        = 'password_reset_tokens';

    public $incrementing    = false;

    public $timestamps      = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

}
