<?php
namespace App\Features\User\Application\Usecases;


use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Mail\VerificationEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationEmailUsecase {


    public function execute(Request $request) {

        if (User::where('email', $request->email)->exists()) {
            throw new Exception("Email ya existe");
        }

        $code = rand(100000, 999999);
        Mail::to($request->email)->send(new VerificationEmail($code));
        return $code;
    }

}