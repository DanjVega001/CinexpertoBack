<?php
namespace App\Features\Trivia\Infrastructure\Persistence;

use App\Features\Trivia\Application\Services\TriviaService;
use App\Features\Trivia\Domain\Repositories\TriviaRepository;
use App\Features\User\Application\Usecases\Points\UpdatePointsUsecase;
use App\Features\User\Application\Usecases\User\GetUserUsecase;
use App\Models\Level;
use App\Models\Trivia;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TriviaEloquentRepository implements TriviaRepository {
    
    private TriviaService $triviaService;
    private UpdatePointsUsecase $updatePointsUsecase;

    public function __construct(TriviaService $triviaService, 
        UpdatePointsUsecase $updatePointsUsecase)
    {
        $this->triviaService = $triviaService;
        $this->updatePointsUsecase = $updatePointsUsecase;
    }

    public function getLevels():mixed
    {
        return Level::all();
    }

    public function getTriviasByLevelID(int $levelID):mixed
    {
        $user = $this->getUser(null);
        $trivias = Trivia::select("id AS trivia_id")->where('level_id', $levelID)
            ->where('isPublished', true)->get();
        return $this->triviaService->getTriviasByLevelID($trivias, $user->trivias
            ->select('pivot', 'id'));
    }

    public function getTrivia(int $triviaID):mixed
    {
        $trivia = Trivia::find($triviaID);
    
        return [
            "id" => $trivia->id,
            "question" => $trivia->question,
            "answerCorrect" => $trivia->answerCorrect,
            "answerOne" => $trivia->answerOne,
            "answerTwo" => $trivia->answerTwo,
            "answerThree" => $trivia->answerThree,
            "pointsEarned" => $trivia->level->pointsEarned,
        ];
    }

    public function completedTrivia(array $triviasCompleted, int $points):void
    {
        $user = Auth::user();
        foreach ($triviasCompleted as $triviaCompleted) {
            if (DB::table('trivia_user')->where('trivia_id', '=', $triviaCompleted["id"])
                ->where("user_id", '=', $user->id)->exists()){
                throw new Exception("Ya has completado esta/s trivia. Tramposo!");
            }

            $trivia = Trivia::find($triviaCompleted["id"]);
            $trivia->users()->attach($user->id, ["state" => $triviaCompleted["state"]]);
        }
        $this->updatePointsUsecase->execute($user->id, $points);
    }

    public function getUser(?int $userID): User
    {
        if (!$userID) return Auth::user();
        else if (User::find($userID)) return User::find($userID);
        else throw new Exception("Usuario no encontrado");
    }
}
