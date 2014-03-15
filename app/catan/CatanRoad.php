<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie dróg i autostrad :P
 *
 * @author Sony
 */
class CatanRoad implements DrawableInterface, PurchasableInterface
{
  /**
   *
   * @var Road road's Eloquent model
   */
  public $model;
  
  public function __construct(Road $road)
  {
    if($road instanceof Road)
    {
      $this->model = $road;
    }
  }
  private function mapX($width,$margin,$offset)
  {
    if (!($this->model->z%10))
    {
      return (30+$this->model->x+($this->model->z + 10)/2)*($width+$margin)*0.1+$offset;
    }
    elseif (!($this->model->x%10))
    {
      return (35+$this->model->x+($this->model->z + 5)/2)*($width+$margin)*0.1+$offset;
    }
    return (30+$this->model->x+($this->model->z + 5)/2)*($width+$margin)*0.1+$offset;
  }
    
  private function mapY($height,$margin,$offset)
  {
    if(!($this->model->z%10))
    {
      return (40+$this->model->z)*($height+$margin)*0.1+$offset;
    }
    else
    {
      return (35+$this->model->z)*($height+$margin)*0.1+$offset;
    }
  }
  private function cssRotation()
  {
    if(!($this->model->x%10))
    {
      return ' x';
    }
    if(!($this->model->y%10))
    {
      return ' y';
    }
  }
  
  public function __toString()
  {
    $colors = array(1=>'red',2=>'blue');
    if(is_null($this->model->player_id))
    {
      $class = 'road active';
    }
    else
    {
      $class = 'road '.$colors[$this->model->player->turn_order];
    }
    $return = '<div road="'.$this->model->id.'" class="'.$class;
    $return .= $this->cssRotation();
    $return .= '" style="left: ';
    $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
    $return .= 'px; top: ';
    $return .= $this->mapY(124, -21, 0); // (hex height + hex vertical margin)/10
    $return .= 'px;">';
    $return .= '</div>';
    return $return;
  }
  
  public function cost()
  {
    return array('wood'=>1,'clay'=>1);
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
    $this->model->player_id = $player->id;
    $player->save();
    $this->model->save();
    return true;
  }
  
  
}
