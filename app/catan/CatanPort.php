<?php

/**
 * Description of CatanPort
 *
 * @author Mroova (co to w ogóle jest za narcyzm? Będziemy liczyć kto więcej napisał w którym pliku? :P)
 */
class CatanPort implements DrawableInterface 
{
    
  public $model;
    
  public function __construct(Port $port)
  {
    if($port instanceof Port)
    {
      $this->model = $port;
    }
  }
  
  public function __toString()
    {
      $return =  '<div class="port ';
      $return .= $this->model->type;
      if($this->model->x==-10)
      {
        $return .= ' dir4';
        $return .= '" style="left: ';
        $return .= '420px; top: 618px;"';
      }
      elseif($this->model->x==0)
      {
        $return .= ' dir4';
        $return .= '" style="left: ';
        $return .= '180px; top: 0px;"';
      }
      elseif($this->model->x==10)
      {
        $return .= ' dir4';
        $return .= '" style="left: ';
        $return .= '600px; top: 515px;"';
      }
      elseif($this->model->y==-10)
      {
        $return .= ' dir0';
        $return .= '" style="left: ';
        $return .= '600px; top: 103px;"';
      }
      elseif($this->model->y==0)
      {
        $return .= ' dir3';
        $return .= '" style="left: ';
        $return .= '180px; top: 618px;"';
      }
      elseif($this->model->y==10)
      {
        $return .= ' dir0';
        $return .= '" style="left: ';
        $return .= '420px; top: 0px;"';
      }
      elseif($this->model->z==-10)
      {
        $return .= ' dir2';
        $return .= '" style="left: ';
        $return .= '60px; top: 206px;"';
      }
      elseif($this->model->z==0)
      {
        $return .= ' dir5';
        $return .= '" style="left: ';
        $return .= '720px; top: 309px;"';
      }
      else
      {
        $return .= ' dir2';
        $return .= '" style="left: ';
        $return .= '60px; top: 412px;"';
      }
      $return .= '></div>';
      return $return;
    }
}
