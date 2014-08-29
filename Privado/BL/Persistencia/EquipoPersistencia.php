<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Equipo.php";

class EquipoPersistencia{
    
      
   public static function agregar_punto_extra($id_equipo){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE equipo SET puntos_extra = (puntos_extra + 1) WHERE id_equipo = " . $id_equipo . "; ";
                
                
                $statement = mysqli_prepare($coneccion, $query);
                
                  if(!mysqli_stmt_execute($statement)){

                    throw new Exception("Error: EquipoPersistencia - agregar_punto_extra");
           
                }

            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }  
      
      public static function remover_punto_extra($id_equipo){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE equipo SET puntos_extra = CASE puntos_extra WHEN 0 THEN puntos_extra ELSE (puntos_extra - 1) END WHERE id_equipo = " . $id_equipo . "; ";
                
                
                $statement = mysqli_prepare($coneccion, $query);
                
                  if(!mysqli_stmt_execute($statement)){

                    throw new Exception("Error: EquipoPersistencia - remover_punto_extra");
           
                }

            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
    
    
      public static function modificar_puntos_transaction(&$db, $id_equipo, $puntos){
            
            try{
        
                
                $query = "UPDATE equipo SET puntos = (puntos + " . $puntos
                         . ") WHERE id_equipo = " . $id_equipo . "; ";
                
                
                $statement = mysqli_prepare($db, $query);
                
                  if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - modificar_puntos_transaction");
           
                }

            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function cambiar_estado($id_equipo, $estado){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE equipo SET estado = '" . $estado . "' WHERE id_equipo = " . $id_equipo . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                  if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: EquipoPersistencia - cambiar_estado");
           
                }

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function cambiar_estado_transaction(&$db, $id_equipo, $estado){
            
            try{
        
                $query = "UPDATE equipo SET estado = '" . $estado . "' WHERE id_equipo = " . $id_equipo . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                  if(!mysqli_stmt_execute($statement)){
                      
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - cambiar_estado");
           
                }

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function marcar_eliminado_transaction(&$db, $id_equipo){
        
        
        try{
        
                 $query = "UPDATE equipo SET eliminado = 1 WHERE id_equipo = " . $id_equipo . ";";
                
                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al modificar parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - marcar_eliminado_transaction");
           
                }
                
             
           }catch(Exception $ex){
               
                    throw new Exception($ex ->getMessage());

            }  
    
    }
    
      
      public static function eliminar_equipo($id_equipo){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM equipo WHERE id_equipo = " . $id_equipo . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                  if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: EquipoPersistencia - eliminar_equipo");
           
                }
                

            }catch(Exception $ex){
                             
                throw new Exception($ex->getMessage());
                          
            }                
       }
     
      public static function buscar_equipo($id_equipo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM equipo WHERE id_equipo = " . $id_equipo . ";" ;
            $statement = mysqli_query($coneccion, $query);
            
             if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - buscar_equipo");
           
                }

            $equipo = null;

            while ($row = mysqli_fetch_array($statement)) {

                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);

                              
            }
        

            return  $equipo;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     
    public static function listar_equipo_aprobado($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " AND estado = 1;";
        $statement = mysqli_query($coneccion, $query);
        
         if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - listar_equipo_aprobado");
           
                }
        
        $equipos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);
            
                $equipos[] = $equipo;
                              
        }
        
        
        return  $equipos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
     public static function listar_equipo_no_aprobado($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " AND estado = 2;";
        $statement = mysqli_query($coneccion, $query);
        
         if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - listar_equipo_no_aprobado");
           
                }
        
        $equipos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);
            
                $equipos[] = $equipo;
                              
        }
        
        
        return  $equipos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
      public static function listar_equipo_pendiente($id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " AND estado = 3;";
        $statement = mysqli_query($coneccion, $query);
        
         if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - listar_equipo_pendiente");
           
                }
        
        $equipos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);
            
                $equipos[] = $equipo;
                              
        }
        
        return  $equipos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }

     public static function listar_equipo_no_asignado($id_torneo){
         
         try{
             
             $coneccion = Coneccion::conectar();
             
             $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo 
                     . " AND estado = 1 AND grupo = 0;";
             
             $statement = mysqli_query($coneccion, $query);
             
              if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - listar_equipo_no_asignado");
           
                }
             
             $equipos = array();
             
             while($row = mysqli_fetch_array($statement)){
                 
                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);
            
                $equipos[] = $equipo;
                 
             }
             
             
              return  $equipos;
             
         }catch(Exception $ex){
             
             throw new Exception($ex->getMessage());
             
         }
         
     }
     
     
     public static function listar_equipo_no_asignado_transaction(&$db, $id_torneo){
         
         try{
             
             $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo 
                     . " AND estado = 1 AND grupo = 0;";
             
             $statement = mysqli_query($db, $query);
             
              if(!$statement){
             
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - listar_equipo_no_asignado_transaction");
           
                }
             
             $equipos = array();
             
             while($row = mysqli_fetch_array($statement)){
                 
                $equipo = new Equipo();
                $equipo->set_id_equipo($row[0]);
                $equipo->set_nombre($row[1]);
                $equipo->set_puntos($row[2]);
                $equipo->set_puntos_extra($row[3]);
                $equipo->set_estado($row[4]);
                $equipo->set_grupo($row[5]);
                $equipo->set_posicion($row[6]);
                $equipo->set_id_torneo($row[7]);
            
                $equipos[] = $equipo;
                 
             }
             
              return  $equipos;
             
         }catch(Exception $ex){

              throw new Exception($ex -> getMessage());

         }
         
     }
     

      public static function asignar_a_grupo($id_equipo, $grupo, $posicion){
        
        
        try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE equipo SET grupo = " . $grupo . ", posicion = " . $posicion . " WHERE id_equipo = " . $id_equipo . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: EquipoPersistencia - asignar_a_grupo");
           
                }
                

            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
    public static function asignar_a_grupo_transaction(&$db, $id_equipo, $grupo, $posicion){
        
        
        try{
        
                 $query = "UPDATE equipo SET grupo = " . $grupo . ", posicion = " . $posicion . " WHERE id_equipo = " . $id_equipo . ";";
                
                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - asignar_a_grupo_transaction");
           
                }
                
             
           }catch(Exception $ex){
               
                    throw new Exception($ex ->getMessage());

            }  
    
    }
    
    
    public static function modificar_posicion_transaction(&$db, $posicion, $nueva_posicion, $grupo, $id_torneo){
        
        
        try{

                
                $query = "UPDATE equipo SET posicion = " . $nueva_posicion 
                        . " WHERE posicion = " . $posicion . " AND grupo = " . $grupo . " AND id_torneo = " . $id_torneo . ";";
                
                $statement = mysqli_prepare($db, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: Equipo Persistencia - modificar_posicion_transaction");
           
                }
 
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
  
    public static function desasignar_de_grupo_transaction(&$db, $id_equipo){
        
        
        try{
                
                $query = "UPDATE equipo SET grupo = 0, posicion = 0 WHERE id_equipo = " . $id_equipo . ";";
                
                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - desasignar_de_grupo_transaction");
           
                }
                

            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
     public static function desasignar_por_torneo_transaction(&$db,$id_torneo){

        try{

            $query = "UPDATE equipo SET grupo = 0, posicion = 0 WHERE id_torneo = " . $id_torneo . ";";

            $statement = mysqli_prepare($db, $query);

            if(!mysqli_stmt_execute($statement)){

                mysqli_rollback($db);
                throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - desasignar_por_torneo_transaction");

            }

        }catch(Exception $ex){

            throw new Exception($ex ->getMessage());
            
        }
        
    }
    
    
    public static function buscar_grupo($id_torneo, $grupo){
        
        
        try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " AND grupo = " . $grupo . " ORDER BY posicion ASC;";
                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - buscar_grupo");
           
                }
                
                $equipos = array();
             
                while($row = mysqli_fetch_array($statement)){

                    $equipo = new Equipo();
                    $equipo->set_id_equipo($row[0]);
                    $equipo->set_nombre($row[1]);
                    $equipo->set_puntos($row[2]);
                    $equipo->set_puntos_extra($row[3]);
                    $equipo->set_estado($row[4]);
                    $equipo->set_grupo($row[5]);
                    $equipo->set_posicion($row[6]);
                    $equipo->set_id_torneo($row[7]);

                    $equipos[] = $equipo;

                }
             
                return  $equipos;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
     public static function listar_grupo_transaction(&$bd, $id_torneo){
        
        
        try{
        
               
                $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " ORDER BY grupo, posicion ASC;";
                $statement = mysqli_query($bd, $query);
                
               if(!$statement){
                    
                   mysqli_rollback($bd);
                   throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - listar_grupo_transaction");
           
                }
                
                $equipos = array();
             
                while($row = mysqli_fetch_array($statement)){

                    $equipo = new Equipo();
                    $equipo->set_id_equipo($row[0]);
                    $equipo->set_nombre($row[1]);
                    $equipo->set_puntos($row[2]);
                    $equipo->set_puntos_extra($row[3]);
                    $equipo->set_estado($row[4]);
                    $equipo->set_grupo($row[5]);
                    $equipo->set_posicion($row[6]);
                    $equipo->set_id_torneo($row[7]);

                    $equipos[] = $equipo;

                }
             
                return  $equipos;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
     public static function buscar_grupo_transaction(&$bd, $id_torneo, $grupo){
        
        
        try{
        
               
                $query = "SELECT * FROM equipo WHERE id_torneo = " . $id_torneo . " AND grupo = " . $grupo . " ORDER BY posicion ASC;";
                $statement = mysqli_query($bd, $query);
                
               if(!$statement){
                    
                   mysqli_rollback($bd);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - buscar_grupo_transaction");
           
                }
                
                $equipos = array();
             
                while($row = mysqli_fetch_array($statement)){

                    $equipo = new Equipo();
                    $equipo->set_id_equipo($row[0]);
                    $equipo->set_nombre($row[1]);
                    $equipo->set_puntos($row[2]);
                    $equipo->set_puntos_extra($row[3]);
                    $equipo->set_estado($row[4]);
                    $equipo->set_grupo($row[5]);
                    $equipo->set_posicion($row[6]);
                    $equipo->set_id_torneo($row[7]);

                    $equipos[] = $equipo;

                }
             
                return  $equipos;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
   
    
    
    public static function obtener_siguiente_posicion($id_torneo, $grupo){
        
        try{
            
            $coneccion = Coneccion::conectar();
            
            $query = "SELECT COUNT(*) AS siguiente_posicion FROM equipo WHERE id_torneo = " . $id_torneo . " 
                     AND grupo = " . $grupo . "; ";
            $statement = mysqli_query($coneccion, $query);
            if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - obtener_siguiente_posicion");
           
                }
            
            $siguiente_posicion = 0;
            
            while($row = mysqli_fetch_array($statement)){
                
                $siguiente_posicion = $row[0] + 1;
                
            }
            
            return $siguiente_posicion;
            
            
        }catch(Exception $ex){             
                
            throw new Exception($ex->getMessage());
                      
        } 
        
    }

   

}

?>
