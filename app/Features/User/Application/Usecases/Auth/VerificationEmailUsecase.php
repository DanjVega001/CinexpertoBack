<?php
namespace App\Features\User\Application\Usecases\Auth;


use App\Mail\VerificationEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationEmailUsecase {


    public function execute(Request $request) {

        if (User::where('email', $request->email)->exists()) {
            throw new Exception("Email ya existe");
        }

        if (User::where('name', $request->name)->exists()) {
            throw new Exception("Username ya existe");
        }

        $code = rand(100000, 999999);
        Mail::to($request->email)->send(new VerificationEmail($code));
        return $code;
    }

}