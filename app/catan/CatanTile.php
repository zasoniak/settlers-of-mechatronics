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
    
    private function mapX($width,$margin,$offset)
    {
      return (30+$this->model->x+$this->model->z/2)*($width+$margin)*0.1+$offset;
    }
    
    private function mapY($height,$margin,$offset)
    {
      return (30+$this->model->z)*($height+$margin)*0.1+$offset;
    }
    
    public function __toString()
    {
      $return = '<div class="hex '.$this->model->type;
      $return .= '" style="left: ';
      $return .= $this->mapX(108, 12, 0); // (hex width + hex horizontal margin)/10
      $return .= 'px; top: ';
      $return .= $this->mapY(124, -21, 0); // (hex height + hex vertical margin)/10
      $return .= 'px;">';
      if (!is_null($this->model->probability))
      {
        $return .= '<span>'.$this->model->probability.'</span>';
      }
      $return .= '</div>';
      return $return;
    }
    
    public function toJSON()
    {
      return array(
          'classes' => 'hex '.$this->model->type,
          'attr' => array('tile'=>$this->model->id),
          'styles' => array('left'=>$this->mapX(108, 12, 0).'px','top'=>$this->mapY(124, -21, 0).'px'),
          'prob' => $this->model->probability
      );
    }
}
