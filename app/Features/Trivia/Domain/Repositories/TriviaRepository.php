<?php
namespace App\Features\Trivia\Domain\Repositories;

interface TriviaRepository {

    public function getLevels():mixed;

    public function getTriviasByLevelID(int $levelID):mixed;

    public function getTrivia(int $triviaID):mixed;

    public function completedTrivia(array $triviasCompleted, int $points);
}