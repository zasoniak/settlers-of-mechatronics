<?php

class Road extends Eloquent {
  public $timestamps = false;
    
  public function board()
  {
    return $this->belongsTo('Board');
  }
  
  public function player()
  {
    return $this->belongsTo('Player');
  }

  public static function findByCoords($board_id,array $coords)
  {
    return self::where('board_id', $board_id)->where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->first();
  }
    
}
