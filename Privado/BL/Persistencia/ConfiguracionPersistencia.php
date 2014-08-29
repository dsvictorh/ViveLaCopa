<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Usuario.php";

class ConfiguracionPersistencia{
    
     public static function modificar_configuracion($id_configuracion, $administrador, $correo, $contrasenna){
            
            try{
        
                $coneccion = Coneccion::conectar();
                mysqli_autocommit($coneccion, false);
                
                $query = "UPDATE configuracion SET administrador = '" . $administrador 
                         . "', correo = '" . $correo . "' WHERE id_configuracion = " . $id_configuracion . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!$statement){
                    
                    mysqli_rollback($coneccion);
                    throw new Exception("Error: ConfiguracionPersistencia - modificar_configuracion");
           
                }
                
                mysqli_stmt_execute($statement);
                
                if($contrasenna != "")
                    ConfiguracionPersistencia::cambiar_contrasenna($coneccion, $id_configuracion, $contrasenna);
                
                 mysqli_commit($coneccion);
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }        
      
      
     public static function cambiar_contrasenna($db, $id_configuracion, $contrasenna){
         
         try{
                
                $query = "UPDATE configuracion SET contrasenna = '" . $contrasenna 
                         . "' WHERE id_configuracion = " . $id_configuracion . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!$statement){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: ConfiguracionPersistencia - cambiar_contrasenna");
           
                }
                
                mysqli_stmt_execute($statement);
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }   
         
         
     }
     
     public static function guardar_reglamento($id_configuracion, $reglamento){
         
         try{ 
                
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE configuracion SET reglamento = '" . $reglamento 
                         . "' WHERE id_configuracion = " . $id_configuracion . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!$statement){
                    
                   throw new Exception("Error: ConfiguracionPersistencia - guardar_reglamento");
           
                }
                
                mysqli_stmt_execute($statement);
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }   
         
         
     }
     
     public static function buscar_reglamento($id_configuracion){
         
         try{ 
                
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT reglamento FROM configuracion WHERE id_configuracion = " . $id_configuracion . "; ";
                $statement = mysqli_query($coneccion, $query);
                
                if(!$statement){
                    
                   throw new Exception("Error: ConfiguracionPersistencia - buscar_reglamento");
           
                }
                
                $reglamento = "";
                
                while ($row = mysqli_fetch_array($statement)) {
                    
                    $reglamento = $row[0];
                    
                }
                
                return $reglamento;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }   
         
         
     }
     
      public static function buscar_reglamento_sin_id(){
         
         try{ 
                
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT reglamento FROM configuracion;";
                $statement = mysqli_query($coneccion, $query);
                
                if(!$statement){
                    
                   throw new Exception("Error: ConfiguracionPersistencia - buscar_reglamento_sin_id");
           
                }
                
                $reglamento = "";
                
                while ($row = mysqli_fetch_array($statement)) {
                    
                    $reglamento = $row[0];
                    
                }
                
                return $reglamento;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }   
         
         
     }
} 
 
?>
