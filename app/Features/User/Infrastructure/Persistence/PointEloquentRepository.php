<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Domain\Repositories\PointRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Models\Point;
use App\Models\Rank;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointEloquentRepository implements PointRepository 
{

    private UserDataMapper $userMapper;

    public function __construct(UserDataMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    public function getClassification():mixed
    {
        return Point::orderBy('points', 'DESC')->get();
    }

    public function updatePoints(?int $userID, $points) : mixed
    {
        $user = $this->getUser($userID);
        $userPoints = $user->points->points;
        $points = $user->points()->update(['points' => $userPoints + $points]);
        return $this->verifyRankObtained($userID) ?? "Trivas guardadas correctamente";
    }

    private function verifyRankObtained($userID) : mixed
    {
        $user = $this->getUser($userID);
        $points = $user->points->points;
        $ranks = Rank::all();
        $arrayFilter = array_filter($ranks->toArray(), function ($r) use ($points) {
            return $points >= $r["pointsRequired"];
        });
        $ultimateRank = $arrayFilter[count($arrayFilter)-1];
        if ($this->hasRank($user->id, $ultimateRank["id"])) {
            return null;
        }
        for ($i=1; $i <= $ultimateRank["id"]; $i++) { 
            if (!$this->hasRank($user->id, $i)) {
                $user->ranks()->attach($i);            
            }
        }      
        return "Has obtenido un nuevo rango. Ve a mirar cual es";
    }

    private function hasRank(int $userID, int $rankID) : bool {
        return  DB::table('rank_user')->where("user_id", "=", $userID)->where('rank_id', '=', 
        $rankID)->exists();
    }

    private function getUser(?int $userID){
        if (!$userID) return Auth::user();
        else if (User::find($userID)) return User::find($userID);
        else throw new Exception("Usuario no encontrado");
    }

    public function getClassificationWithUser():mixed
    {
        $classification = Point::orderBy('points', 'DESC')->get();
        $data = array();
        foreach ($classification as $item) {
            $userEntity = $this->userMapper->modelToEntity($item->user);
            array_push($data, [
                "id" => $item->id,
                "points" => $item->points,
                "user_id" => $item->user->id,
                "urlProfileImage" => $item->user->profileImage,
                "userName" => $userEntity->getName(),
                "nameRank" => $userEntity->getUltimateNameRank($item->user)
            ]);
        }
        return $data;
    }
}

