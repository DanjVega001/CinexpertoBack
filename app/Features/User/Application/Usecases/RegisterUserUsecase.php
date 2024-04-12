<?php
namespace App\Features\User\Application\Usecases;

use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;

class RegisterUserUsecase {

    private UserDataMapper $userMapper;
    private UserRepository $repository;


    public function __construct(UserDataMapper $userMapper, UserRepository $repository) {
        $this->userMapper = $userMapper;
        $this->repository = $repository;
    }

    public function execute(array $userModel) {
        $user = $this->userMapper->mapToEntity($userModel);

        $user->validateUser();

        $this->repository->register($user);
    }
    
}
