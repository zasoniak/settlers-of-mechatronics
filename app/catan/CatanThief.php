<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CatanThief
 *
 * @author Sony
 */
class CatanThief {
    public $location;
    
    public function __construct($thiefLocation) {
        $this->location=$thiefLocation;
    }
    public function setThief($newLocation, $knightCard)
    {
        $this->location=$newLocation;
        if(!$knightCard)
        {
            $this->stealResources();
        }
    }
    public static function stealResources($playerList)
    {
        $sum;
        foreach($playerList as $player)
        {
            $sum=0;
            $sum+=$player->stone;
            $sum+=$player->wheat;
            $sum+=$player->wood;
            $sum+=$player->sheep;
            $sum+=$player->clay;
            
            if($sum>=8)
            {
               //requesty dla playerow by oddali zasoby 
            }
            
        }
    }
    
    public function stealFromPlayer($player, $playerThief)
    {
        $resourceList = array('wood', 'stone', 'clay','sheep','wheat');
        shuffle($resource);
        $check=0;
        $resource;
        while(!check ||$resource!=NULL)
        {   
            $resource=array_pop($resourceList);     //losuje surowiec
            if($player->{$resource}!=0)             //jeśli go posiada
            {
                $player->{$resource}-=1;            //zabiera 1 graczowi
                $playerThief->{$resource}+=1;      //dodaje 2 graczowi
                $check=1;
            }
        }
        
    }
}
