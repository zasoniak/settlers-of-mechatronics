<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie osad i miast
 *
 * @author Sony
 */
class CatanSettlement implements DrawableInterface, PurchasableInterface
{
  /**
   *
   * @var Settlement settlement's Eloquent model
   */
  public $model;
  
  public function __construct(Settlement $settlement)
  {
    $this->model = $settlement;
  }
  
  private function mapX($width,$margin,$offset)
  {
    $sum=$this->model->x+$this->model->y+$this->model->z;
    if($sum==-5)
    {
      return (35+$this->model->x+($this->model->z + 5)/2)*($width+$margin)*0.1+$offset;
    }
    else
    {
      return (30+$this->model->x+($this->model->z + 5)/2)*($width+$margin)*0.1+$offset;
    }
  }
    
  private function mapY($height,$margin,$offset)
  {
    $sum=$this->model->x+$this->model->y+$this->model->z;
    if($sum==-5)
    {
      return (38.33+$this->model->z)*($height+$margin)*0.1+$offset;
    }
    else
    {
      return (35+$this->model->z)*($height+$margin)*0.1+$offset;
    }
  }
  
  public function __toString()
  {
    $colors = array(1=>'red',2=>'blue');
    if(is_null($this->model->player_id))
    {
      $class = 'settle active';
    }
    else
    {
      $class = 'settle '.$colors[$this->model->player->turn_order];
    }
    $return = '<div settle="'.$this->model->id.'" class="'.$class.'" style="left: ';
    $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
    $return .= 'px; top: ';
    $return .= $this->mapY(124, -21, 0); // (hex height + hex vertical margin)/10
    $return .= 'px;">';
    $return .= '</div>';
    return $return;
  }
  
  public function cost()
  {
    if (is_null($this->model->player_id))
    {
      return array('clay'=>1,'wood'=>1,'sheep'=>1,'wheat'=>1); 
    }
    return array('stone'=>3,'wheat'=>2);
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
    else
    {
      $this->model->is_town = 1;
    }
    $player->save();
    $this->model->save();
    return true;
  }
}
