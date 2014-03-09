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
      return (37.5+$this->model->z)*($height+$margin)*0.1+$offset;
    }
    else
    {
      return (35+$this->model->z)*($height+$margin)*0.1+$offset;
    }
  }
  
  public function __toString()
  {
    $return = '<div class="settle" style="left: ';
    $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
    $return .= 'px; top: ';
    $return .= $this->mapY(125, -21, 0); // (hex height + hex vertical margin)/10
    $return .= 'px;">';
    $return .= '</div>';
    return $return;
  }
}
