<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CatanField
 *
 * @author Sony
 */
class CatanTile implements DrawableInterface
{
    /**
     *
     * @var Tile tile's model for database 
     */
    public $model;
    
    public function __construct(Tile $tile) {
        $this->model = $tile;
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
