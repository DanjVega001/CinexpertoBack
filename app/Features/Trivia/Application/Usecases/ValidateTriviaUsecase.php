<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class ValidateTriviaUsecase {

    private TriviaRepository $repository;

    public function __construct(TriviaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data)
    {
        $this->repository->validateTrivia($data);
    }
}