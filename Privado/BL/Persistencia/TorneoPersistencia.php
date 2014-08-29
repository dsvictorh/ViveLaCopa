<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Torneo.php";

class TorneoPersistencia{

    public static function agregar_torneo($nombre_torneo,$fecha_inicio, $fecha_fin, $detalle, $precio,
            $primer_premio, $segundo_premio, $tercer_premio, $descripcion_precio, $fase, $estado, $numero_fases, $reglamento){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "INSERT INTO torneo VALUES(NULL, '" .$nombre_torneo. "','" . date("Y-m-d", strtotime($fecha_inicio)) . "', '" .  date("Y-m-d", strtotime($fecha_fin)) . "', '"
                        . $detalle . "', " . $precio . ", '" . $primer_premio . "', '" . $segundo_premio . "', '"
                        . $tercer_premio . "', '" . $descripcion_precio . "', " . $fase . ", " . $estado . ", " 
                        . $numero_fases . ", '" . $reglamento . "'); ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!$statement){
                    
                    throw new Exception("Error: TorneoPersistencia - agregar_torneo");
           
                }
                
                mysqli_stmt_execute($statement);
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function agregar_torneo_transaction($db, $nombre_torneo,$fecha_inicio, $fecha_fin, $detalle, $precio,
            $primer_premio, $segundo_premio, $tercer_premio, $descripcion_precio, $fase, $estado, $numero_fases, $reglamento){
            
            try{
                
                $query = "INSERT INTO torneo VALUES(NULL, '" .$nombre_torneo. "','" . date("Y-m-d", strtotime($fecha_inicio)) . "', '" .  date("Y-m-d", strtotime($fecha_fin)) . "', '"
                        . $detalle . "', " . $precio . ", '" . $primer_premio . "', '" . $segundo_premio . "', '"
                        . $tercer_premio . "', '" . $descripcion_precio . "', " . $fase . ", " . $estado . ", " 
                        . $numero_fases . ", '" . $reglamento . "'); ";
                
                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: TorneoPersistencia - agregar_torneo_transaction");
           
                }
                
                $id = mysqli_insert_id($db);
                
                return $id;
                
             }catch(Exception $ex){

                throw new Exception($ex->getMessage());

            }
      }
      
     public static function modificar_torneo($id_torneo,$nombre_torneo, $fecha_inicio, $fecha_fin, $detalle, $precio,
            $primer_premio, $segundo_premio, $tercer_premio, $descripcion_precio, $reglamento){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE torneo SET nombre_torneo = '" .$nombre_torneo. "', fecha_inicio = '" . date("Y-m-d", strtotime($fecha_inicio)) . "', fecha_fin = '" . date("Y-m-d", strtotime($fecha_fin))
                        . "', detalle = '" . $detalle . "',  precio = " . $precio . ", primer_premio = '" . $primer_premio
                        . "', segundo_premio = '" . $segundo_premio . "', tercer_premio = '" . $tercer_premio 
                        . "', descripcion_precio = '" . $descripcion_precio . "', reglamento = '" . $reglamento 
                        . "' WHERE id_torneo = " . $id_torneo . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: TorneoPersistencia - modificar_torneo");
           
                }
                
            }catch(Exception $ex){
                            
                throw new Exception($ex->getMessage());
                            
            }               
     }
     
      public static function eliminar_torneo($id_torneo){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM torneo WHERE id_torneo = " . $id_torneo . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: TorneoPersistencia - eliminar_torneo");
           
                }
                
      
                
                
            }catch(Exception $ex){
                             
                throw new Exception($ex->getMessage());
                          
            }                
     }
     
     
     public static function buscar_torneo($id_torneo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM torneo WHERE id_torneo = " . $id_torneo . ";" ;
            $statement = mysqli_query($coneccion, $query);

            if(!$statement){
                    
                   throw new Exception("Error: TorneoPersistencia - buscar_torneo");
           
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
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM torneo;";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: TorneoPersistencia - listar_torneo");
           
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
     
      public static function listar_torneo_activo($nombre){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM torneo WHERE estado IN (1,2,3) AND nombre_torneo LIKE '%" . $nombre . "%';";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: TorneoPersistencia - listar_torneo_activo");
           
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
     
      public static function listar_torneo_cancelado($nombre){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM torneo WHERE estado IN (4) AND nombre_torneo LIKE '%" . $nombre . "%';";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: TorneoPersistencia - listar_torneo_cancelado");
           
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
     
      public static function cancelar_torneo($id_torneo){
         
        try{ 
            
            $coneccion = Coneccion::conectar();

            $query = "UPDATE torneo SET estado = 4 WHERE id_torneo = " . $id_torneo . ";";
            $statement = mysqli_prepare($coneccion, $query);
            
             if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: TorneoPersistencia - cancelar_torneo");
           
                }

            
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }     
        
      }
      
      public static function activar_torneo($id_torneo){
         
        try{ 
            
            $coneccion = Coneccion::conectar();

            $query = "UPDATE torneo SET estado = 1 WHERE id_torneo = " . $id_torneo . ";";
            $statement = mysqli_prepare($coneccion, $query);
            
             if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: TorneoPersistencia - activar_torneo");
           
                }

            
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }     
        
      }
      
      
      public static function cambiar_estado($id_torneo, $estado){
          
           try{
        
                $coneccion = Coneccion::conectar();
                $query = "UPDATE torneo SET estado = " .$estado. " WHERE id_torneo = " . $id_torneo . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: TorneoPersistencia - cambiar_estado");
           
                }
                
            }catch(Exception $ex){
                            
                throw new Exception($ex->getMessage());
                            
            }               
          
      }
      
      public static function cambiar_estado_transaction(&$bd, $id_torneo, $estado){
          
           try{
        
                $query = "UPDATE torneo SET estado = " .$estado. " WHERE id_torneo = " . $id_torneo . "; ";
                
                $statement = mysqli_prepare($bd, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($bd);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\xF3n necesaria. Proceso revertido en: TorneoPersistencia - cambiar_estado_transaction");
           
                }
                
            }catch(Exception $ex){
                            
                throw new Exception($ex->getMessage());
                            
            }               
          
      }
      
       public static function cambiar_fase_transaction(&$bd, $id_torneo){
          
           try{
        
                $query = "UPDATE torneo SET fase = 2 WHERE id_torneo = " . $id_torneo . "; ";
                
                $statement = mysqli_prepare($bd, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($bd);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\xF3n necesaria. Proceso revertido en: TorneoPersistencia - cambiar_fase_transaction");
           
                }
                
            }catch(Exception $ex){
                            
                throw new Exception($ex->getMessage());
                            
            }               
          
      }
}
?>

