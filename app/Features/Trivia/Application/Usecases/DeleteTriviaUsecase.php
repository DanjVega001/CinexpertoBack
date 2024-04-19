<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class DeleteTriviaUsecase {
    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $triviaID) {
        $this->repository->deleteTrivia($triviaID);
    }
}