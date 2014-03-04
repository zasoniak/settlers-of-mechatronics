<?php

class Player extends Eloquent{
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function board(){
        return $this->belongsTo('Board');
    }
}