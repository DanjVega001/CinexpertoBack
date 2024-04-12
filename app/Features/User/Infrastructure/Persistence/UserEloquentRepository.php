<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Domain\Entities\User;
use App\Features\User\Domain\Repositories\UserRepository;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserEloquentRepository implements UserRepository {
    
    private UserDataMapper $userMapper;

    public function __construct(UserDataMapper $userMapper)
    {   
        $this->userMapper = $userMapper;
    }

    public function register(User $user) 
    {
        $userModel = $this->userMapper->mapToModel($user);
        $userModel->save();
    }

    public function login(array $credentials):ModelsUser 
    {   
        $user = ModelsUser::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password) || !Auth::attempt($credentials)) {
            throw new Exception("Credenciales incorrectas");   
        }

        return $user;
    }

    public function logout(string $idToken)
    {
        DB::table('oauth_access_tokens')->where('id', '=', $idToken)->delete();
    }
}