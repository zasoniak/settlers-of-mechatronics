<?php

class Port extends Eloquent {
  public $timestamps = false;
  
    public function board(){
        return $this->belongsTo('Board');
    }
    
    public function coords($offset = array(0,0,0))
    {
      return array($this->x+$offset[0],$this->y+$offset[1],$this->z+$offset[2]);
    }
    
  public function nearestSettlements()
  {
      if(!($this->x%10))
      {
        return array (
        $this->board()->findSettlement($this->coords(5,0,0)), 
        $this->board()->findSettlement($this->coords(-5,0,0))
                );
      }
      if(!($this->y%10))
      {
        return array (
        $this->board()->findSettlement($this->coords(0,5,0)), 
        $this->board()->findSettlement($this->coords(0,-5,0))
                );
      }
      if(!($this->z%10))
      {
        return array (
        $this->board()->findSettlement($this->coords(0,0,5)),
        $this->board()->findSettlement($this->coords(0,0,-5))
                );
      }

  }
}