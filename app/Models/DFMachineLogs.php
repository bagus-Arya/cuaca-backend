<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DFMachineLogs extends Model
{
    use HasFactory;

    protected $table = 'dft_machine_logs';
    
    protected $guarded = ['id'];

    protected $fillable = [
        'machine_ID',
        'temp',
        'humid',
        'weight',
        'light'
    ];
}
