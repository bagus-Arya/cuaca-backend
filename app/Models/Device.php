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
        'place_name',
        'suhu',
        'kecepatan_angin',
        'tekanan_udara',
        'kelembaban',
        'kondisi_baik',
        'active'
    ];

    public function deviceLogs()

    {
        return $this->hasMany(DeviceLog::class);
    }
}
