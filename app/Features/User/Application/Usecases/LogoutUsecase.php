<?php
namespace App\Features\User\Application\Usecases;

use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class LogoutUsecase {

    private UserDataMapper $userMapper;
    private UserRepository $repository;


    public function __construct(UserRepository $repository, UserDataMapper $userDataMapper) {
        $this->repository = $repository;
        $this->userMapper = $userDataMapper;
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