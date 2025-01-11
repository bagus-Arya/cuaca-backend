<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTDevice extends Model
{
    use HasFactory;
    protected $table = 'nt_machine_staff';
    protected $guarded = ['id'];
    protected $fillable = [
        'host_id',
        'group_staff_fishermans_id'
    ];
    
    public function machineLog()
    {
        return $this->belongsTo(NTExDevices::class,'host_id', 'id');
    }

    public function sosLogs()
    {
        return $this->belongsTo(UserSosLog::class,'host_id', 'id');
    }

    public function groupStaffFisherman()
    {
        return $this->belongsTo(NTGroupUsers::class, 'group_staff_fishermans_id');
    }
}
