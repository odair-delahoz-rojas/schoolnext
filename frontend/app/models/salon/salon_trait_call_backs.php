<?php

trait SalonTraitCallBacks {

 public function _beforeUpdate() { // ANTES de ACTUALIZAR el Registro
   parent::_beforeUpdate();
   if (!$this->is_active) { 
    $this->director_id   = 0;
    $this->codirector_id = 0;
    $this->tot_estudiantes = 0;

    $this->print_state   = '';
    $this->print_state1  = '';
    $this->print_state2  = '';
    $this->print_state3  = '';
    $this->print_state4  = '';
    $this->print_state5  = '';
  }
  //$this->is_ready_print = 0;
 } //END-_beforeUpdate
 
} //END-Trait