<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Application\Services\UserService;
use App\Features\User\Domain\Repositories\ProfileRepository;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function getAllUsers():mixed {
        return User::where("role_id", "=", 2)->get();
    }

    public function deleteUser(int $userID)
    {
        $user = User::find($userID);
        if (!$user) throw new Exception("Usuario no encontrado");
        $points = $user->points;
        $points->delete();
        $user->delete();
    }

    public function updateProfile(array $data)
    {
        $user = $this->getUser(null);
        if (isset($data["newPassword"]) && isset($data["newPassword"])) {

            if (Hash::check($data["oldPassword"], $user->password)) {
                $user->password = Hash::make($data["newPassword"]);
            } else {
                throw new Exception("Contraseña incorrecta");
            }
        }
        if (isset($data["profileImage"])) {
            $user->profileImage = $data["profileImage"];
        }
        $user->name = $data["name"];
        $user->save();
    }

}