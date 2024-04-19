<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\CompletedTriviaUsecase;
use App\Features\Trivia\Application\Usecases\GetAllTriviasUsecase;
use App\Features\Trivia\Application\Usecases\GetPublishedTriviasUsecase;
use App\Features\Trivia\Application\Usecases\GetTriviaUsecase;
use App\Features\Trivia\Application\Usecases\PublishedTriviaUsecase;
use App\Features\User\Application\Usecases\Points\GetClassificationWithUserUsecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TriviaController extends Controller
{
    private GetAllTriviasUsecase $getTriviasUsecase;
    private GetTriviaUsecase $getTriviaUsecase;
    private CompletedTriviaUsecase $completedTriviaUsecase;
    private GetClassificationWithUserUsecase $getClassification;
    private GetPublishedTriviasUsecase $getPublishedTrivia;
    private PublishedTriviaUsecase $publishedTrivia;

    public function __construct(GetAllTriviasUsecase $getTriviasUsecase, GetTriviaUsecase $getTriviaUsecase,
        CompletedTriviaUsecase $completedTriviaUsecase, GetClassificationWithUserUsecase $getClassification, 
        GetPublishedTriviasUsecase $getPublishedTrivia, PublishedTriviaUsecase $completedPublishedTrivia)
    {
        $this->getTriviasUsecase = $getTriviasUsecase;
        $this->getTriviaUsecase = $getTriviaUsecase;
        $this->completedTriviaUsecase = $completedTriviaUsecase;
        $this->getClassification = $getClassification;
        $this->getPublishedTrivia = $getPublishedTrivia;
        $this->publishedTrivia = $completedPublishedTrivia;
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
            $result = $this->completedTriviaUsecase->execute($request->completedTrivias, $request->points);
            return response()->json(["message" => $result]);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        } 
    }

    public function getClassification()
    {   
        try {
            $result = $this->getClassification->execute();
            return response()->json($result);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        } 
    }

    public function getPublishedTrivias(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'state' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            $result = $this->getPublishedTrivia->execute($request->state);
            return response()->json($result);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function publishedTrivia(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'question' => 'required|string',
                'answerCorrect' => 'required|string',
                'answerOne' => 'required|string',
                'answerTwo' => 'required|string',
                'answerThree' => 'required|string',
                'level_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }


            $this->publishedTrivia->execute($request->all());
            return response()->json(["message" => "Trivia publicada con estado 'pendiente'"]);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
