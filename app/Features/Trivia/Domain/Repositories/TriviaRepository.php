<?php
namespace App\Features\Trivia\Domain\Repositories;

interface TriviaRepository {

    public function getLevels():mixed;

    public function getTriviasByLevelID(int $levelID):mixed;
}