<?php
namespace App\Features\User\Application\Usecases\Auth;

use App\Features\User\Domain\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class LogoutUsecase {

    private UserRepository $repository;


    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }


    public function execute(Request $request) {
        $user =  $request->user();
        if (!$user) {
            throw new Exception("No hay usuario logueado");
        }
        $user->token()->revoke();
        $this->repository->logout($request->user()->token()->id);
    }

}