<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trivia extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answerCorrect',
        'answerOne',
        'answerTwo',
        'answerThree',
        'isPublished',
        'level_id',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'trivia_user');
    }

    public function publishedTrivia()
    {
        return $this->hasOne(PublishedTrivia::class, 'trivia_id');
    }

}
