<?php

namespace chickenhead\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = 'companies';

  public function cafes(){
  	return $this->hasMany( 'chickenhead\Models\Cafe', 'company', 'id' );
  }

  public function addedBy(){
    return $this->belongsTo('chickenhead\Models\User', 'added_by', 'id');
  }
}
