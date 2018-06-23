<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantPhoto extends Model
{
	protected $table = 'restaurants_photos';

  public function restaurant(){
    return $this->belongsTo('App\Models\Restaurant', 'restaurant_id', 'id');
  }

  public function user(){
    return $this->belongsTo('App\Models\User', 'uploaded_by', 'id');
  }
}
