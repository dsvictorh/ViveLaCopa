<?php

require_once "config.php";

class Coneccion{
   

    public static function conectar(){

        try{
        
        $coneccion = mysqli_connect($GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["contrasena"], $GLOBALS["db"]);
        
        
        if(!$coneccion)
            throw new Exception("No se pudo encontrar la base de datos");           
        else
            return $coneccion;
        
        }catch(Exception $ex){
            
            throw new Exception($ex->getMessage());
            
        }
        
    }

    public static function desconectar(&$coneccion){

        mysqli_close($coneccion);
    }


}
?>
