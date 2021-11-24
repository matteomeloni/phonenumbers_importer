<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'status',
        'status_description'
    ];

    const IMPORTED = 'imported';
    const REJECTED = 'rejected';
    const CORRECTED = 'corrected';
}
