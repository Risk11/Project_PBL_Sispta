<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasis';

    protected $fillable = ['judul', 'isi', 'user_id'];
    public function usernotifikasi()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}

