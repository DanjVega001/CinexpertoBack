<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\CompletedTriviaUsecase;
use App\Features\Trivia\Application\Usecases\GetAllTriviasUsecase;
use App\Features\Trivia\Application\Usecases\GetTriviaUsecase;
use Exception;
use Illuminate\Http\Request;

class TriviaController extends Controller
{
    private GetAllTriviasUsecase $getTriviasUsecase;
    private GetTriviaUsecase $getTriviaUsecase;
    private CompletedTriviaUsecase $completedTriviaUsecase;

    public function __construct(GetAllTriviasUsecase $getTriviasUsecase, GetTriviaUsecase $getTriviaUsecase,
        CompletedTriviaUsecase $completedTriviaUsecase)
    {
        $this->getTriviasUsecase = $getTriviasUsecase;
        $this->getTriviaUsecase = $getTriviaUsecase;
        $this->completedTriviaUsecase = $completedTriviaUsecase;
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
    
    public function getTrivia($triviaID)
    {
        try {
            return $this->getTriviaUsecase->execute($triviaID);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }     
    }

    public function completedTrivia(Request $request)
    {
        
        try {
            $this->completedTriviaUsecase->execute($request->completedTrivias, $request->points);
            return response()->json(["message" => "Trivas guardadas correctamente"]);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        } 
    }


}
