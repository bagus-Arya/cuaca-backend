<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTExDevices extends Model
{
    use HasFactory;

    protected $table = 'nt_devices_list';
    protected $guarded = ['id'];
    protected $fillable = [
        'host_id',
    ];
}
