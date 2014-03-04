<?php

class Board extends Eloquent {
   
    public function game(){
        return $this->belongsTo('Game');
    }
}

?>