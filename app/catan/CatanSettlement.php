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
    if(is_null($this->model->player_id))
    {
      $class = 'settle active';
    }
    else
    {
      $class = 'settle '.$this->model->player->color;
    }
    $return = '<div settle="'.$this->model->id.'" class="'.$class.'" style="left: ';
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
      $classes = 'settle active';
    }
    else
    {
      $classes = 'settle '.$this->model->player->color;
    }
    return array(
        'classes' => $classes,
        'attr' => array('settle'=>$this->model->id),
        'styles' => array('left'=>$this->mapX(108, 12, 0).'px','top'=>$this->mapY(124, -21, 0).'px')
    );
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
    if(!$this->buildCheck($player->id))
    {
        return false;
    }
        foreach ($this->cost() as $resource => $quantity)
        {
          $player->{$resource} -= $quantity;
        }
        if(is_null($this->model->player_id))
        {
          $this->model->player_id = $player->id;
          $this->deleteNeighbours();
        }
    $player->save();
    $this->model->save();
    return true;
  }
  
   public function deleteNeighbours()
   {
    $neighbours=array(array());
    $sum=$this->model->x+$this->model->y+$this->model->z;
    if($sum==-5)
    {
        $neighbours=array(array(10,0,0),array(0,10,0),array(0,0,10));
    }else {
        $neighbours=array(array(-10,0,0),array(0,-10,0),array(0,0,-10));
    }
    
    foreach($neighbours as $neighbour)
    {
        $settle = Settlement::findByCoords($this->model->board->id, array($this->model->x+$neighbour[0],$this->model->y+$neighbour[1],$this->model->z+$neighbour[2]));
        if(!is_null($settle))
        {
            $settle->delete();
        }
    }
   }
   
   public function buildCheck($player_id)
   {
       $coords=array($this->model->x,$this->model->y,$this->model->z);
       $sum=$this->model->x+$this->model->y+$this->model->z;
       
       if($sum==-5)
       {
           $neighbours=array(array(5,0,0),array(0,5,0),array(0,0,5));
           foreach($neighbours as $neighbour)
           {
               $road=Road::findByCoords($this->model->board->id,array($coords[0]+$neighbour[0],$coords[1]+$neighbour[1],$coords[2]+$neighbour[2]));
               if(!is_null($road))
               {
                if(!is_null($road->player_id)&&($road->player_id==$player_id))
                {
                     return true;
                } 
               }
           }
       }
       if($sum==5)
       {
           $neighbours=array(array(-5,0,0),array(0,-5,0),array(0,0,-5));
           foreach($neighbours as $neighbour)
           {
               $road=Road::findByCoords($this->model->board->id,array($coords[0]+$neighbour[0],$coords[1]+$neighbour[1],$coords[2]+$neighbour[2]));
               if(!is_null($road))
               {
                if(!is_null($road->player_id)&&($road->player_id==$player_id))
                {
                     return true;
                } 
               }
           }
       }
       return false;
   }
}
