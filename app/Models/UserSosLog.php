<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSosLog extends Model
{
    use HasFactory;

    protected $table = 'nt_sos_logs';
    protected $guarded = ['id'];
    protected $fillable = [
        'lat',
        'lng',
        'host_id'
    ];

    public function users() {
        return $this -> belongsTo(NTGroupUsers::class, 'group_fishermans_id');
    }
}
