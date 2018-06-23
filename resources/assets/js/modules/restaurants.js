/*
|-------------------------------------------------------------------------------
| VUEX modules/restaurants.js
|-------------------------------------------------------------------------------
| The Vuex data store for the restaurants
*/

import RestaurantAPI from '../api/restaurant.js';

export const restaurants = {
  /*
    Defines the state being monitored for the module.
  */
	state: {
		restaurants: [],
    restaurantsLoadStatus: 0,

    restaurant: {},
    restaurantLoadStatus: 0,

		restaurantEdit: {},
		restaurantEditLoadStatus: 0,
		restaurantEditStatus: 0,

		restaurantLiked: false,

		restaurantAdded: {},
		restaurantAddStatus: 0,
		restaurantLikeActionStatus: 0,
		restaurantUnlikeActionStatus: 0,

		restaurantDeletedStatus: 0,
	},

  /*
    Defines the actions used to retrieve the data.
  */
	actions: {
    /*
      Loads the restaurants from the API
    */
		loadRestaurants( { commit } ){
      commit( 'setRestaurantsLoadStatus', 1 );

      RestaurantAPI.getRestaurants()
        .then( function( response ){
          commit( 'setRestaurants', response.data );
          commit( 'setRestaurantsLoadStatus', 2 );
        })
        .catch( function(){
          commit( 'setRestaurants', [] );
          commit( 'setRestaurantsLoadStatus', 3 );
        });
    },

    /*
      Loads an individual restaurant from the API
    */
    loadRestaurant( { commit }, data ){
			commit( 'setRestaurantLikedStatus', false );
      commit( 'setRestaurantLoadStatus', 1 );

      RestaurantAPI.getRestaurant( data.id )
        .then( function( response ){
          commit( 'setRestaurant', response.data );
					if( response.data.user_like_count > 0 ){
						commit('setRestaurantLikedStatus', true);
					}
          commit( 'setRestaurantLoadStatus', 2 );
        })
        .catch( function(){
          commit( 'setRestaurant', {} );
          commit( 'setRestaurantLoadStatus', 3 );
        });
    },

		/*
			Loads a Restaurant to edit from the API
		*/
		loadRestaurantEdit( { commit }, data ){
			commit( 'setRestaurantEditLoadStatus', 1 );

			RestaurantAPI.getRestaurantEdit( data.id )
				.then( function( response ){
					commit( 'setRestaurantEdit', response.data );
					commit( 'setRestaurantEditLoadStatus', 2 );
				})
				.catch( function(){
					commit( 'setRestaurantEdit', {} );
					commit( 'setRestaurantEditLoadStatus', 3 );
				});
		},

		/*
			Edits a Restaurant
		*/
		editRestaurant( { commit, state, dispatch }, data ){
			commit( 'setRestaurantEditStatus', 1 );

			RestaurantAPI.putEditRestaurant( data.id, data.company_name, data.company_id, data.company_type, data.website, data.location_name, data.address, data.city, data.state, data.zip, data.lat, data.lng, data.brew_methods )
					.then( function( response ){
						commit( 'setRestaurantEditStatus', 2 );
						dispatch( 'loadRestaurants' );
					})
					.catch( function(){
						commit( 'setRestaurantEditStatus', 3 );
					});
		},

		/*
			Adds a Restaurant
		*/
		addRestaurant( { commit, state, dispatch }, data ){
			commit( 'setRestaurantAddedStatus', 1 );
			RestaurantAPI.postAddNewRestaurant( data.company_name, data.company_id, data.company_type, data.website, data.location_name, data.address, data.city, data.state, data.zip, data.lat, data.lng, data.brew_methods )
					.then( function( response ){
						commit( 'setRestaurantAddedStatus', 2 );
						commit( 'setRestaurantAdded', response.data );
						dispatch( 'loadRestaurants' );
					})
					.catch( function(){
						commit( 'setRestaurantAddedStatus', 3 );
					});
		},

		/*
			Likes a Restaurant
		*/
		likeRestaurant( { commit, state, dispatch }, data ){
			commit( 'setRestaurantLikeActionStatus', 1 );

			RestaurantAPI.postLikeRestaurant( data.id )
				.then( function( response ){
					commit( 'setRestaurantLikedStatus', true );
					commit( 'setRestaurantLikeActionStatus', 2 );
					dispatch( 'loadRestaurant', { id: data.id } );

					commit( 'updateRestaurantLikedStatus', { id: data.id, count: 1 });
				})
				.catch( function(){
					commit( 'setRestaurantLikeActionStatus', 3 );
				});
		},

		/*
			Unlikes a Restaurant
		*/
		unlikeRestaurant( { commit, state, dispatch }, data ){
			commit( 'setRestaurantUnlikeActionStatus', 1 );

			RestaurantAPI.deleteLikeRestaurant( data.id )
				.then( function( response ){
					commit( 'setRestaurantLikedStatus', false );
					commit( 'setRestaurantUnlikeActionStatus', 2 );
					dispatch( 'loadRestaurant', { id: data.id } );

					commit( 'updateRestaurantLikedStatus', { id: data.id, count: 0 });
				})
				.catch( function(){
					commit( 'setRestaurantUnlikeActionStatus', 3 );
				});
		},

		clearLikeAndUnlikeStatus( { commit }, data ){
			commit( 'setRestaurantLikeActionStatus', 0 );
			commit( 'setRestaurantUnlikeActionStatus', 0 );
		},

		deleteRestaurant( { commit, state, dispatch }, data ){
			commit( 'setRestaurantDeleteStatus', 1 );

			RestaurantAPI.deleteRestaurant( data.restaurant_id )
				.then( function( response ){
					commit( 'setRestaurantDeleteStatus', 2 );

					dispatch( 'loadRestaurants' );
				})
				.catch( function(){
					commit( 'setRestaurantDeleteStatus', 3 );
				});
		}
	},

  /*
    Defines the mutations used
  */
	mutations: {
    /*
      Sets the Restaurants load status
    */
    setRestaurantsLoadStatus( state, status ){
      state.restaurantsLoadStatus = status;
    },

    /*
      Sets the restaurants
    */
    setRestaurants( state, restaurants ){
      state.restaurants = restaurants;
    },

    /*
      Set the restaurant load status
    */
    setRestaurantLoadStatus( state, status ){
      state.restaurantLoadStatus = status;
    },

    /*
      Set the restaurant
    */
    setRestaurant( state, restaurant ){
      state.restaurant = restaurant;
    },

		/*
			Sets the restaurant to be edited
		*/
		setRestaurantEdit( state, restaurant ){
			state.restaurantEdit = restaurant;
		},

		/*
			Sets the restaurant edit status
		*/
		setRestaurantEditStatus( state, status ){
			state.restaurantEditStatus = status;
		},

		/*
			Sets the restaurant edit load status
		*/
		setRestaurantEditLoadStatus( state, status ){
			state.restaurantEditLoadStatus = status;
		},

		/*
			Set the added restaurant.
		*/
		setRestaurantAdded( state, restaurant ){
			state.restaurantAdded = restaurant;
		},

		/*
			Set the restaurant add status
		*/
		setRestaurantAddedStatus( state, status ){
			state.restaurantAddStatus = status;
		},

		/*
			Set the restaurant liked status
		*/
		setRestaurantLikedStatus( state, status ){
			state.restaurantLiked = status;
		},

		/*
			Set the restaurant like action status
		*/
		setRestaurantLikeActionStatus( state, status ){
			state.restaurantLikeActionStatus = status;
		},

		/*
			Set the restaurant unlike action status
		*/
		setRestaurantUnlikeActionStatus( state, status ){
			state.restaurantUnlikeActionStatus = status;
		},

		/*
			Update a loaded restaurant's like status.
		*/
		updateRestaurantLikedStatus( state, data ){
			for( var i = 0; i < state.restaurants.length; i++ ){
				if( state.restaurants[i].id == data.id ){
					state.restaurants[i].user_like_count = data.count;
				}
			}
		},

		setRestaurantDeleteStatus( state, status ){
			state.restaurantDeletedStatus = status;
		}
	},

  /*
    Defines the getters used by the module
  */
	getters: {
    /*
      Returns the restaurants load status.
    */
    getRestaurantsLoadStatus( state ){
      return state.restaurantsLoadStatus;
    },

    /*
      Returns the restaurants.
    */
    getRestaurants( state ){
      return state.restaurants;
    },

    /*
      Returns the restaurants load status
    */
    getRestaurantLoadStatus( state ){
      return state.restaurantLoadStatus;
    },

    /*
      Returns the restaurant
    */
    getRestaurant( state ){
      return state.restaurant;
    },

		/*
			Gets the restaurant we are editing
		*/
		getRestaurantEdit( state ){
			return state.restaurantEdit;
		},

		/*
			Gets the restaurant edit status
		*/
		getRestaurantEditStatus( state ){
			return state.restaurantEditStatus;
		},

		/*
			Gets the restaurant edit load status
		*/
		getRestaurantEditLoadStatus( state ){
			return state.restaurantEditLoadStatus;
		},

		/*
			Gets the added restaurant.
		*/
		getAddedRestaurant( state ){
			return state.restaurantAdded;
		},

		/*
			Gets the restaurant add status
		*/
		getRestaurantAddStatus( state ){
			return state.restaurantAddStatus;
		},

		/*
			Gets the restaurant liked status
		*/
		getRestaurantLikedStatus( state ){
			return state.restaurantLiked;
		},

		/*
			Gets the restaurant liked action status
		*/
		getRestaurantLikeActionStatus( state ){
			return state.restaurantLikeActionStatus;
		},

		/*
			Gets the restaurant un-like action status
		*/
		getRestaurantUnlikeActionStatus( state ){
			return state.restaurantUnlikeActionStatus;
		},

		getRestaurantDeletedStatus( state ){
			return state.restaurantDeletedStatus;
		}
	}
}
