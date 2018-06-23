export const RestaurantTagsFilter = {
  methods: {
    processRestaurantTagsFilter( restaurant, tags ){
      /*
        If there are tags to be filtered, run the filter.
      */
      if( tags.length > 0 ){
        /*
          Makes array of the tags for the restaurant
        */
        var restaurantTags = [];

        /*
          Make array of restaurant tags this is what we will check to
          see contains a filter.
        */
        for( var i = 0; i < restaurant.tags.length; i++ ){
          restaurantTags.push( restaurant.tags[i].tag );
        }

        /*
          Iterate over all of the tags being filtered.
        */
        for( var i = 0; i < tags.length; i++ ){
          /*
            If the tag is in the array of restaurant tags then
            we return true.
          */
          if( restaurantTags.indexOf( tags[i] ) > -1 ){
            return true;
          }
        }

        /*
          If we made it this far, then we return false because
          the restaurant doesn't contain the tags
        */
        return false;
      }else{
        return true;
      }
    }
  }
}
