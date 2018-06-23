<?php

use Illuminate\Http\Request;

/*
  Public API Routes
*/
Route::group(['prefix' => 'v1'], function(){
  /*
  |-------------------------------------------------------------------------------
  | Get User
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/user
  | Controller:     API\UsersController@getUser
  | Method:         GET
  | Description:    Gets the authenticated user
  */
  Route::get('/user', 'API\UsersController@getUser');

  /*
  |-------------------------------------------------------------------------------
  | Get Users
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/users
  | Controller:     API\UsersController@getUsers
  | Method:         GET
  | Description:    Gets the users searched by the authenticated user.
  */
  Route::get('/users', 'API\UsersController@getUsers');

  /*
  |-------------------------------------------------------------------------------
  | Get All restaurants
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants
  | Controller:     API\RestaurantsController@getRestaurants
  | Method:         GET
  | Description:    Gets all of the restaurants in the application
  */
  Route::get('/restaurants', 'API\RestaurantsController@getRestaurants');

  /*
  |-------------------------------------------------------------------------------
  | Get An Individual Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}
  | Controller:     API\RestaurantsController@getRestaurant
  | Method:         GET
  | Description:    Gets an individual Restaurant
  */
  Route::get('/restaurants/{id}', 'API\RestaurantsController@getRestaurant');

  /*
  |-------------------------------------------------------------------------------
  | Get All Brew methods
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/brew-methods
  | Controller:     API\BrewMethodsController@getBrewMethods
  | Method:         GET
  | Description:    Gets all of the brew methods in the application
  */
  // Route::get('/brew-methods', 'API\BrewMethodsController@getBrewMethods');

  /*
  |-------------------------------------------------------------------------------
  | Search Tags
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/tags
  | Controller:     API\TagsController@getTags
  | Method:         GET
  | Description:    Searches the tags if a query is set otherwise returns all tags
  */
  Route::get('/tags', 'API\TagsController@getTags');
});

/*
  Authenticated API Routes.
*/
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
  // Route::get('/companies/search', 'API\CompaniesController@getCompanySearch');

  /*
  |-------------------------------------------------------------------------------
  | Updates a User's Profile
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/user
  | Controller:     API\UsersController@putUpdateUser
  | Method:         PUT
  | Description:    Updates the authenticated user's profile
  */
  Route::put('/user', 'API\UsersController@putUpdateUser');

  /*
  |-------------------------------------------------------------------------------
  | Gets Editing Data for an Individual Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/edit
  | Controller:     API\RestaurantsController@getRestaurantEditData
  | Method:         GET
  | Description:    Gets an individual Restaurant's edit data
  */
  Route::get('/restaurants/{id}/edit', 'API\RestaurantsController@getRestaurantEditData');

  /*
  |-------------------------------------------------------------------------------
  | Adds a New Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants
  | Controller:     API\RestaurantsController@postNewRestaurant
  | Method:         POST
  | Description:    Adds a new Restaurant to the application
  */
  Route::post('/restaurants', 'API\RestaurantsController@postNewRestaurant');

  /*
  |-------------------------------------------------------------------------------
  | Edits a Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{RestaurantID}
  | Controller:     API\RestaurantsController@putEditRestaurant
  | Method:         PUT
  | Description:    Edits a Restaurant
  */
  Route::put('/restaurants/{restaurantID}', 'API\RestaurantsController@putEditRestaurant');

  /*
  |-------------------------------------------------------------------------------
  | Likes a Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/like
  | Controller:     API\RestaurantsController@postLikeRestaurant
  | Method:         POST
  | Description:    Likes a Restaurant for the authenticated user.
  */
  Route::post('/restaurants/{id}/like', 'API\RestaurantsController@postLikeRestaurant');

  /*
  |-------------------------------------------------------------------------------
  | Un-Likes a Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/like
  | Controller:     API\RestaurantsController@deleteLikeRestaurant
  | Method:         DELETE
  | Description:    Un-Likes a Restaurant for the authenticated user.
  */
  Route::delete('/restaurants/{id}/like', 'API\RestaurantsController@deleteLikeRestaurant');

  /*
  |-------------------------------------------------------------------------------
  | Adds Tags To A Restaurant
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/tags
  | Controller:     API\RestaurantsController@postAddTags
  | Method:         POST
  | Description:    Adds tags to a Restaurant for a user
  */
  Route::post('/restaurants/{id}/tags', 'API\RestaurantsController@postAddTags');

  /*
  |-------------------------------------------------------------------------------
  | Deletes A Restaurant Tag
  |-------------------------------------------------------------------------------
  | URL:            /api/v1/restaurants/{id}/tags/{tagID}
  | Controller:     API\RestaurantsController@deleteRestaurantTag
  | Method:         DELETE
  | Description:    Deletes a tag from a Restaurant for a user
  */
  Route::delete('/restaurants/{id}/tags/{tagID}', 'API\RestaurantsController@deleteRestaurantTag');

  Route::delete('/restaurants/{id}', 'API\RestaurantsController@deleteRestaurant');
});
