<?php

class Game extends Eloquent {
   public $timestamps = false;
   
   
   public function cards() {
       return $this->hasMany('Card');
   }
   
   public function board() {
       return $this->hasOne('Board');
   }
   
   public function players() {
       return $this->hasMany('Player');
   }
   
}

?>