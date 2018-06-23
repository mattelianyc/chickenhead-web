export const RestaurantTextFilter = {
  methods: {
    processRestaurantTextFilter( restaurant, text ){
      /*
        Only process if the text is greater than 0
      */
      if( text.length > 0 ){
        /*
          If the name, location name, address, or city match the text that
          has been added, return true otherwise return false.
        */
        if( restaurant.company.name.toLowerCase().match( '[^,]*'+text.toLowerCase()+'[,$]*' )
          || restaurant.location_name.toLowerCase().match( '[^,]*'+text.toLowerCase()+'[,$]*' )
          || restaurant.address.toLowerCase().match( '[^,]*'+text.toLowerCase()+'[,$]*' )
          || restaurant.city.toLowerCase().match( '[^,]*'+text.toLowerCase()+'[,$]*' )
        ){
          return true;
        }else{
          return false;
        }
      }else{
        return true;
      }
    }
  }
}
