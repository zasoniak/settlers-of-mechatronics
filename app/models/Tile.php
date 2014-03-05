<?php

class Tile extends Eloquent {

    public function board(){
        return $this->belongsTo('Board');
    }
}
?>