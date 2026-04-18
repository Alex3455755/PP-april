<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
    'chat_id',
    'text',
    'filePath',
    'user_id'
];

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
