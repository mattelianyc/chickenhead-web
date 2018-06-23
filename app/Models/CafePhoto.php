<?php

namespace chickenhead\Models;

use Illuminate\Database\Eloquent\Model;

class CafePhoto extends Model
{
	protected $table = 'cafes_photos';

  public function cafe(){
    return $this->belongsTo('chickenhead\Models\Cafe', 'cafe_id', 'id');
  }

  public function user(){
    return $this->belongsTo('chickenhead\Models\User', 'uploaded_by', 'id');
  }
}
