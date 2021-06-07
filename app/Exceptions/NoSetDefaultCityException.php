<?php

namespace App\Exceptions;

use Exception;

class NoSetDefaultCityException extends Exception
{
     public function render($request){
         
        return response()->json(['status'=>'error','message'=>"Nie ustawiono domyślnego miasta lub w bazie brak miast"]);
    }
}
