<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTDetailSosLogs extends Model
{
    use HasFactory;

    protected $table = 'add_nt_sos_details';
    protected $guarded = ['id'];
    protected $fillable = [
        'lat',
        'lng',
        'group_staff_fishermans_id',
    ];
}
