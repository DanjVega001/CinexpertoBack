<?php
namespace App\Http\Controllers;

use App\Features\User\Application\Usecases\User\GetProfileUsecase;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private GetProfileUsecase $getProfileUsecase;

    public function __construct (GetProfileUsecase $getProfileUsecase)
    {
        $this->getProfileUsecase = $getProfileUsecase;
    }

    public function getProfile(Request $request)
    {
        try {

            $result = $this->getProfileUsecase->execute($request->userID);

            return response()->json($result);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }       
    }
}
