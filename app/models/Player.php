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
    
    public function stealHalf()
    {
        $sum=$this->countResources();
        if($sum>=8)
        {
            $sum=floor($sum/=2);
            $resourceList=array('stone','clay','sheep','wood','wheat');
            $resource;
            while($sum>0)
            {
                $resource=$resourceList[rand(0,4)];
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
}