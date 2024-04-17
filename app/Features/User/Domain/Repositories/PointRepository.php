<?php
namespace App\Features\User\Domain\Repositories;

interface PointRepository{

    public function getClassification():mixed;

    public function updatePoints(?int $userID,$points):mixed;

    public function getClassificationWithUser():mixed;

}