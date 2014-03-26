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
    
    public function availableCards()
    {
      return $this->cards()->whereNull('player_id')->get();
    }
    
    public function availableCard()
    {
      return $this->cards()->whereNull('player_id')->take(1)->first();
    }
    
    public static function findByGame($game_id)
    {
        return self::where('game_id', $game_id)->first();
    }
    
    public function findSettlement(array $coords)
    {
      return $this->settlements()
              ->whereX($coords[0])
              ->whereY($coords[1])
              ->whereZ($coords[2])
              ->first();
    }
    
    public function findRoad(array $coords)
    {
      return $this->roads()
              ->whereX($coords[0])
              ->whereY($coords[1])
              ->whereZ($coords[2])
              ->first();
    }
    
    public function findDicedTiles($dice)
    {
      return $this->tiles()
              ->where('probability', $dice)
              ->get();
    }
}

?>