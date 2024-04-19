<?php
namespace App\Features\User\Application\Usecases\User;

use App\Features\User\Domain\Repositories\ProfileRepository;

class GetAllUsersUsecase {
    private ProfileRepository $repository;

    public function __construct(ProfileRepository $repository) {
        $this->repository = $repository;
    }

    public function execute():mixed {
        return $this->repository->getAllUsers();
    }
}