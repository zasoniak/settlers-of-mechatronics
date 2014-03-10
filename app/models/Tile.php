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
    
    public function nearestSettlements()
    {
        $settle = array();
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x+5, $this->y+5, $this->z-5)));
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x+5, $this->y-5, $this->z+5)));
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x-5, $this->y+5, $this->z+5)));
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x+5, $this->y-5, $this->z-5)));
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x-5, $this->y+5, $this->z-5)));
        array_push($settle,$this->board()->settlements()->findByCoords(array($this->x-5, $this->y-5, $this->z+5)));
        return $settle;
    }
}
