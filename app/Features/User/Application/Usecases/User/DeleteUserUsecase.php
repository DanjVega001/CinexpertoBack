<?php
namespace App\Features\User\Application\Usecases\User;

use App\Features\User\Domain\Repositories\ProfileRepository;

class DeleteUserUsecase {
    private ProfileRepository $repository;

    public function __construct(ProfileRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(int $userID):void {
        $this->repository->deleteUser($userID);
    }
}