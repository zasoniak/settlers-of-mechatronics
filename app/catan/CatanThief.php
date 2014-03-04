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
    public $thief;
    public $location;
    
    public function __construct($thiefLocation) {
        $this->thief = new CatanThief;
        $this->location=$thiefLocation;
    }
    public function setThief($newThiefLocation, $knightCard)
    {
        $this->location=$newThiefLocation;
        if(!$knightCard)
        {
            $this->stealResources();
        }
    }
    private function stealResources()
    {
        
    }
    
    public function stealFromPlayer()
    {
        
    }
}
