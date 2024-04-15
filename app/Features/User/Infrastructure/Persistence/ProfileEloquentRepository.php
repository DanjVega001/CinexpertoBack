<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Application\Services\UserService;
use App\Features\User\Application\Usecases\User\GetClassificationUsecase;
use App\Features\User\Domain\Repositories\PointRepository;
use App\Features\User\Domain\Repositories\ProfileRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Models\Point;
use App\Models\Rank;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileEloquentRepository implements ProfileRepository{

    private UserService $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function getUser(?int $userID): User
    {
        if (!$userID) return Auth::user();
        else if (User::find($userID)) return User::find($userID);
        else throw new Exception("Usuario no encontrado");
    }

    public function getProfile(?int $userID):array {
        $user = $this->getUser($userID);
        return $this->userService->getProfile($user);
    }

}