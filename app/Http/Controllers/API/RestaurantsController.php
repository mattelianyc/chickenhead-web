<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

// use App\Models\Company;
use App\Models\Restaurant;
use App\Models\RestaurantPhoto;

use App\Utilities\GoogleMaps;
use App\Utilities\Tagger;

use Request;
use Auth;
use DB;
use File;

/*
	Defines the requests used by the controller.
*/
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\EditRestaurantRequest;

class RestaurantsController extends Controller
{
  /*
  |-------------------------------------------------------------------------------
  | Get All Restaurants
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants
  | Method:         GET
  | Description:    Gets all of the restaurants in the application
  */
	public function getRestaurants(){
    $restaurants = Restaurant::with(['tags' => function( $query ){
										$query->select('tag');
									}])
									->withCount('userLike')
									->where('deleted', '=', 0)
									->get();

    return response()->json( $restaurants );
  }

  /*
  |-------------------------------------------------------------------------------
  | Get An Individual Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}
  | Method:         GET
  | Description:    Gets an individual restaurant
  | Parameters:
  |   $id   -> ID of the restaurant we are retrieving
  */
  public function getRestaurant( $id ){
    $restaurant = Restaurant::where('id', '=', $id)
								->withCount('userLike')
								->with('tags')
								->withCount('likes')
								->where('deleted', '=', 0)
								->first();

		if( $restaurant != null ){
			return response()->json( $restaurant );
		}else{
			abort(404);
		}

  }

	/*
	|-------------------------------------------------------------------------------
	| Gets Editing Data for an Individual Restaurant
	|-------------------------------------------------------------------------------
	| URL:            /api/v1/restaurants/{id}/edit
	| Method:         GET
	| Description:    Gets an individual restaurant's edit data
	| Parameters:
	|   $id   -> ID of the restaurant we are retrieving
	*/
	public function getRestaurantEditData( $restaurantID ){
		/*
			Grab the restaurant with the parent of the restaurant
		*/
		$restaurant = Restaurant::where('id', '=', $restaurantID)
								->withCount('userLike')
								->where('deleted', '=', 0)
								->first();

		/*
			Return the restaurant queried.
		*/
		return response()->json($restaurant);
	}

  /*
  |-------------------------------------------------------------------------------
  | Adds a New Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants
  | Method:         POST
  | Description:    Adds a new restaurant to the application
  */
  public function postNewRestaurant( StoreRestaurantRequest $request ){
  	$restaurant;
		$restaurantID = $request->get('restaurant_id');

		if( $restaurantID != '' ){
			$restaurant = Restaurant::where('id', '=', $restaurantID)->first();
		}else{
			$restaurant = new Restaurant();

			$address 									= $request->get('address');
			$city 										= $request->get('city');
			$state 										= $request->get('state');
			$zip 											= $request->get('zip');
			

			$lat = Request::get('lat') != '' ? Request::get('lat') : 0;
			$lng = Request::get('lng') != '' ? Request::get('lng') : 0;
			
			if( $lat == 0 && $lng == 0 ) 
			{
				$coordinates = GoogleMaps::geocodeAddress( $address, $city, $state, $zip );
			
			}
			$lat = $coordinates['lat'];
			$lng = $coordinates['lng'];

			
			$restaurant->latitude 				= $lat;
			$restaurant->longitude 				= $lng;
			
			$restaurant->deleted 					= 0;
			$restaurant->added_by					= Auth::user()->id;			
			
			$website 			= '';
			
			$name 										=	$request->get('name');
			$restaurant->name 						= $name != null ? $name : '';
			$restaurant->address 					= $address;
			$restaurant->city 						= $city;
			$restaurant->state 						= $state;
			$restaurant->zip 							= $zip;
			
			$restaurant->save();
		}

		/*
			Return the added restaurants as JSON
		*/
    return response()->json( $restaurant, 201);
  }

	/*
	|-------------------------------------------------------------------------------
	| Edits a Restaurant
	|-------------------------------------------------------------------------------
	| URL:            /api/v1/restaurants/{restaurantID}
	| Method:         PUT
	| Description:    Edits a restaurant
	*/
	public function putEditRestaurant( $restaurantID, EditRestaurantRequest $request ){
		$restaurantID = $request->get('restaurant_id');

		if( $restaurantID != '' ){
	    $restaurant = Restaurant::where('id', '=', $restaurantID)->first();

			$restaurant->location_name 		= $request->get('location_name');
	    $restaurant->website 					= $request->get('website');
	    // $restaurant->logo 						= '';
	    $restaurant->description 			= '';

			$restaurant->save();
	  }else{
	    $restaurant = new Restaurant();

	    $restaurant->location_name		= $request->get('location_name');
	    $restaurant->website 					= $request->get('website');
	    // $restaurant->logo 					= '';
	    $restaurant->description 			= '';
	    $restaurant->added_by 				= Auth::user()->id;
	    
	    $restaurant->save();
	  }

		$address 			= $request->get('address');
	  $city 				= $request->get('city');
	  $state 				= $request->get('state');
	  $zip 					= $request->get('zip');
	  $locationName = $request->get('location_name');

	  $lat = Request::get('lat') != '' ? Request::get('lat') : 0;
	  $lng = Request::get('lng') != '' ? Request::get('lng') : 0;

	  if( $lat == 0 && $lng == 0 ){
	    $coordinates = GoogleMaps::geocodeAddress( $address, $city, $state, $zip );
	    $lat = $coordinates['lat'];
	    $lng = $coordinates['lng'];
	  }

		$restaurant = Restaurant::where('id', '=', $restaurantID)->first();

		$restaurant->id 							= $restaurant->id;
	  $restaurant->location_name 		= $locationName != null ? $locationName : '';
	  $restaurant->address 					= $address;
	  $restaurant->city 						= $city;
	  $restaurant->state 						= $state;
	  $restaurant->zip 							= $zip;
	  $restaurant->latitude 				= $lat;
	  $restaurant->longitude 				= $lng;
	  $restaurant->added_by 				= Auth::user()->id;

	  $restaurant->save();

	  /*
	    Return the edited restaurants as JSON
	  */
	  return response()->json( $restaurant, 200);
	}

	/*
  |-------------------------------------------------------------------------------
  | Likes a Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/like
  | Method:         POST
  | Description:    Likes a restaurant for the authenticated user.
  */
	public function postLikeRestaurant( $restaurantID ){
		/*
			Gets the restaurant the user is liking
		*/
		$restaurant = Restaurant::where('id', '=', $restaurantID)->first();

		/*
			Checks to see if the user already likes the restaurant
		*/
		if( !$restaurant->likes->contains( Auth::user()->id ) ){
			/*
				If the user doesn't already like the restaurant, attaches the restaurant to the user's
				likes
			*/
			$restaurant->likes()->attach( Auth::user()->id, [
				'created_at' 	=> date('Y-m-d H:i:s'),
				'updated_at'	=> date('Y-m-d H:i:s')
				] );
		}

		/*
			Return a response that the restaurant was liked successfully.
		*/
		return response()->json( ['restaurant_liked' => true], 201 );
	}

	/*
  |-------------------------------------------------------------------------------
  | Un-Likes a Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/like
  | Method:         DELETE
  | Description:    Un-Likes a restaurant for the authenticated user.
  */
	public function deleteLikeRestaurant( $restaurantID ){
		/*
			Gets the restaurant the user is liking
		*/
		$restaurant = Restaurant::where('id', '=', $restaurantID)->first();

		/*
			Detaches the user from the restaurant's likes
		*/
		$restaurant->likes()->detach( Auth::user()->id );

		/*
			Return a proper response code for successful unliking
		*/
		return response(null, 204);
	}

	/*
	|-------------------------------------------------------------------------------
	| Adds Tags To A Restaurant
	|-------------------------------------------------------------------------------
	| URL:            /api/v1/restaurants/{id}/tags
	| Controller:     API\RestaurantsController@postAddTags
	| Method:         POST
	| Description:    Adds tags to a restaurant for a user
	*/
	public function postAddTags( $restaurantID ){
		/*
			Grabs the tags array from the request
		*/
		$tags = Request::get('tags');

		/*
			Gets the restaurant
		*/
		$restaurant = Restaurant::where('id', '=', $restaurantID)->first();

		/*
			Tags the restaurant
		*/
		Tagger::tagRestaurant( $restaurant, $tags );

		/*
			Grabs the restaurant with the brew methods, user like and tags
		*/
		$restaurant = Restaurant::where('id', '=', $restaurantID)
								->with('userLike')
								->with('tags')
								->first();

		/*
			Returns the restaurant response as JSON.
		*/
		return response()->json($restaurant, 201);
	}

	/*
	|-------------------------------------------------------------------------------
	| Deletes A Restaurant Tag
	|-------------------------------------------------------------------------------
	| URL:            /api/v1/restaurants/{id}/tags/{tagID}
	| Method:         DELETE
	| Description:    Deletes a tag from a restaurant for a user
	*/
	public function deleteRestaurantTag( $restaurantID, $tagID ){
		/*
			Delete the specific users tag for the restaurant.
		*/
		DB::statement('DELETE FROM restaurants_users_tags WHERE restaurant_id = "'.$restaurantID.'" AND tag_id = "'.$tagID.'" AND user_id = "'.Auth::user()->id.'"');

		/*
			Return a proper response code for successful untagging
		*/
		return response(null, 204);
	}

	public function deleteRestaurant( $restaurantID ){
		$restaurant = Restaurant::where('id', '=', $restaurantID)->first();

		$restaurant->deleted = 1;

		$restaurant->save();

		return response()->json('', 204);
	}
}
