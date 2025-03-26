<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nisn',
        'nis',
        'class_id',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'address',
        'phone',
        'photo',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
    ];

    protected $casts = [
        'photo' => 'array',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
