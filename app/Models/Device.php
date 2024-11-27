<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'lat',
        'lng',
        'suhu',
        'kecepatan_angin',
        'tekanan_udara',
        'kelembaban',
        'kondisi_baik',
        'active'
    ];
}
