<?php
namespace App\Features\User\Application\Services;

use App\Features\User\Application\Usecases\Points\GetClassificationUsecase;
use App\Features\User\Infrastructure\DataMappers\UserDataMapper;
use App\Models\User;

class UserService {

    private GetClassificationUsecase $getClassification;
    private UserDataMapper $userMapper;

    public function __construct(GetClassificationUsecase $getClassification, UserDataMapper $userMapper) 
    {
        $this->getClassification = $getClassification;
        $this->userMapper = $userMapper;
    }


    private function getNumClassification(User $user):int
    {
        $classification = $this->getClassification->execute();
        $i = 0;
        foreach ($classification as $item) {
            if ($item->id == $user->points->id) {
                break;
            } 
            $i++;
        }
        return $i+1;
    }

    public function getProfile(User $user):array
    {
        $userEntity = $this->userMapper->modelToEntity($user);
        
        $nameRank = $userEntity->getUltimateNameRank($user);

        $pointsUser = $user->points->points;

        $numClassification = $this->getNumClassification($user);        

        $numTriviaAnswered = count($user->trivias);

        $numTriviaPublished = count(array_filter($user->publishedTrivias->toArray(), function($item) {
            return $item->state == "aceptada";
        }));

        return [
            "name" => $user->name,
            "nameRank" => $nameRank,
            "points" => $pointsUser,
            'numClassification' => $numClassification,
            'numTriviaAnswered' => $numTriviaAnswered,
            'numTriviaPublished' => $numTriviaPublished,
            'ranks' => $userEntity->ranksUser($user)
        ];
    }
}
