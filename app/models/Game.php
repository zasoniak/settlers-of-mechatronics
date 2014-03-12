<?php

class Game extends Eloquent {
  
  public static function waiting()
  {
    return self::has('players', '<', 4)->where('created_at','>', time()+15*60)->get();
  }

  public function cards() {
    return $this->hasMany('Card');
  }

  public function board() {
    return $this->hasOne('Board');
  }

  public function players() {
    return $this->hasMany('Player');
  }
   
}

?>