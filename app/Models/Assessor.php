<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessor extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'nip');
    }
}
