<?php

namespace chickenhead\Http\Controllers\API;

use chickenhead\Http\Controllers\Controller;

use chickenhead\Models\Tag;
use Request;

class TagsController extends Controller
{
  public function getTags(){
    $query = Request::get('search');

    /*
      If the query is not set or is empty, load all the tags.
      Otherwise load the tags that match the query
    */
    if( $query == null || $query == '' ){
      $tags = Tag::all();
    }else{
      $tags = Tag::where('tag', 'LIKE', '%'.$query.'%')->get();
    }

    /*
      Return all of the tags as JSON
    */
    return response()->json( $tags );
  }
}
