<?php

class Player extends Eloquent{
  public $timestamps = false;
  
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function board(){
        return $this->belongsTo('Game');
    }
}