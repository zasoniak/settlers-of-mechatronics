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
    
    public function settlements()
    {
      return $this->hasMany('Settlement');
    }
    
    public function roads()
    {
      return $this->hasMany('Road');
    }
    
    public function ports()
    {
      return $this->hasMany('Port');
    }
    
    public function cards()
    {
        return $this->hasMany('Card');
    }
    
    public static function findByGame($game_id)
    {
        return self::where('game_id', $game_id)->first();
    }
}

?>