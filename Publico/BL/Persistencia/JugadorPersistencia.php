<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Jugador.php";

class JugadorPersistencia{

 public static function buscar_goleadores($id_torneo){
        
        
        try{
        
                $coneccion = Coneccion::conectar();
               
                
                $query = "SELECT * FROM jugador j "
                . "INNER JOIN equipo e ON e.id_equipo = j.id_equipo "
                . "WHERE j.goles > 0 AND e.id_torneo = " . $id_torneo . " ORDER BY j.goles DESC;";
                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - buscar_goleadores");
           
                }
                
                $jugadores = array();
             
                while($row = mysqli_fetch_array($statement)){

                    $jugador = new Jugador();
                    $jugador->set_id_jugador($row[0]);
                    $jugador->set_nombre($row[1]);
                    $jugador->set_apellido($row[2]);
                    $jugador->set_cedula($row[3]);
                    $jugador->set_correo($row[4]);
                    $jugador->set_telefono($row[5]);
                    $jugador->set_goles($row[6]);
                    $jugador->set_amarillas($row[7]);
                    $jugador->set_rojas($row[8]);
                    $jugador->set_sanciones($row[9]);
                    $jugador->set_id_equipo($row[10]);

                    $jugadores[] = $jugador;

                }
             
                return  $jugadores;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
    public static function buscar_jugadores_con_sanciones($id_torneo){

        try{
        
                $coneccion = Coneccion::conectar();
               
                
                $query = "SELECT * FROM jugador j "
                . "INNER JOIN equipo e ON e.id_equipo = j.id_equipo "
                . "WHERE (j.rojas > 0 OR j.amarillas > 0 OR j.sanciones > 0) AND e.id_torneo = " . $id_torneo . " ORDER BY j.nombre ASC;";
                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - buscar_jugadores_con_sanciones");
           
                }
                
                $jugadores = array();
             
                while($row = mysqli_fetch_array($statement)){

                    $jugador = new Jugador();
                    $jugador->set_id_jugador($row[0]);
                    $jugador->set_nombre($row[1]);
                    $jugador->set_apellido($row[2]);
                    $jugador->set_cedula($row[3]);
                    $jugador->set_correo($row[4]);
                    $jugador->set_telefono($row[5]);
                    $jugador->set_goles($row[6]);
                    $jugador->set_amarillas($row[7]);
                    $jugador->set_rojas($row[8]);
                    $jugador->set_sanciones($row[9]);
                    $jugador->set_id_equipo($row[10]);

                    $jugadores[] = $jugador;

                }
             
                return  $jugadores;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
    
    }
    
       public static function agregar_jugador_transaction(&$db, $nombre, $apellido, $cedula, $correo, $telefono, $id_equipo){
            
            try{
        
                $query = "INSERT INTO jugador VALUES(NULL, '" . $nombre . "', '" . $apellido . "', '" . $cedula . "', '" . $correo. "', '" . $telefono. "', 0, 0, 0, 0, " . $id_equipo. "); ";

                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: JugadorPersistencia - agregar_jugador_transaction");
           
                }
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
      public static function obtener_cedulas_por_torneo($id_torneo){
          
          try{
          
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT j.cedula FROM jugador j "
                . "INNER JOIN equipo e ON e.id_equipo = j.id_equipo "
                . "WHERE e.id_torneo = " . $id_torneo . ";";
                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - obtener_cedulas_por_torneo");
           
                }
                
                $cedulas = "";
             
                while($row = mysqli_fetch_array($statement)){

                    $cedulas .= str_replace("-", "", $row[0]) . ";";

                }
             
                return  $cedulas;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
          
          
      }
      
      
      public static function obtener_correos_por_torneo($id_torneo){
          
          try{
          
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT j.correo FROM jugador j "
                . "INNER JOIN equipo e ON e.id_equipo = j.id_equipo "
                . "WHERE e.id_torneo = " . $id_torneo . ";";
                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: EquipoPersistencia - obtener_cedulas_por_torneo");
           
                }
                
                $correos = "";
             
                while($row = mysqli_fetch_array($statement)){

                    $correos .= $row[0] . ";";

                }
             
                return  $correos;
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }  
          
          
      }
    
}

?>
