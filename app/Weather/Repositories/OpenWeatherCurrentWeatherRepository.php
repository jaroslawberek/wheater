<?php

namespace App\Weather\Repositories; 

use App\Weather\Interfaces\CurrentWeatherRepositoryInterface;
use App\Weather\Classes\CurrentWeater;
use App\Exceptions\WheaterException;
use Ixudra\Curl\Facades\Curl;

class OpenWeatherCurrentWeatherRepository implements CurrentWeatherRepositoryInterface {

    private $apiKey = "";

    public function __construct() {
        
        $this->apiKey = config('weather.apiToken');
        
    }

    public function getWeaterForCity($city):CurrentWeater {

        $response = Curl::to('api.openweathermap.org/data/2.5/weather')
                ->withData(array('q' => $city,'appid' => $this->apiKey, 'units'=>'metric','lang'=>'pl'))
                ->asJson()
                ->get();
         if($response->cod=='404') 
            throw new WheaterException("Uwaga! Dla domyślnie ustawionego miasta nie można znaleść warunków pogodowych!");
         
        $currentWeater = new CurrentWeater();
        $currentWeater->dataCalculation = date("Y-m-d H:i:s",$response->dt);
        $currentWeater->now = date("Y-m-d H:i:s");
        $currentWeater->weatherDescription = $response->weather[0]->description;
        $currentWeater->weatherIcon = $response->weather[0]->icon;
        $currentWeater->temp = $response->main->temp;
        $currentWeater->tempFeelsLike = $response->main->feels_like; //temperatura odczuwalna 
        $currentWeater->humidity = $response->main->humidity ; //wilgotność
        $currentWeater->pressure = $response->main->pressure  ; //Ciśnienie atmosferyczne
        $currentWeater->windSpeed = $response->wind->speed  ;
        $currentWeater->city = $response->name  ;
        
        return $currentWeater;
    }

}
