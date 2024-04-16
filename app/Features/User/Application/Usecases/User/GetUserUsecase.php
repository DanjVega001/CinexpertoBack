<?php
namespace App\Features\User\Application\Usecases\User;

use App\Features\User\Domain\Repositories\ProfileRepository;
use App\Models\User;

class GetUserUsecase {

    private ProfileRepository $repository;

    public function __construct(ProfileRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(?int $userID):User {
        return $this->repository->getUser($userID);
    }

}