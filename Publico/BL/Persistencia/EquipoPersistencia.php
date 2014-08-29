<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Equipo.php";

class EquipoPersistencia{

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
     
     public static function buscar_equipo_por_nombre($nombre, $id_torneo){
        
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM equipo WHERE nombre = '" . $nombre . "' AND id_torneo = " . $id_torneo . ";" ;
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
     
     public static function agregar_equipo_transaction(&$db, $nombre, $id_torneo){
            
            try{
        
                $query = "INSERT INTO equipo VALUES(NULL, '" . $nombre . "', 0, 0, 3, 0, 0, 0, " . $id_torneo . "); ";

                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: EquipoPersistencia - agregar_equipo_transaction");
           
                 }
                 
                 $id = mysqli_insert_id($db);
                
                 return $id;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
    
    
}
?>
