<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class GetPublishedTriviasUsecase {
    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(string $state):mixed {
        return $this->repository->getPublishedTrivias($state);
    }
}