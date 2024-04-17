<?php
namespace App\Features\User\Application\Usecases\Points;

use App\Features\User\Domain\Repositories\PointRepository;

class GetClassificationWithUserUsecase {
    private PointRepository $repository;

    public function __construct(PointRepository $repository) {
        $this->repository = $repository;
    }

    public function execute():mixed {
        return $this->repository->getClassificationWithUser();
    }
}