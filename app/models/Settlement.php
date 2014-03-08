<?php

class Settlement extends Eloquent {
  public $timestamps = false;
    
    public function board()
    {
        return $this->belongsTo('Board');
    }
    
    public static function findByCoords($board_id, array $coords)
    {
      return Board::find($board_id)->settlements()
              ->whereX($coords[0])
              ->whereY($coords[1])
              ->whereZ($coords[2])
              ->first();
    }
}
