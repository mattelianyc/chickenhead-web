export const RestaurantUserLikeFilter = {
  methods: {
    processRestaurantUserLikeFilter( restaurant ){
      /*
        Checks to see if the restaurant is liked by the user
      */
      if( restaurant.user_like_count == 1 ){
        return true;
      }else{
        return false;
      }
    }
  }
}
