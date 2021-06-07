<?php

namespace App\Weather\Interfaces;

interface FrontendRepositoryInterface {

    public function getCities($search);
    
    public function getCityForId($id);
    
}
