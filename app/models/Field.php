<?php

class Field extends Eloquent {

    public function board(){
        return $this->belongsTo('Board');
    }
}
?>