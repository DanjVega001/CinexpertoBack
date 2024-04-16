<?php
namespace App\Features\User\Application\Usecases\Points;

use App\Features\User\Domain\Repositories\PointRepository;

class UpdatePointsUsecase {
    private PointRepository $repository;

    public function __construct(PointRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(?int $userID, int $points) {
        $this->repository->updatePoints($userID, $points);
    }
}