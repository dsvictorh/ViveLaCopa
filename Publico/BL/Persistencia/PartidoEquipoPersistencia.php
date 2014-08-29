<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/PartidoEquipo.php";

class PartidoEquipoPersistencia{

 public static function obtener_goles_favor($id_equipo){
     
      try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT IFNULL(SUM(pe.goles_favor),0) AS goles "
                . "FROM partido_equipo pe "
                . "INNER JOIN partido p ON p.id_partido = pe.id_partido "
                . "WHERE p.fase = 1 AND pe.id_equipo = " . $id_equipo . ";";

                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: PartidoEquipoPersistencia - obtener_goles_favor");
               }
               
               $goles = 0;
               
               while($row = mysqli_fetch_array($statement)){
                   
                   $goles = $row[0];
                   
               }
               
                return  $goles;
               
               
     }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
     }  
 
  }
  
  
   public static function obtener_goles_contra($id_equipo){
     
      try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "SELECT IFNULL(SUM(pe.goles_contra),0) AS goles "
                . "FROM partido_equipo pe "
                . "INNER JOIN partido p ON p.id_partido = pe.id_partido "
                . "WHERE p.fase = 1 AND pe.id_equipo = " . $id_equipo . ";";

                $statement = mysqli_query($coneccion, $query);
                
               if(!$statement){
                    
                    throw new Exception("Error: PartidoEquipoPersistencia - obtener_goles_contra");
               }
               
               $goles = 0;
               
               while($row = mysqli_fetch_array($statement)){
                   
                   $goles = $row[0];
                   
               }
               
                return  $goles;
               
               
     }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
     }  
 
  }
  
  public static function listar_partido_equipo($id_partido){
       
        try{   
          
        $coneccion = Coneccion::conectar();
        
        $query = "SELECT * FROM partido_equipo WHERE id_partido = " . $id_partido . ";";
        $statement = mysqli_query($coneccion, $query);
        
        if(!$statement){
                    
                    throw new Exception("Error: PartidoEquipoPersistencia - listar_partido_equipo");
           
                }
        
        $partidos_equipos = array();
        
        
        while ($row = mysqli_fetch_array($statement)) {
            
                $partido_equipo = new PartidoEquipo();
                $partido_equipo->set_id_partido($row[0]);
                $partido_equipo->set_id_equipo($row[1]);
                $partido_equipo->set_goles_favor($row[2]);
                $partido_equipo->set_goles_contra($row[3]);
            
                $partidos_equipos[] = $partido_equipo;
                              
        }
        
        return  $partidos_equipos;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
     }
     
  
}

?>
