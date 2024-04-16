<?php
namespace App\Features\Trivia\Infrastructure\Persistence;

use App\Features\Trivia\Application\Services\TriviaService;
use App\Features\Trivia\Domain\Repositories\TriviaRepository;
use App\Features\User\Application\Usecases\User\GetUserUsecase;
use App\Models\Level;
use App\Models\Trivia;

class TriviaEloquentRepository implements TriviaRepository {
    
    private GetUserUsecase $getUserUsecase;
    private TriviaService $triviaService;

    public function __construct(GetUserUsecase $getUserUsecase, TriviaService $triviaService)
    {
        $this->getUserUsecase = $getUserUsecase;
        $this->triviaService = $triviaService;
    }

    public function getLevels():mixed
    {
        return Level::all();
    }

    public function getTriviasByLevelID(int $levelID):mixed
    {
        $user = $this->getUserUsecase->execute(null);
        $trivias = Trivia::select("id AS trivia_id")->where('level_id', $levelID)->get();
        return $this->triviaService->getTriviasByLevelID($trivias, $user->trivias
            ->select('pivot', 'id'));
    }
}
