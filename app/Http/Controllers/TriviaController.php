<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\GetAllTriviasUsecase;
use Exception;
use Illuminate\Http\Request;

class TriviaController extends Controller
{
    private GetAllTriviasUsecase $getTriviasUsecase;

    public function __construct(GetAllTriviasUsecase $getTriviasUsecase)
    {
        $this->getTriviasUsecase = $getTriviasUsecase;
    }

    public function getTriviasByLevelID($levelID)
    {
        try {
            $result = $this->getTriviasUsecase->execute($levelID);
            return response()->json($result);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }     
    }
}
