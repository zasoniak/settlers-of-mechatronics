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
    
    /**
     *
     * @var Field field's model for database 
     */
    public $field;
    
    public function __construct($board_id, $fieldType) {
        $this->field = Field::create();
    }
}
