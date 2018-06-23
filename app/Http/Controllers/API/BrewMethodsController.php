<?php

namespace chickenhead\Http\Controllers\API;

use chickenhead\Http\Controllers\Controller;

use chickenhead\Models\BrewMethod;

class BrewMethodsController extends Controller
{
  public function getBrewMethods(){
    $brewMethods = BrewMethod::withCount('cafes')->get();

    return response()->json( $brewMethods );
  }
}
