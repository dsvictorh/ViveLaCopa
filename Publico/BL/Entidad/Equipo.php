<?php

class Equipo{
     
 private $id_equipo;
 private $nombre;
 private $puntos;
 private $puntos_extra;
 private $estado;
 private $grupo;
 private $posicion;
 private $id_torneo;
        
    public function get_id_equipo(){
       return $this->id_equipo; 
    }
    
    public function set_id_equipo($value){
        $this->id_equipo = $value;
    }
    
    public function get_nombre(){
       return $this->nombre; 
    }
    
    public function set_nombre($value){
        $this->nombre = $value;
    }
    
    public function get_puntos(){
       return $this->puntos; 
    }
    
    public function set_puntos($value){
        $this->puntos = $value;
    }
    
    public function get_puntos_extra(){
       return $this->puntos_extra; 
    }
    
    public function set_puntos_extra($value){
        $this->puntos_extra = $value;
    }
    
    public function get_estado(){
       return $this->estado; 
    }
    
    public function set_estado($value){
        $this->estado = $value;
    }
    
    public function get_grupo(){
       return $this->grupo; 
    }
    
    public function set_grupo($value){
        $this->grupo = $value;
    }
    
    public function get_posicion(){
       return $this->posicion; 
    }
    
    public function set_posicion($value){
        $this->posicion = $value;
    }
    
    public function get_id_torneo(){
       return $this->id_torneo; 
    }
    
    public function set_id_torneo($value){
        $this->id_torneo = $value;
    }
    
 }

?>
