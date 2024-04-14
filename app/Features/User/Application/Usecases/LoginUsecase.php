<?php
namespace App\Features\User\Application\Usecases;

use App\Features\User\Domain\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginUsecase {

    private UserRepository $repository;


    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }


    public function execute(array $credentials, Request $request):array {

        $user = $this->repository->login($credentials);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return array(
            "user" => $user,
            "token" => $token,
            "tokenResult" => $tokenResult
        );
    }

}