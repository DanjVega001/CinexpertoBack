<?php
namespace App\Features\Trivia\Infrastructure\Persistence;

use App\Features\Trivia\Application\Services\TriviaService;
use App\Features\Trivia\Domain\Repositories\TriviaRepository;
use App\Features\User\Application\Usecases\Points\UpdatePointsUsecase;
use App\Models\Level;
use App\Models\PublishedTrivia;
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
            ->select('pivot', 'id', 'level_id'), $levelID);
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
            "level_id" => $trivia->level_id
        ];
    }

    public function completedTrivia(array $triviasCompleted, int $points):mixed
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
        return $this->updatePointsUsecase->execute($user->id, $points);
    }

    public function getUser(?int $userID): User
    {
        if (!$userID) return Auth::user();
        else if (User::find($userID)) return User::find($userID);
        else throw new Exception("Usuario no encontrado");
    }

    public function getPublishedTrivias(string $state):mixed
    {
        $user = Auth::user();
        $trivias = PublishedTrivia::with("trivia")->where("state", $state)->where("user_id", $user->id);
        $data = array();
        foreach ($trivias->get() as $trv) {
            array_push($data, [
                "id" => $trv->id,
                "trivia_id" => $trv->trivia_id,
                "question" => $trv->trivia->question,
            ]);
        }
        return $data;
    }

    public function publishedTrivia(array $data)
    {
        $user = Auth::user();
        $triviaID = $this->saveTrivia($data);
        $this->savePublishedTrivia($triviaID, $user->id);
    }

    private function saveTrivia(array $data): int
    {
        $trivia = new Trivia();
        $trivia->question = $data["question"];
        $trivia->answerCorrect = $data["answerCorrect"];
        $trivia->answerOne = $data["answerOne"];
        $trivia->answerTwo = $data["answerTwo"];
        $trivia->answerThree = $data["answerThree"];
        $trivia->isPublished = false;
        $trivia->level_id = $data["level_id"];
        $trivia->save();
        return $trivia->id;
    }

    private function savePublishedTrivia(int $triviaID, int $userID)
    {
        $publishedTrivia = new PublishedTrivia();
        $publishedTrivia->state = "pendiente";
        $publishedTrivia->pointsEarned = 4000;
        $publishedTrivia->user_id = $userID;
        $publishedTrivia->trivia_id = $triviaID;
        $publishedTrivia->save();
    }

    public function getAllTrivias(bool $isPublished):mixed
    {
        return Trivia::with('publishedTrivia')->where('isPublished', $isPublished)->paginate(10);
    }

    public function createTrivia(array $trivia)
    {   
        $newTrivia = new Trivia($trivia);
        $newTrivia->isPublished = true;
        $newTrivia->save();
    }

    public function updateTrivia(array $trivia, int $triviaID)
    {
        $triviaUpdated = Trivia::find($triviaID);
        if (!$trivia) throw new Exception("Trivia no encontrada");
        $triviaUpdated->question = $trivia["question"];
        $triviaUpdated->answerCorrect = $trivia["answerCorrect"];
        $triviaUpdated->answerOne = $trivia["answerOne"];
        $triviaUpdated->answerTwo = $trivia["answerTwo"];
        $triviaUpdated->answerThree = $trivia["answerThree"];
        $triviaUpdated->level_id = $trivia["level_id"];
        $triviaUpdated->save();
    }

    public function deleteTrivia(int $triviaID)
    {
        $trivia = Trivia::find($triviaID);
        if (!$trivia) throw new Exception("Trivia no encontrada");
        $trivia->delete();
    }

    public function validateTrivia(array $data)
    {
        $trivia = Trivia::find($data["trivia_id"]);
        $publishedTrivia =  $trivia->publishedTrivia;
        if (!$publishedTrivia) throw new Exception("Trivia no encontrada");
        $publishedTrivia->state = $data["state"];
        if ($data["state"] == "rechazada"){ 
            $publishedTrivia->comment = $data["comment"];
        } else {
            $trivia->isPublished = true;
            $trivia->save();
        }
        $publishedTrivia->save();
    }
}
