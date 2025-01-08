<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTGroupUsers extends Model
{
    use HasFactory;

    protected $table = 'group_staff_fishermans';
    protected $guarded = ['id'];
    protected $fillable = [
        'staff_nm',
        'email',
        'addr',
        'no_hp',
        'role',
        'password',
        'group_fishermans_id',
    ];

    public function groupUsers()
    {
        return $this->belongsTo(NTGroup::class, 'group_fishermans_id');
    }

}
