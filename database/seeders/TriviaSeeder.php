<?php

namespace Database\Seeders;

use App\Models\Trivia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TriviaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trivia::create([
            'question' => '¿Quién ganó el Oscar al Mejor Actor por su papel en la película "El Padrino"?',
            'answerCorrect' => 'Marlon Brando',
            'answerOne' => 'Al Pacino',
            'answerTwo' => 'Robert De Niro',
            'answerThree' => 'Jack Nicholson',
            'isPublished' => true,
            'level_id' => 1,
        ]);


        Trivia::create([
            'question' => '¿Qué película ganó el premio a la Mejor Película en los Premios de la Academia en 1994?',
            'answerCorrect' => 'La lista de Schindler',
            'answerOne' => 'Forrest Gump',
            'answerTwo' => 'El Rey León',
            'answerThree' => 'Pulp Fiction',
            'isPublished' => true,
            'level_id' => 1,
        ]);
        
        // Crear y guardar la tercera trivia
        Trivia::create([
            'question' => '¿Quién dirigió la película "El Resplandor" basada en la novela de Stephen King?',
            'answerCorrect' => 'Stanley Kubrick',
            'answerOne' => 'Alfred Hitchcock',
            'answerTwo' => 'Steven Spielberg',
            'answerThree' => 'Martin Scorsese',
            'isPublished' => true,
            'level_id' => 1,
        ]);
        
        // Crear y guardar la cuarta trivia
        Trivia::create([
            'question' => '¿Cuál es el título original de la película "El Laberinto del Fauno"?',
            'answerCorrect' => 'El Laberinto del Fauno',
            'answerOne' => 'The Dark Labyrinth',
            'answerTwo' => 'Pan\'s Labyrinth',
            'answerThree' => 'The Enchanted Forest',
            'isPublished' => true,
            'level_id' => 1,
        ]);
        
        // Crear y guardar la quinta trivia
        Trivia::create([
            'question' => '¿Qué actor interpretó a Neo en la trilogía de "Matrix"?',
            'answerCorrect' => 'Keanu Reeves',
            'answerOne' => 'Tom Cruise',
            'answerTwo' => 'Brad Pitt',
            'answerThree' => 'Will Smith',
            'isPublished' => true,
            'level_id' => 1,
        ]);

    }
}
