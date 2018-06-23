/*
	Imports the Roast API URL from the config.
*/
import { ROAST_CONFIG } from '../config.js';

export default {
	/*
		GET 	/api/v1/restaurants
	*/
	getRestaurants: function(){
		return axios.get( ROAST_CONFIG.API_URL + '/restaurants' );
	},

	/*
		GET 	/api/v1/restaurants/{restaurantID}
	*/
	getRestaurant: function( restaurantID ){
		return axios.get( ROAST_CONFIG.API_URL + '/restaurants/' + restaurantID );
	},

	/*
		GET 	/api/v1/restaurants/{restaurantID}/edit
	*/
	getRestaurantEdit: function( restaurantID ){
		return axios.get( ROAST_CONFIG.API_URL + '/restaurants/' + restaurantID + '/edit' );
	},

	/*
		POST 	/api/v1/restaurants
	*/
	postAddNewRestaurant: function( name, address, city, state, zip, latitude, longitude, added_by ){
		/*
			Initialize the form data
		*/
		let formData = new FormData();

		/*
			Add the form data we need to submit
		*/
		// formData.append('website', website);
		formData.append('name', name);
		formData.append('address', address);
		formData.append('city', city);
		formData.append('state', state);
		formData.append('zip', zip);
		formData.append('latitude', latitude);
		formData.append('longitude', longitude);
		formData.append('added_by', added_by);

		return axios.post( ROAST_CONFIG.API_URL + '/restaurants',
			formData,
			{
		    headers: {
		        'Content-Type': 'multipart/form-data'
		    }
		  }
		);
	},

	/*
	  PUT 	/api/v1/restaurants/{id}
	*/
	putEditRestaurant: function( id, website, locationName, address, city, state, zip, lat, lng ){
		/*
			Initialize the form data
		*/
		let formData = new FormData();

		/*
			Add the form data we need to submit
		*/
		formData.append('website', website);
		formData.append('location_name', locationName);
		formData.append('address', address);
		formData.append('city', city);
		formData.append('state', state);
		formData.append('zip', zip);
		formData.append('lat', lat);
		formData.append('lng', lng);
		formData.append('_method', 'PUT');

		return axios.post( ROAST_CONFIG.API_URL + '/restaurants/'+id,
			formData
	  );
	},

	/*
		POST 	/api/v1/restaurants/{restaurantID}/like
	*/
	postLikeRestaurant: function( restaurantID ){
		return axios.post( ROAST_CONFIG.API_URL + '/restaurants/' + restaurantID + '/like' );
	},

	/*
		DELETE /api/v1/restaurants/{restaurantID}/like
	*/
	deleteLikeRestaurant: function( restaurantID ){
		return axios.delete( ROAST_CONFIG.API_URL + '/restaurants/' + restaurantID + '/like' );
	},

	deleteRestaurant: function( restaurantID ){
		return axios.delete( ROAST_CONFIG.API_URL + '/restaurants/' + restaurantID );
	}
}
