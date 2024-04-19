<?php

namespace App\Http\Controllers;

use App\Features\Trivia\Application\Usecases\CreateTriviaUsecase;
use App\Features\Trivia\Application\Usecases\DeleteTriviaUsecase;
use App\Features\Trivia\Application\Usecases\GetAllTrivias;
use App\Features\Trivia\Application\Usecases\UpdateTriviaUsecase;
use App\Features\User\Application\Usecases\User\GetAllUsersUsecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private GetAllTrivias $getAllTrivias;
    private GetAllUsersUsecase $getAllUsersUsecase;
    private CreateTriviaUsecase $createTriviaUsecase;
    private UpdateTriviaUsecase $updateTriviaUsecase;
    private DeleteTriviaUsecase $deleteTriviaUsecase;

    public function __construct(GetAllTrivias $getAllTrivias, GetAllUsersUsecase $getAllUsersUsecase, 
        CreateTriviaUsecase $createTriviaUsecase, UpdateTriviaUsecase $updateTriviaUsecase, 
        DeleteTriviaUsecase $deleteTriviaUsecase)
    {
        $this->getAllTrivias = $getAllTrivias;
        $this->getAllUsersUsecase = $getAllUsersUsecase;
        $this->createTriviaUsecase = $createTriviaUsecase;
        $this->updateTriviaUsecase = $updateTriviaUsecase;
        $this->deleteTriviaUsecase = $deleteTriviaUsecase;
    }


    public function getAllTrivias()
    {
        try {
            $result = $this->getAllTrivias->execute();

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }      
    }

    public function getAllUsers()
    {
        try {
            $result = $this->getAllUsersUsecase->execute();
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
                'isPublished' => 'required',
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
}
