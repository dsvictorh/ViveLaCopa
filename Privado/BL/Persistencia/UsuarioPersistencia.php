<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Usuario.php";

class UsuarioPersistencia{
     
    public static function buscar_usuario($nombre, $contrasenna){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT t.id, t.nombre, t.correo, t.tipo, t.torneo FROM "
                   . "(SELECT id_configuracion as id, administrador as nombre,"
                   . "contrasenna as contrasenna, correo as correo, '0' as torneo," 
                   . "'0' as tipo FROM configuracion " 
                   . "UNION "
                   . "SELECT id_administrador as id, nombre as nombre,"
                   . "contrasenna as contrasenna, correo as correo, id_torneo as torneo," 
                   . "'1' as tipo FROM administrador WHERE activo = 1)t " 
                   . "WHERE t.nombre = '" . $nombre . "' " 
                   . "AND t.contrasenna = '" . $contrasenna . "';";
            
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                   throw new Exception("Error: UsuarioPersistencia - buscar_usuario");
           
                }

            $usuario = null;

            while ($row = mysqli_fetch_array($statement)) {

                $usuario = new Usuario();
                $usuario->set_id_usuario($row[0]);
                $usuario->set_usuario($row[1]);
                $usuario->set_correo($row[2]);
                $usuario->set_tipo($row[3]);
                $usuario->set_torneo($row[4]);
                
          
            }
        

            return  $usuario;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
           
    
   
     public static function existe_usuario($id_administrador, $nombre, $correo, $id_torneo){
         
         try{   
          
            $coneccion = Coneccion::conectar();
            
            $query = "SELECT t.id, t.nombre, t.correo, t.tipo, t.torneo FROM "
                   . "(SELECT id_configuracion as id, administrador as nombre,"
                   . "contrasenna as contrasenna, correo as correo, '0' as torneo," 
                   . "'0' as tipo FROM configuracion "
                   . "UNION "
                   . "SELECT id_administrador as id, nombre as nombre,"
                   . "contrasenna as contrasenna, correo as correo, id_torneo as torneo," 
                   . "'1' as tipo FROM administrador WHERE activo = 1)t " 
                   . "WHERE t.id = " . $id_administrador . " " 
                   . "AND t.nombre = '" . $nombre . "' "
                   . "AND t.correo = '" . $correo . "' "
                   . "AND t.torneo = " . $id_torneo . ";";
            
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: UsuarioPersistencia - existe_usuario");
           
                }
            
            $existe = false;
            
            while ($row = mysqli_fetch_array($statement)) {

                    $existe = true;

            }
        

        
            return  $existe;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
         
     }
     
     public static function validar_usuario($nombre, $correo){
         
         try{   
          
            $coneccion = Coneccion::conectar();

            $query = "SELECT t.nombre, t.correo FROM "
                   . "(SELECT administrador as nombre, "
                   . "correo as correo " 
                   . "FROM configuracion "
                   . "UNION "
                   . "SELECT nombre as nombre, "
                   . "correo as correo " 
                   . "FROM administrador)t " 
                   . "WHERE t.nombre = '" . $nombre . "' " 
                   . "OR t.correo = '" . $correo . "'; ";

            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: UsuarioPersistencia - validar_usuario");
           
                }
            
            $valido = true;
            
            while ($row = mysqli_fetch_array($statement)) {

                    $valido = false;

            }
        
        
            return  $valido;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
         
     }
     
     
     public static function validar_usuario_diferente($id, $nombre, $correo){
         
         try{   
          
            $coneccion = Coneccion::conectar();

            $query = "SELECT t.nombre, t.correo, t.id FROM "
                   . "(SELECT administrador as nombre, "
                   . "correo as correo, " 
                   . "id_configuracion as id "  
                   . "FROM configuracion "
                   . "UNION "
                   . "SELECT nombre as nombre, "
                   . "correo as correo, " 
                   . "id_administrador as id " 
                   . "FROM administrador)t " 
                   . "WHERE (t.nombre = '" . $nombre . "' " 
                   . "OR t.correo = '" . $correo . "')"
                   . "AND t.id != " . $id . "; ";

            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: UsuarioPersistencia - validar_usuario");
           
                }
            
            $valido = true;
            
            while ($row = mysqli_fetch_array($statement)) {

                    $valido = false;

            }
        
        
            return  $valido;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
         
     }
     
   }   
?>
