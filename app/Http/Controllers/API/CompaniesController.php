<?php

namespace chickenhead\Http\Controllers\API;

use chickenhead\Http\Controllers\Controller;

use chickenhead\Models\Company;

use Request;
use Auth;

class CompaniesController extends Controller{
  public function getCompanySearch(){
    $term = Request::get('search');

    $companies = Company::where('name', 'LIKE', '%'.$term.'%')
                        ->withCount('cafes')
                        ->get();

    return response()->json( ['companies' => $companies ] );
  }
}
