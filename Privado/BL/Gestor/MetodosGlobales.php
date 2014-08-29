<?php

require_once "BL/Persistencia/UsuarioPersistencia.php";
ob_start();
function revisar_sesion(){
    
    $activa = true;
    $activa = $activa && isset($_SESSION["id"]);
    $activa = $activa && isset($_SESSION["usuario"]);
    $activa = $activa && isset($_SESSION["correo"]);
    $activa = $activa && isset($_SESSION["tipo"]);
    $activa = $activa && isset($_SESSION["torneo"]);
    
    return $activa;
    
}

function revisar_usuario(){

    $permitido = false;
    
    if(!revisar_sesion()){
          
        if(isset($_COOKIE["id"]) && isset($_COOKIE["usuario"]) 
                && isset($_COOKIE["correo"]) && isset($_COOKIE["tipo"])
                && isset($_COOKIE["torneo"])){

            try{
                if(UsuarioPersistencia::existe_usuario($_COOKIE["id"],
                        $_COOKIE["usuario"], $_COOKIE["correo"], $_COOKIE["torneo"])){

                    $_SESSION["id"] = $_COOKIE["id"];
                    $_SESSION["usuario"] = $_COOKIE["usuario"];
                    $_SESSION["correo"] = $_COOKIE["correo"];
                    $_SESSION["tipo"] = $_COOKIE["tipo"];
                    $_SESSION["torneo"] = $_COOKIE["torneo"];

                    $permitido = true;

                }
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }


        }
    
    }else{
              
            $permitido = true;
        
    }

    return $permitido;
}

function logout(){

    if(isset($_SESSION["usuario"])){

        if(isset($_REQUEST["logout"])){

            if($_REQUEST["logout"] == md5($_SESSION["usuario"])){

                setcookie("id", $_SESSION["id"], time()-60*24*30*100, "/privado", "vivelacopa.com");
                setcookie("usuario", $_SESSION["usuario"], time()-60*24*30*100, "/privado", "vivelacopa.com");
                setcookie("correo", $_SESSION["correo"], time()-60*24*30*100, "/privado", "vivelacopa.com");
                setcookie("tipo", $_SESSION["tipo"], time()-60*24*30*100, "/privado", "vivelacopa.com");
                setcookie("torneo", $_SESSION["torneo"], time()-60*24*30*100, "/privado", "vivelacopa.com");
                session_destroy();
                header("Location: index.php");
                exit();

            }  

        }
        
    }
}

session_start();
logout();
                
?>

<!DOCTYPE html>
<html>
  
   <head>
         
       <?php setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); ?>
       <title>Vive la Copa</title> 
       <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
       <link rel="shortcut icon" href="recursos/img/logo.ico" />
       <link rel="stylesheet" href="recursos/css/estilos.css" />
       