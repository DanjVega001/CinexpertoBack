<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Domain\Repositories\ProfileRepository;
use App\Models\Point;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class ProfileEloquentRepository implements ProfileRepository{

    public function getProfile(?int $userID):array {
         
        $user = !$userID ? Auth::user() : User::find($userID);
        $nameRank = count($user->ranks)!=0 ? $user->ranks[count($user->ranks)-1]->nameRank : "Sin rango";
        $pointsUser = $user->points->points;
        $points = Point::orderBy('points', 'DESC')->get();
        $i = 0;
        foreach ($points as $point) {
            if ($point->id == $user->points->id) {
                break;
            } 
            $i++;
        }
        $numClassification = $i+1;        
        $numTriviaAnswered = count($user->trivias);
        $numTriviaPublished = 0;
        foreach ($user->publishedTrivias as $pt) {
            $pt->state == "aceptada" ? $numTriviaPublished++ : null;
        }

        $ranksUserIDS = array();
        foreach ($user->ranks as $urk) {
            array_push($ranksUserIDS, $urk->id);
        }

        $ranksUser=array();
        foreach (Rank::all() as $rank) {
            $rank->obtained = in_array($rank->id, $ranksUserIDS);
            array_push($ranksUser, $rank);
        }

        return [
            "name" => $user->name,
            "nameRank" => $nameRank,
            "points" => $pointsUser,
            'numClassification' => $numClassification,
            'numTriviaAnswered' => $numTriviaAnswered,
            'numTriviaPublished' => $numTriviaPublished,
            'ranks' => $ranksUser
        ];
    }

}