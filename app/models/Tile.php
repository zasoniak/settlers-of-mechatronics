<?php

class Tile extends Eloquent {
  public $timestamps = false;

    public function board(){
        return $this->belongsTo('Board');
    }
    
    public function coords()
    {
      return array($this->x, $this->y, $this->z);
    }
    
    public static function findByCoords($board_id, array $coords)
    {
      return self::where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->where('board_id', $board_id)->first();
    }
    
    public static function findByProb($board_id, $prob)
    {
        return self::where('board_id', $board_id)->where('probability', $prob)->get();
    }
}
