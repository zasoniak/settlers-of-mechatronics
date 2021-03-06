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
  
  public function reject()
  {
    $this->updated = 1;
    $this->save();
  }
  
  public function confirm()
  { 
    if($this->accepted)
    {
      $host = $this->host;
      $client = $this->client;
      $resources = array('wood','sheep','clay','stone','wheat');
      foreach ($resources as $resource)
      {
        $host->addResource($resource, $this->{$resource});
        $client->addResource($resource, -$this->{$resource});
      }
      $client->transactions_made++;
      $host->transactions_made++;
      $host->save();
      $client->save();
      return true;
    }
    else
    {
      throw new Exception('Ta oferta nie została zaakceptowana przez klienta.');
    }
  }
  
  public static function findByHostByClient($host_id, $client_id)
  {
    return self::where('host_id', $host_id)->where('client_id', $client_id)->first();
  }
}
