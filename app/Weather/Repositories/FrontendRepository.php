<?php

namespace App\Weather\Repositories; /* Lecture 12 */

use App\Weather\Interfaces\FrontendRepositoryInterface;
use App\City;

class FrontendRepository implements FrontendRepositoryInterface {

    public function getCities($search) {
        $cities = City::where('name', 'like', "%{$search}%")->get();
        return $cities;
    }

    public function getCityForId($id) {
        $city = City::findOrFail($id);
        return $city;
    }

    

}
