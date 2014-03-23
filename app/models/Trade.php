<?php

class Trade extends Eloquent {
    
    public function host()
    {
        return $this->belongsTo('Player', 'host_id');
    }
    
    public function client()
    {
        return $this->belongsTo('Player', 'client_id');
    }
    public static function makeOffer($host_id, $offers, $client_id)
    {
        $trade = new self;
        $trade->host_id = $host_id;
        $trade->client_id = $client_id;
        
        foreach($offers as $resource => $quantity)
        {
            $trade->{$resource} = $quantity;
        }
        $trade->save();
        return $trade;
    }
    
}
