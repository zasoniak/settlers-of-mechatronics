<?php

class Port extends Eloquent {
  public $timestamps = false;
  
  public function board(){
        return $this->belongsTo('Board');
    }
}