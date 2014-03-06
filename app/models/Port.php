<?php

class Port extends Eloquent {
  public $timestamps = false;

  public function tile1(){
      return $this->hasOne('Tile');
  }
  
    public function tile2(){
      return $this->hasOne('Tile');
  }
  
}