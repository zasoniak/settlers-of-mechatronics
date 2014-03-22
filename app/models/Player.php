<?php

class Player extends Eloquent{
  public $timestamps = false;
  
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function board(){
        return $this->belongsTo('Game');
    }
    
    public function trade() {
        return $this->hasMany('Trade');
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
        $this->save();
    }
    
    public function stealHalf()
    {
        $sum=$this->countResources();
        echo "tyle ma razem surowki: ";
        echo $sum;
        echo "<br>";
        if($sum>=8)
        {
            $sum=floor($sum/=2);
            $resourceList=array('stone','clay','sheep','wood','wheat');
            $resource;
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
    
    public static function findByGameByUser($game_id, $user_id)
    {
      return self::where('game_id', $game_id)->where('user_id', $user_id)->first();
    }
    
    
}