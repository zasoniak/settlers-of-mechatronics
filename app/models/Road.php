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
    
  public function coords($offset = array(0,0,0))
  {
    return array($this->x+$offset[0],$this->y+$offset[1],$this->z+$offset[2]);
  }

  public static function findByCoords($board_id,array $coords)
  {
    return self::where('board_id', $board_id)->where('x', $coords[0])->where('y', $coords[1])->where('z', $coords[2])->first();
  }
  
  public function nearestRoads()
  {
    if($this->x%10 == 0)
    {
      return array(
          $this->board->findRoad($this->coords(array(-5,5,0))),
          $this->board->findRoad($this->coords(array(-5,0,5))),
          $this->board->findRoad($this->coords(array(5,-5,0))),
          $this->board->findRoad($this->coords(array(5,0,-5)))
      );
    }
    if($this->y%10 == 0)
    {
      return array(
          $this->board->findRoad($this->coords(array(-5,5,0))),
          $this->board->findRoad($this->coords(array(0,5,-5))),
          $this->board->findRoad($this->coords(array(5,-5,0))),
          $this->board->findRoad($this->coords(array(0,-5,5)))
      );
    }
    return array(
        $this->board->findRoad($this->coords(array(-5,0,5))),
        $this->board->findRoad($this->coords(array(0,-5,5))),
        $this->board->findRoad($this->coords(array(5,0,-5))),
        $this->board->findRoad($this->coords(array(0,5,-5)))
    );
  }

  public function nearestSettlements()
  {
      if(!($this->x%10))
      {
        return array (
        $this->board->findSettlement($this->coords(array(5,0,0))), 
        $this->board->findSettlement($this->coords(array(-5,0,0)))
                );
      }
      if(!($this->y%10))
      {
        return array (
        $this->board->findSettlement($this->coords(array(0,5,0))), 
        $this->board->findSettlement($this->coords(array(0,-5,0)))
                );
      }
      if(!($this->z%10))
      {
        return array (
        $this->board->findSettlement($this->coords(array(0,0,5))),
        $this->board->findSettlement($this->coords(array(0,0,-5)))
                );
      }

  }
}
