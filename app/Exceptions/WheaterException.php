<?php

namespace App\Exceptions;

use Exception;

class WheaterException extends Exception
{
     public function render($request){
         
        return response()->json(['status'=>'error','message'=>"Dla podanego miasta nie znaleziono warunków pogodowych"]);
        
    }
}
