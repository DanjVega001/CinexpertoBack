<?php
namespace App\Features\User\Application\Usecases;

use App\Features\User\Domain\Repositories\ProfileRepository;

class GetProfileUsecase {

    private ProfileRepository $repository;

    public function __construct(ProfileRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(?int $userID):array {
        return $this->repository->getProfile($userID);
    }

}