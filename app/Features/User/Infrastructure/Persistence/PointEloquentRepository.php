<?php
namespace App\Features\User\Infrastructure\Persistence;

use App\Features\User\Domain\Repositories\PointRepository;
use App\Models\Point;

class PointEloquentRepository implements PointRepository 
{
    public function getClassification():mixed
    {
        return Point::orderBy('points', 'DESC')->get();
    }
}

