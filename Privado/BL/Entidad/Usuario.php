<?php

class Usuario{
    
    private $id_usuario;
    private $usuario;
    private $correo;
    private $tipo;
    private $torneo;
    
    public function get_id_usuario(){
       return $this->id_usuario; 
    }
    
    public function set_id_usuario($value){
        $this->id_usuario = $value;
    }
     
    public function get_usuario(){
       return $this->usuario; 
    }
    
    public function set_usuario($value){
        $this->usuario = $value;
    }
    
    public function get_correo(){
       return $this->correo; 
    }
    
    public function set_correo($value){
        $this->correo = $value;
    }
    
    public function get_tipo(){
       return $this->tipo; 
    }
    
    public function set_tipo($value){
        $this->tipo = $value;
    }
    
    public function get_torneo(){
       return $this->torneo; 
    }
    
    public function set_torneo($value){
        $this->torneo = $value;
    }
    
}
?>
