<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vacancy extends Model
{

    protected $fillable = [
        'title',
        'description',
        'salary',
        'experience',
        'skills',
        'university_name',
        'university_rate',
        'university_type',
        'application_rating'
    ];
    use HasFactory;
}
