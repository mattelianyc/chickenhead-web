/*
|-------------------------------------------------------------------------------
| VUEX store.js
|-------------------------------------------------------------------------------
| Builds the data store from all of the modules for the Roast app.
*/
/*
  Adds the promise polyfill for IE 11
*/
require('es6-promise').polyfill();

/*
	Imports Vue and Vuex
*/
import Vue from 'vue'
import Vuex from 'vuex'

/*
	Initializes Vuex on Vue.
*/
Vue.use( Vuex )

/*
	Imports all of the modules used in the application to build the data store.
*/
import { restaurants } from './modules/restaurants.js'
import { users } from './modules/users.js'
// import { brewMethods } from './modules/brewMethods.js'
import { display } from './modules/display.js';

/*
  Exports our data store.
*/
export default new Vuex.Store({
	modules: {
    restaurants,
		users,
		// brewMethods,
		display
	}
});
