<?php

namespace App\Http\Controllers;

use App\Features\User\Application\Usecases\RegisterUserUsecase;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private RegisterUserUsecase $registerUserUsecase;

    public function __construct(RegisterUserUsecase $registerUserUsecase)
    {
        $this->registerUserUsecase = $registerUserUsecase;
    }


    public function signUp(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }
    
            $this->registerUserUsecase->execute($request->all());

            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }   
    }
}