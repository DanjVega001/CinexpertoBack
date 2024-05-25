<?php

namespace App\Features\Trivia\Application\Services;


class TriviaService
{


    public function getTriviasByLevelID(mixed $trivias, mixed $triviasUser, int $levelID): array
    {

        $triviasUser = array_map(function ($item) use ($levelID) {
            if ($item["level_id"] == $levelID) {
                return [
                    "trivia_id" => $item["id"],
                    "state" => $item["pivot"]["state"]
                ];
            } else {
                return;
            }
        }, $triviasUser->toArray());

        return $this->groupBy($triviasUser, $trivias->toArray());
    }

    private function groupBy(array $triviasUser, array $trivias): array
    {
        $arrayMerge = array_merge($trivias, $triviasUser);
        $data = array();
        $i = 0;
        foreach ($arrayMerge as $item) {
            if (isset($item)) {
                $trivia_id = $item["trivia_id"];
                if (in_array([
                    "trivia_id" => $trivia_id, 
                    "state" => "pendiente"
                ], $data)) {
                    $id = array_search([
                        "trivia_id" => $trivia_id, 
                        "state" => "pendiente"
                    ], $data);                    
    
                    $data[$id]["state"] = $item["state"];
                } else {
                    array_push($data, [
                        ...$item,
                        "state" => "pendiente",
                    ]);
                }
                $i++;
            }
        }
        return $data;

    }
}
