export const RestaurantTypeFilter = {
  methods: {
    processRestaurantTypeFilter( restaurant, type ){
      switch( type ){
        case 'roasters':
          if( restaurant.company.roaster == 1 ){
            return true;
          }else{
            return false;
          }
        break;
        case 'restaurants':
          if( restaurant.company.roaster == 0 ){
            return true;
          }else{
            return false;
          }
        break;
        case 'all':
          return true;
        break;
      }
    }
  }
}
