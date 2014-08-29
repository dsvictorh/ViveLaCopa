<?php

class Partido {
    
    private $id_partido;
    private $fecha;
    private $hora;
    private $numero_cancha;
    private $detalle;
    private $fase;
    private $tipo;
    private $jugado;
    private $id_torneo;

    
    public function get_id_partido(){
       return $this->id_partido; 
    }
    
    public function set_id_partido($value){
        $this->id_partido = $value;
    }
    
    public function get_fecha(){
       return $this->fecha; 
    }
    
    public function set_fecha($value){
        $this->fecha = $value;
    }
    
    public function get_hora(){
       
      return $this->hora;
    }
    
    public function get_hora_formateada(){
       
        if(substr($this->hora, 0, 1) == "0"){
            
            return substr($this->hora, 1, 1) . ":" . substr($this->hora, 2, 2) . substr($this->hora, 4, 2) ;
            
        }else{
            
            return substr($this->hora, 0, 2) . ":" . substr($this->hora, 2, 2) . substr($this->hora, 4, 2) ; 
           
        }    
    }
    
    public function set_hora($value){
        $this->hora = $value;
    }
    
    public function get_numero_cancha(){
       return $this->numero_cancha; 
    }
    
    public function set_numero_cancha($value){
        $this->numero_cancha = $value;
    }
    
    public function get_detalle(){
       return $this->detalle; 
    }
    
    public function set_detalle($value){
        $this->detalle = $value;
    }
    
    public function get_fase(){
       return $this->fase; 
    }
    
    public function set_fase($value){
        $this->fase = $value;
    }
    
    public function get_tipo(){
       return $this->tipo; 
    }
    
    public function set_tipo($value){
        $this->tipo = $value;
    }
    
    public function get_jugado(){
       return $this->jugado; 
    }
    
    public function set_jugado($value){
        $this->jugado = $value;
    }    
    
    public function get_id_torneo(){
       return $this->id_torneo; 
    }
    
    public function set_id_torneo($value){
        $this->id_torneo = $value;
    }
    

    
}
?>
