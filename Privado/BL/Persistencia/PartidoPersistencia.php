<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Partido.php";

class PartidoPersistencia{
    
      public static function agregar_partido_transaction(&$db, $fecha, $hora, $numero_cancha, $detalle, $fase, $tipo, $jugado, $id_torneo){
            
            try{
        
                
                $query = "INSERT INTO partido VALUES(NULL, '" . $fecha . "', '" . $hora . "', "
                        . $numero_cancha . ", '" . $detalle . "', " . $fase . ", " . $tipo . ", " . $jugado . ", " . $id_torneo . "); ";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: PartidoPersistencia - agregar_partido_transaction");
           
                }

          
                
            }catch(Exception $ex){

                    
                   throw new Exception($ex->getMessage());

            }      
      }
      
      public static function modificar_partido_transaction(&$db, $id_partido, $fecha, $hora, $numero_cancha, $detalle){
            
            try{
        
                $query = "UPDATE partido SET fecha = '" . date("Y-m-d", strtotime($fecha)) . "', hora = '" . $hora
                        . "', numero_cancha = " . $numero_cancha . ",  detalle =  '" . $detalle 
                        . "' WHERE id_partido = " . $id_partido . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\\xf3n. Proceso revertido en: PartidoPersistencia - modificar_partido");
           
                }

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function marcar_jugado_transaction(&$db, $id_partido){
            
            try{
        
                $query = "UPDATE partido SET jugado = 1 WHERE id_partido = " . $id_partido . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\\xf3n. Proceso revertido en: PartidoPersistencia - marcar_jugado");
           
                }

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      } 
     
      public static function buscar_partido($id_partido){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM partido WHERE id_partido = " . $id_partido . ";" ;
            $statement = mysqli_query($coneccion, $query);
            
            
            if(!$statement){
                    
                    throw new Exception("Error: PartidoPersistencia - buscar_partido");
           
            }

            $partido = null;

            while ($row = mysqli_fetch_array($statement)) {

                $partido = new Partido();
                $partido->set_id_partido($row[0]);
                $partido->set_fecha($row[1]);
                $partido->set_hora($row[2]);
                $partido->set_numero_cancha($row[3]);
                $partido->set_detalle($row[4]);
                $partido->set_fase($row[5]);
                $partido->set_tipo($row[6]);
                $partido->set_jugado($row[7]);
                $partido->set_id_torneo($row[8]);
                              
            }
        

            return  $partido;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function buscar_partido_tercer_mejor($id_torneo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM partido 
            WHERE id_torneo = " . $id_torneo .  " AND fase = 2 AND tipo = 3;";
            $statement = mysqli_query($coneccion, $query);
            
            
            if(!$statement){
                    
                    throw new Exception("Error: PartidoPersistencia - buscar_partido_tercer_mejor");
           
            }

            $partido = null;

            while ($row = mysqli_fetch_array($statement)) {

                $partido = new Partido();
                $partido->set_id_partido($row[0]);
                $partido->set_fecha($row[1]);
                $partido->set_hora($row[2]);
                $partido->set_numero_cancha($row[3]);
                $partido->set_detalle($row[4]);
                $partido->set_fase($row[5]);
                $partido->set_tipo($row[6]);
                $partido->set_jugado($row[7]);
                $partido->set_id_torneo($row[8]);
                              
            }
        

            return  $partido;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function buscar_partido_final($id_torneo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM partido 
            WHERE id_torneo = " . $id_torneo .  " AND fase = 2 AND tipo = 2;";
            $statement = mysqli_query($coneccion, $query);
            
            
            if(!$statement){
                    
                    throw new Exception("Error: PartidoPersistencia - buscar_partido_final");
           
            }

            $partido = null;

            while ($row = mysqli_fetch_array($statement)) {

                $partido = new Partido();
                $partido->set_id_partido($row[0]);
                $partido->set_fecha($row[1]);
                $partido->set_hora($row[2]);
                $partido->set_numero_cancha($row[3]);
                $partido->set_detalle($row[4]);
                $partido->set_fase($row[5]);
                $partido->set_tipo($row[6]);
                $partido->set_jugado($row[7]);
                $partido->set_id_torneo($row[8]);
                              
            }
        

            return  $partido;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
  
      public static function listar_partido_primera_fase($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM partido  WHERE id_torneo = " . $id_torneo .  " AND fase = 1;";
        
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: PartidoPersistencia - listar_partido_primera_fase");
           
                }
        
        $partidos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $partido = new Partido();
                $partido->set_id_partido($row[0]);
                $partido->set_fecha($row[1]);
                $partido->set_hora($row[2]);
                $partido->set_numero_cancha($row[3]);
                $partido->set_detalle($row[4]);
                $partido->set_fase($row[5]);
                $partido->set_tipo($row[6]);
                $partido->set_jugado($row[7]);
                $partido->set_id_torneo($row[8]);
            
                $partidos[] = $partido;
                              
        }
        
        return  $partidos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
     
     public static function listar_partido_segunda_fase($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM partido 
            WHERE id_torneo = " . $id_torneo .  " AND fase = 2 AND tipo = 1;";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: PartidoPersistencia - listar_partido_segunda_fase");
           
                }
        
        $partidos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $partido = new Partido();
                $partido->set_id_partido($row[0]);
                $partido->set_fecha($row[1]);
                $partido->set_hora($row[2]);
                $partido->set_numero_cancha($row[3]);
                $partido->set_detalle($row[4]);
                $partido->set_fase($row[5]);
                $partido->set_tipo($row[6]);
                $partido->set_jugado($row[7]);
                $partido->set_id_torneo($row[8]);
            
                $partidos[] = $partido;
                              
        }
        
        return  $partidos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
}
?>
