<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedTrivia extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'pointsEarned',
        'trivia_id',
        'user_id',
    ];

    public function trivia()
    {
        return $this->belongsTo(Trivia::class, 'trivia_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
