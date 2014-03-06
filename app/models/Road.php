<?php

class Road extends Eloquent {
  public $timestamps = false;

    public function tile1(){
        return $this->hasOne('Tile');
    }
    
    public function tile2(){
        return $this->hasOne('Tile');
    }
    
    public function player()
    {
        return $this->hasOne('Player');
    }
    
    public static function findByTiles(array $tiles)
    {
      return self::where('tile1_id', $tiles[0])->where('tile2_id', $tiles[1])->first();
    }
}
