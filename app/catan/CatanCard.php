<?php\
/**
 * Description of CatanCard
 *
 * @author Sony
 */
class CatanCard implements PurchasableInterface {
   
    public $type;
    public $owner;
    public $isUsed;
    
    public function play()
    {
        if($this->model->type=="victoryPoint");
        {
            $player=$this->model->player;
            $player->score+=1;
            $player->save();
        }
        //jak obsluzyc reszte?
        
    }
    
  
    public function cost()
    {
        return array('sheep'=>1,'wheat'=>1, 'stone'=>1);
    }
    
    public function buy(Player $player)
    {
        foreach ($this->cost() as $resource => $quantity)
        {
          if($player->{$resource} < $quantity)
          {
            return false;
          }
        }
        foreach ($this->cost() as $resource => $quantity)
        {
          $player->{$resource} -= $quantity;
        }
        if(is_null($this->model->player_id))
        {
          $this->model->player_id = $player->id;
        }
      $player->save();
      $this->model->save();
      return true;
    }
}
