<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class CreateTriviaUsecase {
    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(array $trivia) {
        $this->repository->createTrivia($trivia);
    }
}