<style lang="scss">
  @import '~@/abstracts/_variables.scss';

  div.restaurant-card{
    border-radius: 5px;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);
    padding: 15px 5px;
    margin-top: 20px;
    cursor: pointer;
    -webkit-transform: scaleX(1) scaleY(1);
    transform: scaleX(1) scaleY(1);
    transition: .2s;

    span.title{
      display: block;
      text-align: center;
      color: black;
      font-size: 18px;
      font-weight: bold;
      font-family: 'Lato', sans-serif;
    }

    span.address{
      display: block;
      text-align: center;
      margin-top: 5px;
      color: $grey;
      font-family: 'Lato', sans-serif;

      span.street{
        font-size: 14px;
        display: block;
      }

      span.city{
        font-size: 14px;
      }

      span.state{
        font-size: 14px;
      }

      span.zip{
        font-size: 14px;
        display: block;
      }
    }

    &:hover{
      -webkit-transform: scaleX(1.041) scaleY(1.041);
      transform: scaleX(1.041) scaleY(1.041);
      transition: .2s;
    }
  }
</style>

<template>
  <div class="large-6 medium-6 small-6 cell restaurant-card-container" v-show="show">
    <router-link :to="{ name: 'restaurant', params: { id: restaurant.id} }" v-on:click.native="panToLocation( restaurant )">
      <div class="restaurant-card">
        <span class="title">{{ restaurant.name }}</span>
        <span class="address">
          <span class="street">{{ restaurant.address }}</span>
          <span class="city">{{ restaurant.city }}</span> <span class="state">{{ restaurant.state }}</span>
          <span class="zip">{{ restaurant.zip }}</span>
        </span>
      </div>
    </router-link>
  </div>
</template>

<script>
  import { RestaurantTypeFilter } from '../../mixins/filters/RestaurantTypeFilter.js';
  // import { RestaurantBrewMethodsFilter } from '../../mixins/filters/RestaurantBrewMethodsFilter.js';
  import { RestaurantTextFilter } from '../../mixins/filters/RestaurantTextFilter.js';
  import { RestaurantUserLikeFilter } from '../../mixins/filters/RestaurantUserLikeFilter.js';

  /*
    Imports the Event Bus to listen to filter updates
  */
  import { EventBus } from '../../event-bus.js';

  export default {
    props: ['restaurant'],

    data(){
      return {
        show: true
      }
    },

    mixins: [
      RestaurantTypeFilter,
      // RestaurantBrewMethodsFilter,
      RestaurantTextFilter,
      RestaurantUserLikeFilter
    ],

    mounted(){
      EventBus.$on('filters-updated', function( filters ){
        this.processFilters( filters );
      }.bind(this));
    },

    methods: {
      processFilters( filters ){
        /*
          If no filters are selected, show the card
        */
        if( filters.text == ''
          && filters.type == 'all'
          && filters.brewMethods.length == 0
          && !filters.liked ){
            this.show = true;
        }else{
          /*
            Initialize flags for the filtering
          */
          var textPassed = false;
          var brewMethodsPassed = false;
          var typePassed = false;
          var likedPassed = false;

          /*
            Check if the roaster passes
          */
          if( this.processRestaurantTypeFilter( this.restaurant, filters.type) ){
            typePassed = true;
          }

          /*
            Check if text passes
          */
          if( filters.text != '' && this.processRestaurantTextFilter( this.restaurant, filters.text ) ){
            textPassed = true;
          }else if( filters.text == '' ){
            textPassed = true;
          }

          /*
            Check if brew methods passes
          */
          if( filters.brewMethods.length != 0 && this.processRestaurantBrewMethodsFilter( this.restaurant, filters.brewMethods ) ){
            brewMethodsPassed = true;
          }else if( filters.brewMethods.length == 0 ){
            brewMethodsPassed = true;
          }

          /*
            Check if liked passes
          */
          if( filters.liked && this.processRestaurantUserLikeFilter( this.restaurant ) ){
            likedPassed = true;
          }else if( !filters.liked ){
            likedPassed = true;
          }

          /*
            If everything passes, then we show the Restaurant Card
          */
          if( typePassed && textPassed && brewMethodsPassed && likedPassed ){
            this.show = true;
          }else{
            this.show = false;
          }
        }
      },

      panToLocation( restaurant ){
        EventBus.$emit('location-selected', { lat: parseFloat( restaurant.latitude ), lng: parseFloat( restaurant.longitude ) });
      }
    }
  }
</script>
