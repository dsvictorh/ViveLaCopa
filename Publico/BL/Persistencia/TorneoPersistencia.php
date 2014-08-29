<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Torneo.php";

class TorneoPersistencia{
 
     public static function buscar_torneo($id_torneo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM torneo WHERE id_torneo = " . ((preg_match($GLOBALS["numero"], $id_torneo))?$id_torneo:"0") . ";" ;
            
            
            $statement = mysqli_query($coneccion, $query);

            if(!$statement){
                    
                   throw new Exception("Error al buscar torneo");
           
            }
            
            $torneo = null;
            
            while ($row = mysqli_fetch_array($statement)) {

                $torneo = new Torneo();
                $torneo->set_id_torneo($row[0]);
                $torneo->set_nombre_torneo($row[1]);
                $torneo->set_fecha_inicio($row[2]);
                $torneo->set_fecha_fin($row[3]);
                $torneo->set_detalle($row[4]);
                $torneo->set_precio($row[5]);
                $torneo->set_primer_premio($row[6]);
                $torneo->set_segundo_premio($row[7]);
                $torneo->set_tercer_premio($row[8]);
                $torneo->set_descripcion_precio($row[9]);
                $torneo->set_fase($row[10]);
                $torneo->set_estado($row[11]);
                $torneo->set_numero_fases($row[12]);
                $torneo->set_reglamento($row[13]);
                              
            }


            return  $torneo;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     
      public static function listar_torneo(){
       
        try{   
         
        $fecha_finalizado = date('Y-m-d', strtotime("-2 week"));
        $fecha_cancelado = date('Y-m-d', strtotime("-1 week"));   
           
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM torneo WHERE estado IN (1,2) "
               . "UNION "
               . "SELECT * FROM torneo WHERE estado = 3 AND fecha_fin >= '" . $fecha_finalizado . "' "
               . "UNION "
               . "SELECT * FROM torneo WHERE estado = 4 AND fecha_fin >= '" . $fecha_cancelado . "' "
               . "ORDER BY estado, nombre_torneo ASC";
        
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error al listar los torneos.");
           
                }
        
        $torneos = array();
        
        while ($row = mysqli_fetch_array($statement)) {
            
            $torneo = new Torneo();
            $torneo->set_id_torneo($row[0]);
            $torneo->set_nombre_torneo($row[1]);
            $torneo->set_fecha_inicio($row[2]);
            $torneo->set_fecha_fin($row[3]);
            $torneo->set_detalle($row[4]);
            $torneo->set_precio($row[5]);
            $torneo->set_primer_premio($row[6]);
            $torneo->set_segundo_premio($row[7]);
            $torneo->set_tercer_premio($row[8]);
            $torneo->set_descripcion_precio($row[9]);
            $torneo->set_fase($row[10]);
            $torneo->set_estado($row[11]);
            $torneo->set_numero_fases($row[12]);
            $torneo->set_reglamento($row[13]);

            $torneos[] = $torneo;
                              
        }
        
        return  $torneos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
}
?>
