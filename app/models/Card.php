<?php

class Card extends Eloquent {
   
  public $timestamps = false;
  
    public function game(){
        return $this->belongsTo('Game');
    }
}
