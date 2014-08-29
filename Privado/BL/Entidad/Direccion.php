<?php

class Direccion {
    
  private $id_direccion;
  private $provincia;
  private $canton;
  private $distrito;
  private $direccion;
  private $nombre_cancha;
  private $id_torneo;
  
    public function get_id_direccion(){
       return $this->id_direccion; 
    }
    
    public function set_id_direccion($value){
        $this->id_direccion = $value;
    }
  
    public function get_provincia(){
        return $this->provincia;
    }
    
    public function set_provincia($value){
        $this->provincia = $value;
    }
    
     public function get_canton(){
        return $this->canton;
    }
    
    public function set_canton($value){
        $this->canton = $value;
    }
    
     public function get_distrito(){
        return $this->distrito;
    }
    
    public function set_distrito($value){
        $this->distrito = $value;
    }
    
     public function get_direccion(){
        return $this->direccion;
    }
    
    public function set_direccion($value){
        $this->direccion = $value;
    }
    
     public function get_nombre_cancha(){
        return $this->nombre_cancha;
    }
    
    public function set_nombre_cancha($value){
        $this->nombre_cancha = $value;
    }
    
    public function get_id_torneo(){
       return $this->id_torneo; 
    }
    
    public function set_id_torneo($value){
        $this->id_torneo = $value;
    }
}
?>
