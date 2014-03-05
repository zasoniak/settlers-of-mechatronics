<?php

class Board extends Eloquent {
   
  public $timestamps = false;
  
    public function game(){
        return $this->belongsTo('Game');
    }
    
    public function tiles()
    {
      return $this->hasMany('Tile');
    }
}

?>