<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ppkketiga extends Model
{
    use HasFactory;

    protected $table = 'formppk3';

    protected $fillable = [
        'id_formppk',
        'verifikasi',
        'tinjauan',
        'status',
        'newppk',
        'verifikasi_img',
    ];


    public function formppk3()
    {
        return $this->hasOne(Ppkketiga::class, 'id_formppk');
    }
    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic');
    }

    public function pic1User()
    {
        return $this->belongsTo(User::class, 'pic1');
    }

    public function pic2User()
    {
        return $this->belongsTo(User::class, 'pic2');
    }
    // Pastikan kolom target_tgl di-cast sebagai tanggal
    protected $dates = ['target_tgl'];
}
