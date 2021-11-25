<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    const IMPORTED = 'IMPORTED';
    const REJECTED = 'REJECTED';
    const CORRECTED = 'CORRECTED_AND_IMPORTED';

    public function scopeImportedWithCorrected(Builder $query)
    {
        $query->whereIn('status', [PhoneNumber::IMPORTED, PhoneNumber::CORRECTED]);
    }

    public function scopeImported(Builder $query)
    {
        $query->where('status', PhoneNumber::IMPORTED);
    }

    public function scopeCorrected(Builder $query)
    {
        $query->where('status', PhoneNumber::CORRECTED);
    }

    public function scopeRejected(Builder $query)
    {
        $query->where('status', PhoneNumber::REJECTED);
    }
}
