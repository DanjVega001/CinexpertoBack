<?php
namespace App\Http\Controllers;

use App\Features\User\Application\Usecases\User\DeleteUserUsecase;
use App\Features\User\Application\Usecases\User\GetAllUsersUsecase;
use App\Features\User\Application\Usecases\User\GetProfileUsecase;
use App\Features\User\Application\Usecases\User\UpdateUserUsecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private GetProfileUsecase $getProfileUsecase;
    private DeleteUserUsecase $deleteUserUsecase;
    private GetAllUsersUsecase $getAllUsersUsecase;
    private UpdateUserUsecase $updateUserUsecase;

    public function __construct (GetProfileUsecase $getProfileUsecase, DeleteUserUsecase $deleteUserUsecase, 
        GetAllUsersUsecase $getAllUsersUsecase, UpdateUserUsecase $updateUserUsecase)
    {
        $this->getProfileUsecase = $getProfileUsecase;
        $this->deleteUserUsecase = $deleteUserUsecase;
        $this->getAllUsersUsecase = $getAllUsersUsecase;
        $this->updateUserUsecase = $updateUserUsecase;
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

    public function deleteUser($userID)
    {
        try {
            $this->deleteUserUsecase->execute($userID);
            return response()->json(["message" => "Usuario eliminado correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'newPassword' => 'string',
                'oldPassword' => 'string',
                'name' => 'required|string',
                'profileImage' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }


            $this->updateUserUsecase->execute($request->all());
            return response()->json(["message" => "Usuario actualizado correctamente"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
