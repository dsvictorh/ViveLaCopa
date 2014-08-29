<?php

class Torneo{
    
    private $id_torneo;
    private $nombre_torneo;
    private $fecha_inicio;
    private $fecha_fin;
    private $detalle;
    private $precio;
    private $primer_premio;
    private $segundo_premio;
    private $tercer_premio;
    private $descripcion_precio;
    private $fase;
    private $estado;
    private $numero_fases;
    private $reglamento;
    
    public function get_id_torneo(){
       return $this->id_torneo; 
    }
    
    public function set_id_torneo($value){
        $this->id_torneo = $value;
    }
    
    public function get_nombre_torneo(){
       return $this->nombre_torneo; 
    }
    
    public function set_nombre_torneo($value){
        $this->nombre_torneo = $value;
    }
    
    public function get_fecha_inicio(){
       return $this->fecha_inicio; 
    }
    
    public function set_fecha_inicio($value){
        $this->fecha_inicio = $value;
    }
    
    public function get_fecha_fin(){
       return $this->fecha_fin; 
    }
    
    public function set_fecha_fin($value){
        $this->fecha_fin = $value;
    }
    
    public function get_detalle(){
       return $this->detalle; 
    }
    
    public function set_detalle($value){
        $this->detalle = $value;
    }
    
    public function get_precio(){
       return $this->precio; 
    }
    
    public function set_precio($value){
        $this->precio = $value;
    }
    
    public function get_primer_premio(){
       return $this->primer_premio; 
    }
    
    public function set_primer_premio($value){
        $this->primer_premio = $value;
    }
    
    public function get_segundo_premio(){
       return $this->segundo_premio; 
    }
    
    public function set_segundo_premio($value){
        $this->segundo_premio = $value;
    }
    
    public function get_tercer_premio(){
       return $this->tercer_premio; 
    }
    
    public function set_tercer_premio($value){
        $this->tercer_premio = $value;
    }
    
    public function get_descripcion_precio(){
       return $this->descripcion_precio; 
    }
    
    public function set_descripcion_precio($value){
        $this->descripcion_precio = $value;
    }
    
    public function get_fase(){
       return $this->fase; 
    }
    
    public function set_fase($value){
        $this->fase = $value;
    }
    
    public function get_estado(){
       return $this->estado; 
    }
    
    public function set_estado($value){
        $this->estado = $value;
    }
    
    public function get_numero_fases(){
       return $this->numero_fases; 
    }
    
    public function set_numero_fases($value){
        $this->numero_fases = $value;
    }
    
    public function get_reglamento(){
       return $this->reglamento; 
    }
    
    public function set_reglamento($value){
        $this->reglamento = $value;
    }
    
    
}

?>
