<?php

class PartidoEquipo{
    
    private $id_partido;
    private $id_equipo;
    private $goles_favor;
    private $goles_contra;
    
    public function get_id_partido(){
       return $this->id_partido; 
    }
    
    public function set_id_partido($value){
        $this->id_partido = $value;
    }
    
    public function get_id_equipo(){
       return $this->id_equipo; 
    }
    
    public function set_id_equipo($value){
        $this->id_equipo = $value;
    }
    
    public function get_goles_favor(){
       return $this->goles_favor; 
    }
    
    public function set_goles_favor($value){
        $this->goles_favor = $value;
    }
    
    public function get_goles_contra(){
       return $this->goles_contra; 
    }
    
    public function set_goles_contra($value){
        $this->goles_contra = $value;
    }
}
?>
