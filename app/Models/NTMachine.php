<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTMachine extends Model
{
    use HasFactory;

    protected $table = 'nt_machine_logs';
    protected $guarded = ['id'];
    protected $fillable = [
        'host_id',
        'lat',
        'lng',
        'temp',
        'humidity',
        'pressure'
    ];
}
