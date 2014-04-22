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
  
  public static function findByPlayer($player_id)
  {
      return self::where('player_id', $player_id)->get();
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
  
  public static function searchRoadArray($roads,array $coords)
  {
      foreach($roads as $road)
      {
          if($road->x==$coords[0] && $road->y==$coords[1] && $road->z==$coords[2])
          {
             return $road; 
          }
      }
      return null;
  }
  
  public function findRoute($roads,$usedRoads, $begin=0)
  {
      $begin++;
       var_dump("poczatek: ");
       var_dump($begin);
      $temp=$begin;
      $longest=$begin;
      $usedRoads[array_search($this,$roads)]=1;
        var_dump("uzyte drogi:");
        var_dump($usedRoads);
      //find neighbours
      $neighbours=array();
      $temp1;
      $temp2;
      if($this->x%10 == 0)
      {
        $temp1=Road::searchRoadArray($roads, $this->coords(array(-5,5,0)));
        $temp2=Road::searchRoadArray($roads, $this->coords(array(-5,0,5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
        
        $temp1=Road::searchRoadArray($roads, $this->coords(array(5,-5,0)));
        $temp2=Road::searchRoadArray($roads, $this->coords(array(5,0,-5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
      }
      if($this->y%10 == 0)
      {
        $temp1=Road::searchRoadArray($roads,$this->coords(array(5,-5,0)));
        $temp2=Road::searchRoadArray($roads,$this->coords(array(0,-5,5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
        
        $temp1=Road::searchRoadArray($roads, $this->coords(array(-5,5,0)));
        $temp2=Road::searchRoadArray($roads, $this->coords(array(0,5,-5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
      }
      if($this->z%10 ==0)
      {
        $temp1=Road::searchRoadArray($roads,$this->coords(array(5,0,-5)));
        $temp2=Road::searchRoadArray($roads,$this->coords(array(0,5,-5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
        
        $temp1=Road::searchRoadArray($roads, $this->coords(array(-5,0,5)));
        $temp2=Road::searchRoadArray($roads, $this->coords(array(0,-5,5)));
        if($usedRoads[array_search($temp1,$roads)]==0 && $usedRoads[array_search($temp2,$roads)]==0)
        {
            array_push($neighbours, $temp1);
            array_push($neighbours, $temp2);
        }
      }
      
      foreach($neighbours as $neighbour)
      {
          if(!is_null($neighbour)&&$usedRoads[array_search($neighbour,$roads)]==0)
          {
            $temp=$neighbour->findRoute($roads,$usedRoads,$begin);
            if($temp>=$longest)
            {
              $longest=$temp; 
            } 
          }
      }
      return $longest;
  }
  

  
}
