<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Direccion.php";

class DireccionPersistencia{
    
    public static function agregar_direccion($provincia, $canton, $distrito, $direccion, $nombre_cancha, $id_torneo){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "INSERT INTO direccion VALUES(NULL, '" . $provincia . "', '" . $canton. "', '"
                        . $distrito . "', '" . $direccion . "', '" . $nombre_cancha . "', " . $id_torneo . "); ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: DireccionPersistencia - agregar_direccion");
           
                }
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function modificar_direccion($id_direccion, $provincia, $canton, $distrito, $direccion, $nombre_cancha){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE direccion SET provincia = '" . $provincia . "', canton = '" . $canton
                        . "', distrito = '" . $distrito . "',  direccion =  '" . $direccion 
                        . "',  nombre_cancha =  '" . $nombre_cancha . "' WHERE id_direccion = " . $id_direccion . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: DireccionPersistencia - modificar_direccion");
           
                }
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function eliminar_direccion($id_direccion){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM direccion WHERE id_direccion = " . $id_direccion . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                  if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: DireccionPersistencia - eliminar_direccion");
           
                }
                
            }catch(Exception $ex){
                             
                throw new Exception($ex->getMessage());
                          
            }                
     }
     
      public static function buscar_direccion($id_direccion){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM direccion WHERE id_direccion = " . $id_direccion . ";" ;
            $statement = mysqli_query($coneccion, $query);
            
             if(!$statement){
                    
                    throw new Exception("Error: DireccionPersistencia - buscar_direccion");
           
                }

            $direccion = null;

            while ($row = mysqli_fetch_array($statement)) {

                $direccion = new Direccion();
                $direccion->set_id_direccion($row[0]);
                $direccion->set_provincia($row[1]);
                $direccion->set_canton($row[2]);
                $direccion->set_distrito($row[3]);
                $direccion->set_direccion($row[4]);
                $direccion->set_nombre_cancha($row[5]);
                $direccion->set_id_torneo($row[6]);
                              
            }
        

            return  $direccion;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function listar_direccion($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM direccion WHERE id_torneo = " . $id_torneo . ";";
        $statement = mysqli_query($coneccion, $query);
        
         if(!$statement){
                    
             throw new Exception("Error: DireccionPersistencia - listar_direccion");
           
         }
        
        $direcciones = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $direccion = new Direccion();
                $direccion->set_id_direccion($row[0]);
                $direccion->set_provincia($row[1]);
                $direccion->set_canton($row[2]);
                $direccion->set_distrito($row[3]);
                $direccion->set_direccion($row[4]);
                $direccion->set_nombre_cancha($row[5]);
                $direccion->set_id_torneo($row[6]);
            
                $direcciones[] = $direccion;
                              
        }
        
        
        return  $direcciones;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
     
}      
?>
