<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Domain\Entities\User;
use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Models\User as ModelsUser;

class UserEloquentRepository implements UserRepository {
    
    private UserDataMapper $userMapper;

    public function __construct(UserDataMapper $userMapper)
    {   
        $this->userMapper = $userMapper;
    }

    public function register(User $user) 
    {
        $userModel = $this->userMapper->mapToModel($user);
        $userModel->save();
    }
}