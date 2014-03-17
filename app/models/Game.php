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
  
  public function currentPlayer()
  {
    return $this->players()->where('turn_order',$this->current_player)->first();
  }
  
  public static function allowedPlayer($game_id)
  {
    $game = self::find($game_id);
    return $game->players()->where('turn_order',$game->current_player)->first();
  }
  
  public function users()
  {
    return $this->belongsToMany('User', 'players');
  }
}

?>