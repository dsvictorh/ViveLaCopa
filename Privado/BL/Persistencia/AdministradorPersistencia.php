<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Administrador.php";

class AdministradorPersistencia{
    
    public static function agregar_administrador($nombre, $contrasenna, $correo, $id_torneo){
            
        try{
                $coneccion = Coneccion::conectar();
                
                $query = "INSERT INTO administrador VALUES(NULL, '" . $nombre . "', '" . $contrasenna. "', '"
                        . $correo . "', 1, " . $id_torneo . "); ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!mysqli_stmt_execute($statement))
                    throw new Exception("Error: AdministradorPersistencia - agregar_administrador");
                


        }catch(Exception $ex){
            
            throw new Exception($ex->getMessage());
        }
    }
      
     public static function modificar_administrador($id_administrador, $nombre, $correo, $contrasenna){

         try{
         
                $coneccion = Coneccion::conectar();
                mysqli_autocommit($coneccion, false);
                
                $query = "UPDATE administrador SET nombre = '" . $nombre . "', correo = '" 
                         . $correo . "' WHERE id_administrador = " . $id_administrador . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($coneccion);
                    throw new Exception("Error: AdministradorPersistencia - modificar_administrador");
           
                }
                
                mysqli_stmt_execute($statement);
                
                if($contrasenna != "")
                AdministradorPersistencia::cambiar_contrasenna($coneccion, $id_administrador, $contrasenna);
                
                mysqli_commit($coneccion);
                
          }catch(Exception $ex){
            
            throw new Exception($ex->getMessage());
            
          }
   
      }
      
       
     public static function cambiar_contrasenna(&$db, $id_administrador, $contrasenna){
         
         try{

                
                $query = "UPDATE administrador SET contrasenna = '" . $contrasenna 
                         . "' WHERE id_administrador = " . $id_administrador . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: AdministradorPersistencia - cambiar_contrasenna");
           
                }

                
                
         }catch(Exception $ex){
            
            throw new Exception($ex->getMessage());
        }
     }
      
      public static function desactivar_administrador($id_administrador){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE administrador SET activo = 0 WHERE id_administrador = " . $id_administrador . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: AdministradorPersistencia - desactivar_administrador");
           
                }

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function activar_administrador($id_administrador){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE administrador SET activo = 1 WHERE id_administrador = " . $id_administrador . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: AdministradorPersistencia - activar_administrador");
           
                }
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }

      
       public static function eliminar_administrador($id_administrador){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM administrador WHERE id_administrador = " . $id_administrador . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: AdministradorPersistencia - eliminar_administrador");
           
                }
                               
                
            }catch(Exception $ex){
                             
                throw new Exception($ex->getMessage());
                          
            }                
     }
     
     public static function buscar_administrador($id_administrador){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM administrador WHERE id_administrador = " . $id_administrador . ";" ;
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: AdministradorPersistencia - buscar_administrador");
           
                }
            

            $administrador = null;

            while ($row = mysqli_fetch_array($statement)) {

                $administrador = new Administrador();
                $administrador->set_id_administrador($row[0]);
                $administrador->set_nombre($row[1]);;
                $administrador->set_correo($row[3]);
                $administrador->set_id_torneo($row[5]);            
            }
        

            return  $administrador;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function listar_administrador_activo($id_torneo){
       
        try{   
          
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM administrador WHERE activo = 1" . ($id_torneo != 0?" AND id_torneo = " . $id_torneo:"") . ";";
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: AdministradorPersistencia - listar_administrador_activo");
           
                }
            
            
            $administradores = array();


            while ($row = mysqli_fetch_array($statement)) {

                    $administrador = new Administrador();
                    $administrador->set_id_administrador($row[0]);
                    $administrador->set_nombre($row[1]);
                    $administrador->set_correo($row[3]);
                    $administrador->set_id_torneo($row[5]);

                    $administradores[] = $administrador;

            }
        
        
           return  $administradores;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
     
      public static function listar_administrador_inactivo($id_torneo){
       
        try{   
          
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM administrador WHERE activo = 0" . ($id_torneo != 0?" AND id_torneo = " . $id_torneo:"") . ";";
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                   throw new Exception("Error: AdministradorPersistencia - listar_administrador_inactivo");
           
                }
            
            $administradores = array();


            while ($row = mysqli_fetch_array($statement)) {

                    $administrador = new Administrador();
                    $administrador->set_id_administrador($row[0]);
                    $administrador->set_nombre($row[1]);
                    $administrador->set_correo($row[3]);
                    $administrador->set_id_torneo($row[5]);

                    $administradores[] = $administrador;

            }

        
           return  $administradores;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
   }   
?>
