<?php
namespace App\Features\Trivia\Domain\Repositories;

use App\Models\Trivia;

interface TriviaRepository {

    public function getLevels():mixed;

    public function getTriviasByLevelID(int $levelID):mixed;

    public function getTrivia(int $triviaID):mixed;

    public function completedTrivia(array $triviasCompleted, int $points):mixed;

    public function getPublishedTrivias(string $state):mixed;

    public function publishedTrivia(array $data);

    public function getAllTrivias():mixed;

    public function createTrivia(array $trivia);

    public function updateTrivia(array $trivia, int $triviaID);

    public function deleteTrivia(int $triviaID);
}