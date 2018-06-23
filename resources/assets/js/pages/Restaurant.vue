<style lang="scss">
  @import '~@/abstracts/_variables.scss';

  div#restaurant-page{
    position: absolute;
    right: 30px;
    top: 125px;
    background: #FFFFFF;
    box-shadow: 0 2px 4px 0 rgba(3,27,78,0.10);
    width: 100%;
    max-width: 480px;
    padding: 20px;
    padding-top: 10px;

    img.close-icon{
      float: right;
      cursor: pointer;
      margin-top: 10px;
    }

    h2.restaurant-title{
      color: #342C0C;
      font-size: 36px;
      line-height: 44px;
      font-family: "Lato", sans-serif;
      font-weight: bolder;
    }

    span.location-number{
      display: inline-block;
      color: #8E8E8E;
      font-size: 18px;

      span.location-image-container{
        width: 35px;
        text-align: center;
        display: inline-block;
      }
    }

    label.restaurant-label{
      font-family: "Lato", sans-serif;
      text-transform: uppercase;
      font-weight: bold;
      color: black;
      margin-top: 20px;
      margin-bottom: 10px;
    }

    div.location-type{
      color: white;
      font-family: "Lato", sans-serif;
      font-size: 16px;
      width: 105px;
      height: 45px;
      text-align: center;
      line-height: 45px;
      border-radius: 3px;

      img{
        margin-right: 5px;
      }

      &.roaster{
        background-color: $secondary-color;
      }

      &.restaurant{
        background-color: #3D281E;

        img{
          margin-top: -6px;
        }
      }
    }

    div.brew-method{
      font-size: 16px;
      color: #666666;
      font-family: "Lato", sans-serif;
      border-radius: 4px;
      background-color: #F9F9FA;
      width: 150px;
      height: 57px;
      float: left;
      margin-right: 10px;
      margin-bottom: 10px;
      padding: 5px;
      cursor: pointer;
      position: relative;

      div.brew-method-container{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);

        img.brew-method-icon{
          display: inline-block;
          margin-right: 10px;
          margin-left: 5px;
          width: 20px;
          max-height: 30px;
        }

        span.brew-method-name{
          display: inline-block;
          width: calc( 100% - 40px);
          vertical-align: middle;
        }
      }
    }

    div.address-container{
      color: #666666;
      font-size: 18px;
      line-height: 23px;
      font-family: "Lato", sans-serif;
      margin-bottom: 5px;

      span.address{
        display: block;
      }

      span.city-state{
        display: block;
      }

      span.zip{
        display: block;
      }
    }

    a.restaurant-website{
      font-family: "Lato", sans-serif;
      color: #543729;
      font-size: 18px;
    }

    a.suggest-restaurant-edit{
      font-family: "Lato", sans-serif;
      color: #054E7A;
      font-size: 14px;
      display: inline-block;
      margin-top: 30px;
      text-decoration: underline;
    }
  }

  /* Small only */
  @media screen and (max-width: 39.9375em) {
    div#restaurant-page{
      position: fixed;
      right: 0px;
      left: 0px;
      top: 0px;
      bottom: 0px;
      z-index: 99999;
    }
  }

  /* Medium only */
  @media screen and (min-width: 40em) and (max-width: 63.9375em) {

  }

  /* Large only */
  @media screen and (min-width: 64em) and (max-width: 74.9375em) {

  }
</style>

<template>
  <div id="restaurant-page" v-if="restaurantLoadStatus == 2 || ( restaurantLoadStatus != 2 && ( restaurantLikeActionStatus == 1 || restaurantLikeActionStatus == 2 || restaurantUnlikeActionStatus == 1 || restaurantUnlikeActionStatus == 2 ) )">
    <router-link :to="{ name: 'restaurants' }">
      <img class="close-icon" src="/img/close-icon.svg"/>
    </router-link>
    <h2 class="restaurant-title">{{ restaurant.name }}</h2>
    <div class="grid-x">
      <div class="large-12 medium-12 small-12 cell">
        <toggle-like></toggle-like>
      </div>
    </div>
    <div class="grid-x" v-if="restaurant.count == 1">
      <div class="large-12 medium-12 small-12 cell">
        <span class="location-number">
          <span class="location-image-container">
            <img src="/img/location.svg"/>
          </span> 
        </span>
      </div>
    </div>
    <div class="grid-x">
      <div class="large-12 medium-12 small-12 cell">
        <!-- <label class="restaurant-label">Location Type</label> -->
        <!-- <div class="location-type roaster" v-if="restaurant.company.roaster == 1">
          <img src="/img/roaster-logo.svg"/> Roaster
        </div>
        <div class="location-type restaurant" v-if="restaurant.company.roaster == 0">
          <img src="/img/restaurant-logo.svg"/> restaurant
        </div> -->
      </div>
    </div>
    <div class="grid-x">
      <div class="large-12 medium-12 small-12 cell">
        <!-- <label class="restaurant-label">Brew Methods</label>
        <div class="brew-method" v-for="method in restaurant.brew_methods">
          <div class="brew-method-container">
            <img v-bind:src="method.icon+'.svg'" class="brew-method-icon"/> <span class="brew-method-name">{{ method.method }}</span>
          </div>
        </div> -->
      </div>
    </div>
    <div class="grid-x">
      <div class="large-12 medium-12 small-12 cell">
        <label class="restaurant-label">Location And Information</label>
        <div class="address-container">
          <span class="address">{{ restaurant.address }}</span>
          <span class="city-state">{{ restaurant.city }}, {{ restaurant.state }}</span>
          <span class="zip">{{ restaurant.zip }}</span>
          <span class="latitude">{{ restaurant.latitude }}</span>
          <span class="longitude">{{ restaurant.longitude }}</span>
        </div>

        <a class="restaurant-website" target="_blank" v-bind:href="restaurant.website">{{ restaurant.website }}</a>
        <br>
        <router-link :to="{ name: 'editrestaurant', params: { id: restaurant.id } }" v-show="userLoadStatus == 2 && user != ''" class="suggest-restaurant-edit">
          Suggest an edit
        </router-link>
        <a class="suggest-restaurant-edit" v-if="userLoadStatus == 2 && user == ''" v-on:click="loginToEdit()">
          Sign in to make an edit
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  import { EventBus } from '../event-bus.js';

  /*
    Import the loader and restaurant map for use in the component.
  */
  import Loader from '../components/global/Loader.vue';
  import IndividualRestaurantMap from '../components/restaurants/IndividualRestaurantMap.vue';
  import ToggleLike from '../components/restaurants/ToggleLike.vue';

  export default {
    /*
      Defines the components used by the page.
    */
    components: {
      Loader,
      IndividualRestaurantMap,
      ToggleLike
    },

    /*
      When created, load the restaurant based on the ID in the
      route parameter.
    */
    created(){
      this.$store.dispatch( 'loadRestaurant', {
        id: this.$route.params.id
      });
    },

    watch: {
      '$route.params.id': function(){
        this.$store.dispatch( 'clearLikeAndUnlikeStatus' );
        this.$store.dispatch( 'loadRestaurant', {
          id: this.$route.params.id
        });
			},

      'restaurantLoadStatus': function(){
        if( this.restaurantLoadStatus == 2 ){
          EventBus.$emit('location-selected', { lat: parseFloat( this.restaurant.latitude ), lng: parseFloat( this.restaurant.longitude ) });
        }

        if( this.restaurantLoadStatus == 3 ){
          EventBus.$emit('show-error', { notification: 'Restaurant Not Found!'} );
          this.$router.push({ name: 'restaurants' });
        }
      }
    },


    /*
      Defines the computed variables on the restaurant.
    */
    computed: {
      /*
        Grabs the restaurant load status from the Vuex state.
      */
      restaurantLoadStatus(){
        return this.$store.getters.getRestaurantLoadStatus;
      },

      restaurantLikeActionStatus(){
        return this.$store.getters.getRestaurantLikeActionStatus;
      },

      restaurantUnlikeActionStatus(){
        return this.$store.getters.getRestaurantUnlikeActionStatus;
      },

      /*
        Grabs the restaurant from the Vuex state.
      */
      restaurant(){
        return this.$store.getters.getRestaurant;
      },

      /*
        Gets the authenticated user.
      */
      user(){
        return this.$store.getters.getUser;
      },

      /*
        Gets the user's load status.
      */
      userLoadStatus(){
        return this.$store.getters.getUserLoadStatus();
      }
    },

    /*
      Defines the methods used by the component.
    */
    methods: {
      loginToEdit(){
        EventBus.$emit('prompt-login');
      }
    }
  }
</script>
