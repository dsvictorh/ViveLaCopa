<?php

class Administrador {
    
    private $id_administrador;
    private $nombre;
    private $correo;
    private $id_torneo;
    
    public function get_id_administrador(){
       return $this->id_administrador; 
    }
    
    public function set_id_administrador($value){
        $this->id_administrador = $value;
    }
    
    public function get_nombre(){
       return $this->nombre; 
    }
    
    public function set_nombre($value){
        $this->nombre = $value;
    }
    
    public function get_correo(){
       return $this->correo; 
    }
    
    public function set_correo($value){
        $this->correo = $value;
    }
    
    public function get_id_torneo(){
       return $this->id_torneo; 
    }
    
    public function set_id_torneo($value){
        $this->id_torneo = $value;
    }
    
}
?>
