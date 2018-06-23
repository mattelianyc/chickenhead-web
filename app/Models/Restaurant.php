<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Restaurant extends Model
{
	protected $table = 'restaurants';

	// public function brewMethods(){
	// 	return $this->belongsToMany( 'App\Models\BrewMethod', 'restaurants_brew_methods', 'restaurant_id', 'brew_method_id' );
	// }

	// public function company(){
	// 	return $this->hasOne( 'App\Models\Company', 'id', 'company' );
	// }

	public function likes(){
		return $this->belongsToMany( 'App\Models\User', 'users_restaurants_likes', 'restaurant_id', 'user_id');
	}

	public function userLike(){
		$userID = Request::user('api') != '' ? Request::user('api')->id : null;

		return $this->belongsToMany( 'App\Models\User', 'users_restaurants_likes', 'restaurant_id', 'user_id')
								->where('user_id', $userID );
	}

	public function tags(){
		return $this->belongsToMany( 'App\Models\Tag', 'restaurants_users_tags', 'restaurant_id', 'tag_id');
	}

	public function photos(){
		return $this->hasMany( 'App\Models\RestaurantPhoto', 'id', 'restaurant_id' );
	}
}
