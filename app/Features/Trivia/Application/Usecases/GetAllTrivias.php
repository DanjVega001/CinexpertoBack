<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class GetAllTrivias {
    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute():mixed {
        return $this->repository->getAllTrivias();
    }
    
}