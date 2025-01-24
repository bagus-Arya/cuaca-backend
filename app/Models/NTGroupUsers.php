<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Laravel\Sanctum\HasApiTokens;

class NTGroupUsers extends Authenticatable 
{
    use HasFactory, HasApiTokens; 

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

    // Hash the password when setting it
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Hide the password attribute when converting to array or JSON
    protected $hidden = ['password'];

    public function group()
    {
        return $this->belongsTo(NTGroup::class, 'group_fishermans_id');
    }
}