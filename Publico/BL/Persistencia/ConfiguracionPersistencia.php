<?php

require_once "DA/Coneccion.php";

class ConfiguracionPersistencia{
    
    public static function obtener_correo(){
        
         try{   
          
            $coneccion = Coneccion::conectar();
            
            $query = "SELECT correo FROM configuracion LIMIT 0, 1;";
            
            $statement = mysqli_query($coneccion, $query);
        
            if(!$statement){
                    
                throw new Exception("Error al obtener el correo destinatario.");
           
            }
            
            $correo = "";
            
             while ($row = mysqli_fetch_array($statement)) {
            
                 $correo = $row[0];
                              
            }

            return $correo;
            
         }catch(Exception $ex){
                           
           throw new Exception($ex->getMessage());
                            
        } 
        
    }
    
}

?>
