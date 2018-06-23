<style>

</style>

<template>
  <div id="restaurants" class="page">
    <restaurant-map></restaurant-map>

    <add-restaurant-button></add-restaurant-button>

    <router-view></router-view>
  </div>
</template>

<script>
  import RestaurantMap from '../components/restaurants/RestaurantMap.vue';
  import AddRestaurantButton from '../components/restaurants/AddRestaurantButton.vue';

  export default {
    components: {
      RestaurantMap,
      AddRestaurantButton
    }
  }
</script>
