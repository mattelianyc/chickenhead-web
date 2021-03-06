<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $fillable = [
      'name'
  ];

  public function restaurants(){
    return $this->belongsToMany( 'App\Models\Restaurant', 'restaurants_users_tags', 'tag_id', 'user_id');
  }
}
?>
