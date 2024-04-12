<?php

namespace App\Http\Controllers;

use App\Features\User\Application\Usecases\LoginUsecase;
use App\Features\User\Application\Usecases\LogoutUsecase;
use App\Features\User\Application\Usecases\RegisterUserUsecase;
use App\Features\User\Application\Usecases\VerificationEmailUsecase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private RegisterUserUsecase $registerUserUsecase;
    private LoginUsecase $loginUsecase;
    private LogoutUsecase $logoutUsecase;
    private VerificationEmailUsecase $verificationEmailUsecase;

    public function __construct(RegisterUserUsecase $registerUserUsecase, LoginUsecase $loginUsecase,
        LogoutUsecase $logoutUsecase, VerificationEmailUsecase $verificationEmailUsecase)
    {
        $this->registerUserUsecase = $registerUserUsecase;
        $this->loginUsecase = $loginUsecase;
        $this->logoutUsecase = $logoutUsecase;
        $this->verificationEmailUsecase = $verificationEmailUsecase;
    }

    public function login (Request $request) 
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            $credentials = request(['email', 'password']);

            $response = $this->loginUsecase->execute($credentials, $request);

            return response()->json([
                'user' => $response["user"],
                'access_token' => $response["tokenResult"]->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($response["token"]->expires_at)->toDateTimeString()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }  
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

    public function logout(Request $request)
    {
        try {
            $this->logoutUsecase->execute($request);

            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }    
    }

    public function sendVerificationEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
            ]);

            $code = $this->verificationEmailUsecase->execute($request);

            return response()->json([
                'message' => 'Mail sent',
                'code' => $code
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }    
        
    }
}