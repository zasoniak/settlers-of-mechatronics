    <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CatanCard
 *
 * @author Sony
 */
class CardType extends SplEnum{
    const __default = self::knight;
    
    const knight=0;
    const yearOfPlenty=1;
    const roadBuilding=2;
    const victoryPoint=3;
    const monopoly=4;
}
class CatanCard {
   
    public $type;
    public $owner;
    public $isUsed;
    
    public function __construct() {

        
    }
    
    public function takeAction()
    {
     ;   
    }
}
