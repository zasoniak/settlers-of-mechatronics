<?php

class Tile extends Eloquent {
  public $timestamps = false;

  public function board(){
      return $this->belongsTo('Board');
  }
    
  public function coords($offset = array(0,0,0))
  {
    return array($this->x+$offset[0],$this->y+$offset[1],$this->z+$offset[2]);
  }
    
  public static function findByCoords($board_id, array $coords)
  {
    return self::where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->where('board_id', $board_id)->first();
  }

  public static function findByProb($board_id, $prob)
  {
    return self::where('board_id', $board_id)->where('probability', $prob)->get();
  }
    
  public function nearestSettles()
  {
    $offsets = array(array(5,-5,-5),array(-5,5,-5),array(-5,-5,5),array(5,5,-5),array(5,-5,5),array(-5,5,5));
    $settles = array();
    foreach ($offsets as $offset)
    {
      $settle = $this->board->findSettlement($this->coords($offset));
      if(!is_null($settle))
      {
        array_push($settles, $settle);
      }
    }
    return $settles;
  }
}
