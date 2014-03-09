<?php

class Game extends Eloquent {
   public $timestamps = false;
   
   
   public function card() {
       return $this->hasMany('Card');
   }
   
   public function board() {
       return $this->hasOne('Board');
   }
   
   public function player() {
       return $this->hasMany('Player');
   }
   
}

?>