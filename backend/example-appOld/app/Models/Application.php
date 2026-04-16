<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'name',
        'email',
        'age',
        'experience',
        'education',
        'rate',
        'college_id',
        'vacancie_id'
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancie_id');
    }
}