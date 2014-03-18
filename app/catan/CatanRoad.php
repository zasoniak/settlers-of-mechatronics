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
    if(is_null($this->model->player_id))
    {
      $class = 'road active';
    }
    else
    {
      $class = 'road '.$this->model->player->color;
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
  
  public function toJSON()
  {
    if(is_null($this->model->player_id))
    {
      $classes = 'road active';
    }
    else
    {
      $classes = 'road '.$this->model->player->color;
    }
    $classes .= $this->cssRotation();
    return array(
        'classes' => $classes,
        'attr' => array('road'=>$this->model->id),
        'styles' => array('left'=>$this->mapX(108, 12, 0).'px','top'=>$this->mapY(124, -21, 0).'px')
    );
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
    if(!$this->buildCheck($player->id))
    {
        return false;
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
  
  public function buildCheck($player_id)
  {
      $coords=array($this->model->x, $this->model->y, $this->model->z);
               
      if(($coords[0]%10)==0)
      {
          $neighbours = array(array (-5,5,0),array(-5,0,5), array(5,-5,0), array(5,0,-5));
          foreach($neighbours as $neighbour)
          {
              $road=Road::findByCoords($this->model->board->id,array($coords[0]+$neighbour[0],$coords[1]+$neighbour[1],$coords[2]+$neighbour[2]));
              if(!is_null($road))
              if(!is_null($road->player_id)&&$road->player_id==$player_id)
              {
                  return true;
              }
          }
      }
      
      if(($coords[1]%10)==0)
      {
          $neighbours = array(array (-5,5,0),array(0,5,-5), array(5,-5,0), array(0,-5,5));
          foreach($neighbours as $neighbour)
          {
              $road=Road::findByCoords($this->model->board->id,array($coords[0]+$neighbour[0],$coords[1]+$neighbour[1],$coords[2]+$neighbour[2]));
              if(!is_null($road))
              if(!is_null($road->player_id)&&$road->player_id==$player_id)
              {
                  return true;
              }
          }
      }
      
      
      if(($coords[2]%10)==0)
      {
          $neighbours = array(array (-5,0,5),array(-0,-5,5), array(5,0,-5), array(0,5,-5));
          foreach($neighbours as $neighbour)
          {
              $road=Road::findByCoords($this->model->board->id,array($coords[0]+$neighbour[0],$coords[1]+$neighbour[1],$coords[2]+$neighbour[2]));
              if(!is_null($road->player_id)&&$road->player_id==$player_id)
              {
                  return true;
              }
          }
      }
        
      return false;
  }
  
}
