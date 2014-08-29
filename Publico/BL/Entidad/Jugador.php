<?php

class Jugador{
 
    private $id_jugador;
    private $nombre;
    private $apellido;
    private $cedula;
    private $correo;
    private $telefono;
    private $goles;
    private $amarillas;
    private $rojas;
    private $sanciones;
    private $id_equipo;
    
    public function get_id_jugador(){
       return $this->id_jugador; 
    }
    
    public function set_id_jugador($value){
        $this->id_jugador = $value;
    }
    
    public function get_nombre(){
       return $this->nombre; 
    }
    
    public function set_nombre($value){
        $this->nombre = $value;
    }
    
    public function get_apellido(){
       return $this->apellido; 
    }
    
    public function set_apellido($value){
        $this->apellido = $value;
    }
    
    public function get_cedula(){
       return $this->cedula; 
    }
    
    public function set_cedula($value){
        $this->cedula = $value;
    }
    
    public function get_correo(){
       return $this->correo; 
    }
   
    
    public function set_correo($value){
        $this->correo = $value;
    }
    
    public function get_telefono(){
       return $this->telefono; 
    }
    
    public function set_telefono($value){
        $this->telefono = $value;
    }
    
    public function get_goles(){
       return $this->goles; 
    }
    
    public function set_goles($value){
        $this->goles = $value;
    }
    
    public function get_amarillas(){
       return $this->amarillas; 
    }
    
    public function set_amarillas($value){
        $this->amarillas = $value;
    }
    
    public function get_rojas(){
       return $this->rojas; 
    }
    
    public function set_rojas($value){
        $this->rojas = $value;
    }
    
    public function get_sanciones(){
       return $this->sanciones; 
    }
    
    public function set_sanciones($value){
        $this->sanciones = $value;
    }
    
    public function get_id_equipo(){
       return $this->id_equipo; 
    }
    
    
    public function set_id_equipo($value){
        $this->id_equipo = $value;
    }
}
?>
