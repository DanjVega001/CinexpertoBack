<?php

namespace App\Features\Trivia\Application\Usecases;

use App\Features\Trivia\Domain\Repositories\TriviaRepository;

class GetAllTriviasUsecase {
    
    private TriviaRepository $repository;
    public function __construct(TriviaRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $levelID):mixed 
    {
        return $this->repository->getTriviasByLevelID($levelID);
    }

}