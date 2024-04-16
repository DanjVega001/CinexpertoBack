<?php
namespace App\Features\Trivia\Application\Services;


class TriviaService {
   

    public function getTriviasByLevelID(mixed $trivias, mixed $triviasUser) : array
    {

        $triviasUser = array_map(function ($item) {
            return [
                "trivia_id" => $item["id"],
                "state" => $item["pivot"]["state"]
            ];
        }, $triviasUser->toArray());
        
        return $this->groupBy($triviasUser, $trivias->toArray());
    }

    private function groupBy(array $triviasUser, array $trivias) : array
    {
        $arrayMerge = array_merge($triviasUser, $trivias);
        return array_reduce($arrayMerge, function ($newArray, $item) {
            $trivia_id = $item["trivia_id"];
        
            if (!isset($newArray[$trivia_id])) {
                $newArray[$trivia_id] = [
                    "trivia_id" => $trivia_id,
                    "state" => "pendiente"
                ];
            }
        
            if (isset($item["state"])) {
                $newArray[$trivia_id]["state"] = $item["state"];
            }
        
            return $newArray;
        }, []);
    }
   
}
