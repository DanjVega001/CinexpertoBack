<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class GetTriviaUsecase {

    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $triviaID):mixed {
        return $this->repository->getTrivia($triviaID);
    }
}