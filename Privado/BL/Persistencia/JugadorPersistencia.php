<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/Jugador.php";

class JugadorPersistencia{
        
      public static function agregar_jugador($nombre, $apellido, $cedula, $correo, $telefono, $id_equipo, $id_torneo){
            
            try{
                
                $coneccion = Coneccion::conectar();
                
                $query = "INSERT INTO jugador VALUES(NULL, '" . $nombre . "', '" . $apellido . "', '" . $cedula . "', '" . $correo. "', '" . $telefono. "', 0, 0, 0, 0, " . $id_equipo. "); ";

                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){

                    throw new Exception("Error: JugadorPersistencia - agregar_jugador");
           
                }
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
    
       public static function modificar_jugador($id_jugador, $goles, $amarillas, $rojas, $sanciones){
            
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "UPDATE jugador SET goles = " . $goles . ", amarillas = " . $amarillas
                        . ", rojas = " . $rojas . ", sanciones = " . $sanciones . " WHERE id_jugador = " . $id_jugador . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: JugadorPersistencia - modificar_jugador");
           
                }
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
     public static function eliminar_jugador($id_jugador){
         
         try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM jugador WHERE id_jugador = " . $id_jugador . "; ";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: JugadorPersistencia - eliminar_jugador");
           
                }
                
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
         
         
     }
      
     
     public static function buscar_jugador($id_jugador){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM jugador WHERE id_jugador = " . $id_jugador . ";" ;
            $statement = mysqli_query($coneccion, $query);
            
            
            if(!$statement){
                    
                    throw new Exception("Error: JugadorPersistencia - buscar_jugador");
           
                }

            $jugador = null;

            while ($row = mysqli_fetch_array($statement)) {

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
                              
            }

            return  $jugador;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function listar_jugador($id_equipo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM jugador WHERE id_equipo = " . $id_equipo . ";";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: JugadorPersistencia - listar_jugador");
           
                }
        
        $jugadores = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
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
     
     public static function existe_correo($correo, $id_torneo){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM jugador j INNER JOIN equipo e ON e.id_equipo = j.id_equipo WHERE j.correo = '" . $correo . "' AND e.id_torneo = " . $id_torneo . ";";
        $statement = mysqli_query($coneccion, $query);
       
        if(!$statement){
                    
            throw new Exception("Error: JugadorPersistencia - existe_torneo");
           
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
     
   }   
?>
