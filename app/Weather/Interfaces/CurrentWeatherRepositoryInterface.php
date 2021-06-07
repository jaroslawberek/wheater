<?php

namespace App\Weather\Interfaces;
use App\Weather\Classes\CurrentWeater;



interface CurrentWeatherRepositoryInterface   {
    
    
    public function getWeaterForCity($id):CurrentWeater;

  
}


