<?php

/**
 * klasa odpowiedzialna za mechanikę i wyświetlanie pól planszy
 *
 * @author Sony
 */
class CatanTile implements DrawableInterface
{
    /**
     *
     * @var Tile tile's Eloquent model 
     */
    public $model;
    
    public function __construct(Tile $tile) {
      if($tile instanceof Tile)
      {
        $this->model = $tile;
      }   
    }
    
    public function __toString()
    {
      $return = '<div class="hex '.$this->model->type;
      $return .= '" style="left: ';
      $return .= (30+$this->model->x + ($this->model->z)/2)*14.7; // (hex width + hex horizontal margin)/10
      $return .= 'px; top: ';
      $return .= (30+ $this->model->z)*12.1; // (hex height + hex vertical margin)/10
      $return .= 'px;">';
      if (!is_null($this->model->probability))
      {
        $return .= '<p>'.$this->model->probability.'</p>';
      }
      $return .= '<span>'.$this->model->x.';'.$this->model->y.';'.$this->model->z.'</span>';
      $return .= '</div>';
      return $return;
    }
}
