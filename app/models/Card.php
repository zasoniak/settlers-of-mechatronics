<?php

class Card extends Eloquent {
   
  public $timestamps = false;
  
  public function scopeUsed($query)
  {
    return $query->where('is_used',1);
  }
  
  public function scopeUnused($query)
  {
    return $query->where('is_used',0);
  }
  
  public function board(){
      return $this->belongsTo('Board');
  }
  
  public function player()
  {
    return $this->belongsTo('Player');
  }
}
