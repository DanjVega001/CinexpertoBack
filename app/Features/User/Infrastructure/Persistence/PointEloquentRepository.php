<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Application\Usecases\User\GetUserUsecase;
use App\Features\User\Domain\Repositories\PointRepository;
use App\Models\Point;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class PointEloquentRepository implements PointRepository 
{

    public function getClassification():mixed
    {
        return Point::orderBy('points', 'DESC')->get();
    }

    public function updatePoints(?int $userID, $points)
    {
        $user = $this->getUser($userID);
        $userPoints = $user->points->points;
        $user->points()->update(['points' => $userPoints + $points]);
    }

    private function getUser(?int $userID){
        if (!$userID) return Auth::user();
        else if (User::find($userID)) return User::find($userID);
        else throw new Exception("Usuario no encontrado");
    }
}

