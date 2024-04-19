<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class UpdateTriviaUsecase {
    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $trivia, int $triviaID)
    {
        $this->repository->updateTrivia($trivia, $triviaID);
    }
}