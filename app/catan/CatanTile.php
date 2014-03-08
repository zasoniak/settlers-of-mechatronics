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
      $return = '<div class="hex '.$this->model->type.'">';
      if (!is_null($this->model->probability))
      {
        $return .= '<p>'.$this->model->probability.'</p>';
      }
      $return .= '<span>'.$this->model->x.';'.$this->model->y.';'.$this->model->z.'</span>';
      $return .= '</div>';
      return $return;
    }
}
