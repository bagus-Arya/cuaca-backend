<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTGroup extends Model
{
    use HasFactory;

    protected $table = 'group_fishermans';
    protected $guarded = ['id'];
    protected $fillable = [
        'group_nm',
        'addr',
    ];

    public function groupUser()
    {
        return $this->hasMany(NTGroupUsers::class, 'group_fishermans_id');
    }
}
