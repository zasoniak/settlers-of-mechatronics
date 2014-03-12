<?php

class Card extends Eloquent {
   
  public $timestamps = false;
  
    public function board(){
        return $this->belongsTo('Board');
    }
}
