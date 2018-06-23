<style lang="scss">
  @import '~@/abstracts/_variables.scss';

  div#restaurant-map-container{
    position: absolute;
    top: 75px;
    left: 0px;
    right: 0px;
    bottom: 0px;

    div#restaurant-map{
      position: absolute;
      top: 0px;
      left: 0px;
      right: 0px;
      bottom: 0px;
    }

    div.restaurant-info-window{
      div.restaurant-name{
        display: block;
        text-align: center;
        color: $dark-color;
        font-family: 'Josefin Sans', sans-serif;
      }

      div.restaurant-address{
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
          font-size: 12px;
        }

        span.state{
          font-size: 12px;
        }

        span.zip{
          font-size: 12px;
          display: block;
        }

        a{
          color: $secondary-color;
          font-weight: bold;
        }
      }
    }
  }
</style>

<template>
  <div id="restaurant-map-container">
    <div id="restaurant-map">

    </div>
  </div>
</template>

<script>
  import { RestaurantTypeFilter } from '../../mixins/filters/RestaurantTypeFilter.js';
  // import { RestaurantBrewMethodsFilter } from '../../mixins/filters/RestaurantBrewMethodsFilter.js';
  import { RestaurantTagsFilter } from '../../mixins/filters/RestaurantTagsFilter.js';
  import { RestaurantTextFilter } from '../../mixins/filters/RestaurantTextFilter.js';
  import { RestaurantUserLikeFilter } from '../../mixins/filters/RestaurantUserLikeFilter.js';

  /*
    Imports the Event Bus to pass updates.
  */
  import { EventBus } from '../../event-bus.js';

  export default {
    props: {
      'latitude': {
        type: Number,
        default: function(){
          return 40.730610
        }
      },
      'longitude': {
        type: Number,
        default: function(){
          return -73.935242
        }
      },
      'zoom': {
        type: Number,
        default: function(){
          return 12
        }
      }
    },

    data(){
      return {

      }
    },

    mixins: [
      RestaurantTypeFilter,
      // RestaurantBrewMethodsFilter,
      RestaurantTagsFilter,
      RestaurantTextFilter,
      RestaurantUserLikeFilter
    ],

    computed: {
      /*
        Gets the restaurants
      */
      restaurants(){
        return this.$store.getters.getRestaurants;
      }
    },

    watch: {
      /*
        Watches the restaurants. When they are updated, clear the markers
        and re build them.
      */
      restaurants(){
        this.clearMarkers();
        this.buildMarkers();
      }
    },

    mounted(){
      this.$markers = [];

      this.$map = new google.maps.Map(document.getElementById('restaurant-map'), {
        center: {lat: this.latitude, lng: this.longitude},
        zoom: this.zoom
      });

      /*
        Clear and re-build the markers
      */
      this.clearMarkers();
      this.buildMarkers();

      /*
        Listen to the filters-updated event to filter the map markers
      */
      EventBus.$on('filters-updated', function( filters ){
        this.processFilters( filters );
      }.bind(this));

      EventBus.$on('location-selected', function( restaurant ){
        var latLng = new google.maps.LatLng( restaurant.lat, restaurant.lng );
        this.$map.setZoom( 17 );
        this.$map.panTo(latLng);
      }.bind(this));
    },

    methods: {
      /*
        Process filters on the map selected by the user.
      */
      processFilters( filters ){
        for( var i = 0; i < this.$markers.length; i++ ){
          if( filters.text == ''
            && filters.type == 'all'
            && filters.brewMethods.length == 0
            && !filters.liked  ){

                this.$markers[i].setMap( this.$map );
              }else{
                /*
                  Initialize flags for the filtering
                */
                var textPassed = false;
                // var brewMethodsPassed = false;
                var typePassed = false;
                var likedPassed = false;


                /*
                  Check if the roaster passes
                */
                if( this.processRestaurantTypeFilter( this.$markers[i].restaurant, filters.type) ){
                  typePassed = true;
                }

                /*
                  Check if text passes
                */
                if( filters.text != '' && this.processRestaurantTextFilter( this.$markers[i].restaurant, filters.text ) ){
                  textPassed = true;
                }else if( filters.text == '' ){
                  textPassed = true;
                }

                /*
                  Check if brew methods passes
                */
                // if( filters.brewMethods.length != 0 && this.processRestaurantBrewMethodsFilter( this.$markers[i].restaurant, filters.brewMethods ) ){
                //   brewMethodsPassed = true;
                // }else if( filters.brewMethods.length == 0 ){
                //   brewMethodsPassed = true;
                // }

                /*
                  Check if liked passes
                */
                if( filters.liked && this.processRestaurantUserLikeFilter( this.$markers[i].restaurant ) ){
                  likedPassed = true;
                }else if( !filters.liked ){
                  likedPassed = true;
                }

                /*
                  If everything passes, then we show the Restaurant Marker
                */
                if( typePassed && textPassed && brewMethodsPassed && likedPassed ){
                  this.$markers[i].setMap( this.$map );
                }else{
                  this.$markers[i].setMap( null );
                }
              }
        }
      },

      /*
        Clears the markers from the map.
      */
      clearMarkers(){
        /*
          Iterate over all of the markers and set the map
          to null so they disappear.
        */
        for( var i = 0; i < this.$markers.length; i++ ){
          this.$markers[i].setMap( null );
        }
      },

      /*
        Builds all of the markers for the restaurants
      */
      buildMarkers(){
        /*
          Initialize the markers to an empty array.
        */
        this.$markers = [];

        /*
          Iterate over all of the restaurants
        */
        for( var i = 0; i < this.restaurants.length; i++ ){

          /*
            Create the marker for each of the restaurants and set the
            latitude and longitude to the latitude and longitude
            of the restaurant. Also set the map to be the local map.
          */

          // if( this.restaurants[i].company.roaster == 1 ){
          //   var image = '/img/roaster-marker.svg';
          // }  else  {
          var image = '/img/logo.svg';  
          //}

          if( this.restaurants[i].latitude != null ){
            var icon = {
                url: image, // url
                scaledSize: new google.maps.Size(45, 45), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            var marker = new google.maps.Marker({
              position: { lat: parseFloat( this.restaurants[i].latitude ), lng: parseFloat( this.restaurants[i].longitude ) },
              map: this.$map,
              icon: icon,
              restaurant: this.restaurants[i]
            });

            let router = this.$router;

            marker.addListener('click', function() {
              router.push( { name: 'restaurant', params: { id: this.restaurant.id } } );
            });

            /*
              Push the new marker on to the array.
            */
            this.$markers.push( marker );
          }
        }
      }
    }
  }
</script>
