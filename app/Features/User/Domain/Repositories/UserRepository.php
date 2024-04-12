<?php
namespace App\Features\User\Domain\Repositories;

use App\Features\User\Domain\Entities\User;

interface UserRepository {

    public function register(User $user);

}