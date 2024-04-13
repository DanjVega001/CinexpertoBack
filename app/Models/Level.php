<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'nameLevel',
        'pointsEarned',
    ];

    public function trivias()
    {
        return $this->hasMany(Trivia::class, 'level_id');
    }
}
