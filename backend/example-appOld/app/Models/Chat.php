<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
    'token',
    'author_id',
    'interlocutor_id'
];

public function author()
{
    return $this->belongsTo(User::class, 'author_id');
}

public function interlocutor()
{
    return $this->belongsTo(User::class, 'interlocutor_id');
}
}
