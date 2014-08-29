<?php

require_once "DA/Coneccion.php";
require_once "BL/Entidad/PartidoEquipo.php";

class PartidoEquipoPersistencia{
    
    public static function agregar_partido_equipo_transaction(&$db, $id_equipo, $id_partido, $goles_favor, $goles_contra){
            
            try{
        
                $query = "INSERT INTO partido_equipo VALUES(" . $id_partido . ", " . $id_equipo . ", " . $goles_favor . ", " . $goles_contra. "); ";

                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                     mysqli_rollback($db);
                    throw new Exception("Error: Se ha producido un error al crear parte de la informaci\\xf3n. Proceso revertido en: PartidoEquipoPersistencia - agregar_partido_equipo_transaction");
           
                }
                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
       public static function modificar_partido_equipo_transaction(&$db, $id_equipo, $id_partido, $goles_favor, $goles_contra){
            
            try{
        
                
                $query = "UPDATE partido_equipo SET goles_favor = " . $goles_favor 
                         . ", goles_contra = " . $goles_contra. " WHERE id_equipo = " . $id_equipo
                         . " AND id_partido = " . $id_partido . "; ";
                
                $statement = mysqli_prepare($db, $query);
                
                 if(!mysqli_stmt_execute($statement)){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: PartidoEquipoPersistencia - modificar_partido_equipo");
           
                }
                

                
            }catch(Exception $ex){             
                
               throw new Exception($ex->getMessage());
                      
            }       
      }
      
       public static function eliminar_partido_equipo($id_partido){
         
          
            try{
        
                $coneccion = Coneccion::conectar();
                
                $query = "DELETE FROM partido_equipo WHERE id_partido = " . $id_partido . ";";
                
                $statement = mysqli_prepare($coneccion, $query);
                
                if(!mysqli_stmt_execute($statement)){
                    
                    throw new Exception("Error: PartidoEquipoPersistencia - eliminar_partido_equipo");
           
                }
                
                
            }catch(Exception $ex){
                             
                throw new Exception($ex->getMessage());
                          
            }                
     }
     
     public static function buscar_partido_equipo($id_partido, $id_equipo){
         
        try{ 
         
            $coneccion = Coneccion::conectar();

            $query = "SELECT * FROM partido_equipo WHERE id_partido = " . $id_partido . " AND id_equipo = "
                    . $id_equipo . ";" ;
            
            $statement = mysqli_query($coneccion, $query);
            
            if(!$statement){
                    
                    throw new Exception("Error: PartidoEquipoPersistencia - buscar_partido_equipo");
           
                }
            
            $partido_equipo = null;

            while ($row = mysqli_fetch_array($statement)) {

                $partido_equipo = new PartidoEquipo();
                $partido_equipo->set_id_partido($row[0]);
                $partido_equipo->set_id_equipo($row[1]);
                $partido_equipo->set_goles_favor($row[2]);
                $partido_equipo->set_goles_contra($row[3]);
                              
            }
        

            return  $partido_equipo;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     public static function existe_partido_transaction(&$db,$id_equipo, $id_partido){
         
        try{ 
         
            $query = "SELECT * FROM partido_equipo WHERE  id_equipo = " . $id_equipo . " AND id_partido = " . $id_partido . ";" ;
            
            $statement = mysqli_query($db, $query);
            
            if(!$statement){
                mysqli_rollback($db);
                    throw new Exception("Error: PartidoEquipoPersistencia - existe_partido_transaction");
           
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
     
     public static function obtener_goles_netos_transaction(&$db, $id_equipo){
         
        try{ 
         
            $query = "SELECT (pe.goles_favor - pe.goles_contra) FROM partido_equipo pe
                      INNER JOIN partido p ON p.id_partido = pe.id_partido
                      WHERE p.fase = 1 AND pe.id_equipo = " . $id_equipo . ";";
            
            $statement = mysqli_query($db, $query);
            
            if(!$statement){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: PartidoEquipoPersistencia - obtener_goles_netos");
           
             }
            
            $goles = 0;

            while ($row = mysqli_fetch_array($statement)) {

                $goles = $row[0]; 
                              
            }
        

            return  $goles;
        
        }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        }       
        
     }
     
     
          public static function obtener_goles_favor_transaction(&$db, $id_equipo){
         
        try{ 

            $query = "SELECT pe.goles_favor FROM partido_equipo pe
                      INNER JOIN partido p ON p.id_partido = pe.id_partido
                      WHERE p.fase = 1 AND pe.id_equipo = " . $id_equipo . ";";
            
            $statement = mysqli_query($db, $query);
            
            if(!$statement){
                    
                    mysqli_rollback($db);
                    throw new Exception("Error: PartidoEquipoPersistencia - obtener_goles_favor");
           
            }
            
            $goles = 0;

            while ($row = mysqli_fetch_array($statement)) {

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
