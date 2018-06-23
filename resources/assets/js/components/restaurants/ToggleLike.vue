<style lang="scss">
  @import '~@/abstracts/_variables.scss';

  span.toggle-like{

    span.like-toggle{
      display: inline-block;
      cursor: pointer;
      color: #8E8E8E;
      font-size: 18px;
      margin-bottom: 5px;

      span.image-container{
        width: 35px;
        text-align: center;
        display: inline-block;
      }
    }

    span.like-count{
      font-family: "Lato", sans-serif;
      font-size: 12px;
      margin-left: 10px;
      color: #8E8E8E;
    }
  }
</style>
<template>
  <span class="toggle-like" v-show="userLoadStatus == 2 && user != ''">
    <span class="like like-toggle" v-on:click="likeRestaurant( restaurant.id )" v-if="!liked && restaurantLoadStatus == 2 && restaurantLikeActionStatus != 1 && restaurantUnlikeActionStatus != 1">
      <span class="image-container">
        <img src="/img/unliked.svg"/>
      </span> Like?
    </span>
    <span class="un-like like-toggle" v-on:click="unlikeRestaurant( restaurant.id )" v-if="liked && restaurantLoadStatus == 2 && restaurantLikeActionStatus != 1 && restaurantUnlikeActionStatus != 1">
      <span class="image-container">
        <img src="/img/liked.svg"/>
      </span> Liked
    </span>
    <loader v-show="restaurantLikeActionStatus == 1 || restaurantUnlikeActionStatus == 1 || restaurantLoadStatus != 2"
            :width="23"
            :height="23"
            :display="'inline-block'">
    </loader>
    <span class="like-count">
      {{ restaurant.likes_count }} likes
    </span>
  </span>
</template>
<script>
  import Loader from '../global/Loader.vue';

  export default {
    components: {
      Loader
    },

    computed: {
      /*
        Retrieves the User Load Status from Vuex
      */
      userLoadStatus(){
        return this.$store.getters.getUserLoadStatus();
      },

      /*
        Retrieves the User from Vuex
      */
      user(){
        return this.$store.getters.getUser;
      },

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
      },

      /*
        Determines if the restaurant is liked or not.
      */
      liked(){
        return this.$store.getters.getRestaurantLikedStatus;
      },

      /*
        Determines if the restaurant is still processing the like action.
      */
      restaurantLikeActionStatus(){
        return this.$store.getters.getRestaurantLikeActionStatus;
      },

      /*
        Determines if the restaurant is still processing the un-like action.
      */
      restaurantUnlikeActionStatus(){
        return this.$store.getters.getRestaurantUnlikeActionStatus;
      }
    },

    methods: {
      likeRestaurant( restaurantID ){
        this.$store.dispatch( 'likeRestaurant', {
          id: this.restaurant.id
        });
      },

      unlikeRestaurant( restaurantID ){
        this.$store.dispatch( 'unlikeRestaurant', {
          id: this.restaurant.id
        });
      }
    }
  }
</script>
