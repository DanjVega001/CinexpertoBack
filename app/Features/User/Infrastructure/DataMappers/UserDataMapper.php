<?php
namespace App\Features\User\Infrastructure\DataMappers;

use App\Features\User\Domain\Entities\User;
use App\Models\User as UserModel;

class UserDataMapper {

    public function mapToEntity(array $userModel):User
    {
        $user = new User(
            $userModel["name"],
            $userModel["email"],
            $userModel["password"]
        );
        return $user;
    }

    public function modelToEntity(UserModel $userModel):User
    {
        $user = new User(
            $userModel->name,
            $userModel->email,
            $userModel->password
        );
        return $user;
    }

    public function mapToModel(User $user):UserModel
    {
        $userModel = new UserModel();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();
        return $userModel;
    }
}
