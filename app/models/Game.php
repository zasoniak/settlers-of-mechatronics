<?php

class Game extends Eloquent {
  
  public static function waiting()
  {
    return self::has('players', '<', 4)->get();
  }

  public function board() {
    return $this->hasOne('Board');
  }

  public function players() {
    return $this->hasMany('Player');
  }
  
  public function users()
  {
    return $this->belongsToMany('User', 'players');
  }
}

?>