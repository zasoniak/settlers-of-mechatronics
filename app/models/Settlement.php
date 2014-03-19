<?php

class Settlement extends Eloquent {
  public $timestamps = false;
  protected $softDelete = true;
    
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
    
    public function sum()
    {
      return $this->x+$this->y+$this->z;
    }
    
    public static function findByCoords($board_id, array $coords)
    {
      return Board::find($board_id)->settlements()
              ->whereX($coords[0])
              ->whereY($coords[1])
              ->whereZ($coords[2])
              ->first();
    }
    
    public function nearestRoads()
    {
      if($this->sum() == -5)
      {
        return array(
          $this->board->findRoad($this->coords(array(5,0,0))),
          $this->board->findRoad($this->coords(array(0,5,0))),
          $this->board->findRoad($this->coords(array(0,0,5)))
        );
      }
      else
      {
        return array(
          $this->board->findRoad($this->coords(array(-5,0,0))),
          $this->board->findRoad($this->coords(array(0,-5,0))),
          $this->board->findRoad($this->coords(array(0,0,-5)))
        );
      }
    }
    
    public function nearestSettles()
    {
      if($this->sum() == -5)
      {
        return array(
          $this->board->findSettlement($this->coords(array(10,0,0))),
          $this->board->findSettlement($this->coords(array(0,10,0))),
          $this->board->findSettlement($this->coords(array(0,0,10)))
        );
      }
      else
      {
        return array(
          $this->board->findSettlement($this->coords(array(-10,0,0))),
          $this->board->findSettlement($this->coords(array(0,-10,0))),
          $this->board->findSettlement($this->coords(array(0,0,-10)))
        );
      }
    }
}
