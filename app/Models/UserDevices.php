<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevices extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function deviceLogs()
    {
        return $this->hasMany(DeviceLogs::class, 'machine_id');
    }
}
