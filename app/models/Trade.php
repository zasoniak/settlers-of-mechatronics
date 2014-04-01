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
  
  public function accept($offer)
  {
    $changed = false;
    foreach($offer as $resource => $quantity)
    {
      if($this->{$resource} != $quantity)
      {
        $this->{$resource} = $quantity;
        $changed = true;
      }
    }
    if($changed)
    {
      $this->updated = 1;
    }
    $this->accepted = 1;
    $this->save();
  }
  
  public static function findByHostByClient($host_id, $client_id)
  {
    return self::where('host_id', $host_id)->where('client_id', $client_id)->first();
  }
}
