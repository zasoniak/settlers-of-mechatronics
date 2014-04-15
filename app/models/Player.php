<?php

class Player extends Eloquent{
  public $timestamps = false;
  
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function game()
    {
        return $this->belongsTo('Game');
    }
    
    public function cards()
    {
      return $this->hasMany('Card');
    }
    
    public function settles()
    {
      return $this->hasMany('Settlement');
    }
    
    public function roads()
    {
      return $this->hasMany('Road');
    }
    
    public function tradeReceived() {
        return $this->hasOne('Trade','client_id');
    }
    
    public function tradePending() {
      return $this->tradeReceived()->where('updated', 0)->where('accepted', 0);
    }

    public function tradesHosted() {
      return $this->hasMany('Trade','host_id');
    }
    
    public function tradesReturned()
    {
      return $this->tradesHosted()->where('updated', 1)->orWhere('accepted', 1);
    }
    
    public function getResources()
    {
      return array(
          'wood' => $this->wood,
          'clay' => $this->clay,
          'stone' => $this->stone,
          'wheat' => $this->wheat,
          'sheep' => $this->sheep,
      );
    }
    
    public function countResources()
    {
        $sum = 0;
        $sum+=$this->wood;
        $sum+=$this->stone;
        $sum+=$this->clay;
        $sum+=$this->sheep;
        $sum+=$this->wheat;
        return $sum;
    }
    
    public function addResource($type, $quantity)
    {
        $this->{$type}+=$quantity;
    }
    
    public function stealHalf()
    {
        $sum=$this->countResources();
        if($sum>=8)
        {
            $sum=floor($sum/2);
            $resourceList=array('stone','clay','sheep','wood','wheat');
            while($sum>0)
            {
                $resource=$resourceList[mt_rand(0,4)];
                if($this->{$resource}>0)
                {
                    $this->{$resource}-=1;
                    $sum--;
                }
            }
            $this->save();
            return true;
        }
        return false;   
    }
    
    public function stealRandom()
    {
      $resources = array();
      foreach($this->getResources() as $res => $quentity)
      {
        for($i = 0; $i < $quantity; $i++)
        {
          array_push($resources, $res);
        }
      }
      $resource = $resources[array_rand($resources)];
      $this->{$resource}--;
      $this->save();
      return $resource;
    }
    
    public function countSettles()
    {
      return $this->settles()->where('is_town',0)->count();
    }
    
    public function countTowns()
    {
      return $this->settles()->where('is_town',1)->count();
    }
    
    public function countRoads()
    {
      return $this->roads()->count();
    }
    
    public function countCards()
    {
      return $this->cards()->count();
    }
       
    public static function findByGameByUser($game_id, $user_id)
    {
      return self::where('game_id', $game_id)->where('user_id', $user_id)->first();
    }
    
    public function getScore()
    {
      $points = 0;
      $points += $this->countSettles();
      $points += 2*$this->countTowns();
      $points += 2*$this->has_biggest_army;
      $points += 2*$this->has_longest_route;
      $points += $this->cards()->where('type','victorypoint')->count();
      return $points;
    }
}