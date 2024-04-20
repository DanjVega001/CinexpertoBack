<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\CreateTriviaUsecase;
use App\Features\Trivia\Application\Usecases\DeleteTriviaUsecase;
use App\Features\Trivia\Application\Usecases\GetAllTrivias;
use App\Features\Trivia\Application\Usecases\UpdateTriviaUsecase;
use App\Features\Trivia\Application\Usecases\ValidateTriviaUsecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private GetAllTrivias $getAllTrivias;
    private CreateTriviaUsecase $createTriviaUsecase;
    private UpdateTriviaUsecase $updateTriviaUsecase;
    private DeleteTriviaUsecase $deleteTriviaUsecase;
    private ValidateTriviaUsecase $validateTriviaUsecase;

    public function __construct(GetAllTrivias $getAllTrivias, CreateTriviaUsecase $createTriviaUsecase, 
        UpdateTriviaUsecase $updateTriviaUsecase, DeleteTriviaUsecase $deleteTriviaUsecase, 
        ValidateTriviaUsecase $validateTriviaUsecase)
    {
        $this->getAllTrivias = $getAllTrivias;
        $this->createTriviaUsecase = $createTriviaUsecase;
        $this->updateTriviaUsecase = $updateTriviaUsecase;
        $this->deleteTriviaUsecase = $deleteTriviaUsecase;
        $this->validateTriviaUsecase = $validateTriviaUsecase;
    }


    public function getAllTrivias(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'isPublished' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }
            $result = $this->getAllTrivias->execute($request->isPublished);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }      
    }

    public function createTrivia(Request $request)
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


            $this->createTriviaUsecase->execute($request->all());
            return response()->json(["message" => "Trivia creada correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function updateTrivia(Request $request, $triviaID)
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
            $this->updateTriviaUsecase->execute($request->all(), $triviaID);
            return response()->json(["message" => "Trivia actualizada correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteTrivia($triviaID)
    {
        try {
            $this->deleteTriviaUsecase->execute($triviaID);
            return response()->json(["message" => "Trivia eliminada correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    

    public function validateTrivia(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'state' => 'required|string',
                'trivia_id' => 'required',
                'comment' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }
            $this->validateTriviaUsecase->execute($request->all());
            return response()->json(["message" => "Trivia validada correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
