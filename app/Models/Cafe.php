<?php

namespace chickenhead\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class Cafe extends Model
{
	protected $table = 'cafes';

	public function brewMethods(){
		return $this->belongsToMany( 'chickenhead\Models\BrewMethod', 'cafes_brew_methods', 'cafe_id', 'brew_method_id' );
	}

	public function company(){
		return $this->hasOne( 'chickenhead\Models\Company', 'id', 'company' );
	}

	public function likes(){
		return $this->belongsToMany( 'chickenhead\Models\User', 'users_cafes_likes', 'cafe_id', 'user_id');
	}

	public function userLike(){
		$userID = Request::user('api') != '' ? Request::user('api')->id : null;

		return $this->belongsToMany( 'chickenhead\Models\User', 'users_cafes_likes', 'cafe_id', 'user_id')
								->where('user_id', $userID );
	}

	public function tags(){
		return $this->belongsToMany( 'chickenhead\Models\Tag', 'cafes_users_tags', 'cafe_id', 'tag_id');
	}

	public function photos(){
		return $this->hasMany( 'chickenhead\Models\CafePhoto', 'id', 'cafe_id' );
	}
}
