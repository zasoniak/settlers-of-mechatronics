<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie dróg i autostrad :P
 *
 * @author Sony
 */
class CatanRoad implements DrawableInterface
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
    $return = '<div class="road';
    $return .= $this->cssRotation();
    $return .= '" style="left: ';
    $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
    $return .= 'px; top: ';
    $return .= $this->mapY(124, -21, 0); // (hex height + hex vertical margin)/10
    $return .= 'px;">';
    $return .= '</div>';
    return $return;
  }
}
