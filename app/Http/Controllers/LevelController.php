<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\GetLevelsUsecase;
use Exception;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    private GetLevelsUsecase $getLevelsUsecase;

    public function __construct(GetLevelsUsecase $getLevelsUsecase)
    {
        $this->getLevelsUsecase = $getLevelsUsecase;
    }

    public function getLevels()
    {
        try {
            $result = $this->getLevelsUsecase->execute();
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
