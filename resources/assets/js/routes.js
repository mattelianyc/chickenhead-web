/*
|-------------------------------------------------------------------------------
| routes.js
|-------------------------------------------------------------------------------
| Contains all of the routes for the application
*/

/*
	Imports Vue and VueRouter to extend with the routes.
*/
import Vue from 'vue'
import VueRouter from 'vue-router'

import store from './store.js';

/*
	Extends Vue to use Vue Router
*/
Vue.use( VueRouter )

/*
	This will cehck to see if the user is authenticated or not.
*/
function requireAuth (to, from, next) {
	/*
		Determines where we should send the user.
	*/
	function proceed () {
		/*
			If the user has been loaded determine where we should
			send the user.
		*/
    if ( store.getters.getUserLoadStatus() == 2 ) {
			/*
				If the user is not empty, that means there's a user
				authenticated we allow them to continue. Otherwise, we
				send the user back to the home page.
			*/
			if( store.getters.getUser != '' ){
      	next();
			}else{
				next('/restaurants');
			}
    }
	}

	/*
		Confirms the user has been loaded
	*/
	if ( store.getters.getUserLoadStatus != 2 ) {
		/*
			If not, load the user
		*/
		store.dispatch( 'loadUser' );

		/*
			Watch for the user to be loaded. When it's finished, then
			we proceed.
		*/
		store.watch( store.getters.getUserLoadStatus, function(){
			if( store.getters.getUserLoadStatus() == 2 ){
				proceed();
			}
		});
	} else {
		/*
			User call completed, so we proceed
		*/
		proceed()
	}
}

/*
	Makes a new VueRouter that we will use to run all of the routes
	for the app.
*/
export default new VueRouter({
	routes: [
		{
			path: '/',
			redirect: { name: 'restaurants' },
			name: 'layout',
			component: Vue.component( 'Layout', require( './pages/Layout.vue' ) ),
			children: [
				{
					path: 'restaurants',
					name: 'restaurants',
					component: Vue.component( 'Home', require( './pages/Home.vue' ) ),
					children: [
						{
							path: 'new',
							name: 'newrestaurant',
							component: Vue.component( 'NewRestaurant', require( './pages/NewRestaurant.vue' ) ),
							beforeEnter: requireAuth
						},
						{
							path: ':id',
							name: 'restaurant',
							component: Vue.component( 'Restaurant', require( './pages/Restaurant.vue' ) )
						},
					]
				},
				{
					path: 'restaurants/:id/edit',
					name: 'editrestaurant',
					component: Vue.component( 'EditRestaurant', require( './pages/EditRestaurant.vue' ) ),
					beforeEnter: requireAuth
				},
				{
					path: 'profile',
					name: 'profile',
					component: Vue.component( 'Profile', require( './pages/Profile.vue' ) ),
					beforeEnter: requireAuth
				},
				{
					path: 'users',
					name: 'users',
					component: Vue.component( 'Users', require( './pages/Users.vue' ) ),
					beforeEnter: requireAuth
				}
			]
		}
	]
});
