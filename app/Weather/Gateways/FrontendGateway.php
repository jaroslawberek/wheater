<?php

namespace App\Weather\Gateways;

use App\Weather\Interfaces\FrontendRepositoryInterface;
use App\Weather\Interfaces\CurrentWeatherRepositoryInterface;
use App\Weather\Classes\CurrentWeater;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\NoSetDefaultCityException;
use App\City;

class FrontendGateway {

    public function __construct(FrontendRepositoryInterface $frontendRepository, CurrentWeatherRepositoryInterface $currentWeatherRepository) /* Lecture 13 FrontendRepositoryInterface */ {
        $this->frontendRepository = $frontendRepository;
        $this->currentWeatherRepository = $currentWeatherRepository;
    }

    public function getWeaterDefaultCity(): CurrentWeater {

        $city = City::where('set_default', '1')->first();
        if (!$city)
            throw new NoSetDefaultCityException("Nie ustawiono domyślnego miasta lub w bazie brak miast");

        return $this->getWeaterForCity($city->id);
    }

    public function getWeaterForCity($id): CurrentWeater {

        $city = City::findOrFail($id);
        $currentWeaterForCity = $this->currentWeatherRepository->getWeaterForCity($city->name);
        $currentWeaterForCity->city_id = $id;

        return $currentWeaterForCity;
    }

    public function deleteCity($id) {

        $city = City::find($id);
        $city->delete();
    }

    public function insertCity($parametrs) {

        $errors = [];
        $validator = Validator::make($parametrs, [
                    'name' => 'required|unique:cities|min:3|max:45',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $city = new City();
        $city->name = $parametrs['name'];
        $city->save();

        return $errors;
    }

    public function updateCity($parametrs) {

        $city = City::find($parametrs['id']);
        $errors = [];
        $validator = Validator::make($parametrs, [
                    'name' => 'required|unique:cities|min:3|max:45',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $city->name = $parametrs['name'];
        $city->save();

        return $errors;
    }

    public function setDefaultCity($id) {
        $city = City::find($id);
        $cityDefault = City::where('set_default', '1')->first();
        DB::transaction(function () use ($city, $cityDefault) {
            $city->set_default = 1;
            $city->save();
            if ($cityDefault) {
                $cityDefault->set_default = 0;
                $cityDefault->save();
            }
        });

        return true;
    }

}
