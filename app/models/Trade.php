<?php

class Trade extends Eloquent {
  
  public $timestamps = false;
  
  public function host()
  {
      return $this->belongsTo('Player', 'host_id');
  }

  public function client()
  {
      return $this->belongsTo('Player', 'client_id');
  }

  public static function makeOffer($offers)
  {
    $trade = new self;

    foreach($offers as $resource => $quantity)
    {
        $trade->{$resource} = $quantity;
    }
    return $trade;
  }
}
