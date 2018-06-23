<style lang="scss">
  @import '~@/abstracts/_variables.scss';

  div#individual-restaurant-map{
    width: 700px;
    height: 500px;
    margin: auto;
    margin-bottom: 200px;
  }
</style>

<template>
  <div id="individual-restaurant-map">

  </div>
</template>

<script>
  export default {
    /*
      Defines the computed properties on the component.
    */
    computed: {
      /*
        Gets the restaurant load status from the Vuex state.
      */
      restaurantLoadStatus(){
        return this.$store.getters.getRestaurantLoadStatus;
      },

      /*
        Gets the restaurant from the Vuex state.
      */
      restaurant(){
        return this.$store.getters.getRestaurant;
      }
    },

    /*
      Defines the variables we need to watch on the component.
    */
    watch: {
      /*
        The restaurant load status. When the restaurant load status equals 2
        we display the individual restaurant map. We have to wait until the
        restaurant is loaded so we get the lat and long for the restaurant.
      */
      restaurantLoadStatus(){
        if( this.restaurantLoadStatus == 2 ){
          this.displayIndividualRestaurantMap();
        }
      }
    },

    /*
      Defines the methods used by the component.
    */
    methods: {
      /*
        Displays the individual restaurant map.
      */
      displayIndividualRestaurantMap(){
        /*
          Builds the individual restaurant map.
        */
        this.map = new google.maps.Map(document.getElementById('individual-restaurant-map'), {
          center: {lat: parseFloat( this.restaurant.latitude ), lng: parseFloat( this.restaurant.longitude )},
          zoom: 13
        });

        /*
          Defines the image used for the marker.
        */
        var image = '/img/coffee-marker.png';

        /*
          Builds the marker for the restaurant on the map.
        */
        var marker = new google.maps.Marker({
          position: { lat: parseFloat( this.restaurant.latitude ), lng: parseFloat( this.restaurant.longitude )},
          map: this.map,
          icon: image
        });
      }
    }
  }
</script>
