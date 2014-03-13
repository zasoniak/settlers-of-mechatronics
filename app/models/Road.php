<?php

class Road extends Eloquent {
  public $timestamps = false;
    
  public function player()
  {
      return $this->hasOne('Player');
  }

  public static function findByCoords(array $coords)
  {
    return self::where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->first();
  }
    
}
