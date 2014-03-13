<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie osad i miast
 *
 * @author Sony
 */
class CatanSettlement implements DrawableInterface
{
  /**
   *
   * @var Settlement settlement's Eloquent model
   */
  public $model;
  
  public function __construct(Settlement $settlement)
  {
    if($settlement instanceof Settlement)
    {
      $this->model = $settlement;
    }
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
    $return = '<div class="settle active" style="left: ';
    $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
    $return .= 'px; top: ';
    $return .= $this->mapY(124, -21, 0); // (hex height + hex vertical margin)/10
    $return .= 'px;">';
    $return .= '</div>';
    return $return;
  }
  
  private function costCheck(Player $player=NULL)
  {
      if($player->clay>=1 && $player->sheep>=1 && $player->wood>=1 && $player->wheat>=1)
      {
          $player->clay-=1;
          $player->sheep-=1;
          $player->wood-=1; 
          $player->wheat-=1;
          return true;
      }
      else
      {
          echo "Wal się! Nie stać cię na osadę!";
          return false;
      }   
  }
  
  public function buy(Player $player=NULL)
  {
      if($player instanceof Player)
      {
            if($this->model->player_id==$player->id)
            {
                 $this->upgrade($player);
            }
            else if($this->model->player_id==0)
            {
                if($this->costCheck($player))
                {
                    $this->model->player_id=$player->id;
                    $this->model->save();
                } 
            }
      }

  }
  
  private function upgrade($player)
  {
      if($player->stone>=3 && $player->wheat>=2)
      {
          $player->stone-=3; 
          $player->wheat-=2;
          $this->model->is_town=1;
          $this->model->save();
      }
      else
          echo "nie stać cię na miasto!";
  }
}
