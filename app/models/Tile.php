<?php

class Tile extends Eloquent {
  public $timestamps = false;

    public function board(){
        return $this->belongsTo('Board');
    }
    
    public static function findByCoords($board_id, array $coords)
    {
      return self::where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->where('board_id', $board_id)->first();
    }
}
