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
class CatanField {
    
    
    public $field;
    
    public function __construct() {
        $this->field = Field::create();
    }
}
