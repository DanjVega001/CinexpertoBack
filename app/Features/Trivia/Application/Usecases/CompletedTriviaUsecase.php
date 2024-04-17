<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class CompletedTriviaUsecase {

    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(array $triviasCompleted, int $points):mixed {
        return $this->repository->completedTrivia($triviasCompleted, $points);
    }
}