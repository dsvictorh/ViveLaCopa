<?php

require_once "BL/Persistencia/ConfiguracionPersistencia.php";

$pagina = "contactenos";
$titulo = "Contactenos";

$url = "";
$reglamento = false;

function validar_datos(){
    //1 - Incompleto
    //2 - Correo no valido
    $valido = 0;
    
    $valido = ($valido == 0)?((isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") != "")?0:1:$valido;
    
    $valido = ($valido == 0)?((isset($_POST["txt_apellido"])?$_POST["txt_apellido"]:"") != "")?0:1:$valido;
    
    $valido = ($valido == 0)?((isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") != "")?  preg_match($GLOBALS["email"], $_POST["txt_correo"])?0:2:1:$valido;
    
    $valido = ($valido == 0)?((isset($_POST["txt_telefono"])?$_POST["txt_telefono"]:"") != "")?0:1:$valido;
    
    $valido = ($valido == 0)?((isset($_POST["txt_asunto"])?$_POST["txt_asunto"]:"") != "")?0:1:$valido;
    
    $valido = ($valido == 0)?((isset($_POST["txt_descripcion"])?$_POST["txt_descripcion"]:"") != "")?0:1:$valido;
    
    return $valido;
    
}

function mensaje($error){
        
        
        switch ($error){
        
            case 0:               
                echo "<td colspan=\"2\" class=\"mensaje\">Mensaje enviado</td>".PHP_EOL;
                break; 
            
            case 1:
                echo "<td colspan=\"2\" class=\"error\">Datos Incompletos</td>".PHP_EOL;
                break;
            
            case 2:
                echo "<td colspan=\"2\" class=\"error\">Formato de correo no v&aacute;lido</td>".PHP_EOL;
                break;
           
            default:
                echo "<td colspan=\"2\"></td>".PHP_EOL;
                break;
                
            
        }
        
        
}

 function enviar(){
     
     if(isset($_POST["btn_enviar_x"])){
         
          if(($error = (validar_datos())) == 0){
              
            try{

                $destinatario = ConfiguracionPersistencia::obtener_correo();
                $asunto = "Vive la Copa: " . $_POST["txt_asunto"];       
                $cuerpo = "<h4 style=\"display:inline;\">Nombre: </h4>" . $_POST["txt_nombre"] . " " . $_POST["txt_apellido"].PHP_EOL;
                $cuerpo .= "<br />".PHP_EOL; 
                $cuerpo .= "<h4 style=\"display:inline;\">Tel&eacute;fono: </h4>" . $_POST["txt_telefono"].PHP_EOL;
                $cuerpo .= "<br />".PHP_EOL; 
                $cuerpo .= "<br />".PHP_EOL;
                $cuerpo .= "<p> " . $_POST["txt_descripcion"] . " </p>".PHP_EOL;
                $encabezados  = 'MIME-Version: 1.0' . "\r\n";
                $encabezados .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
                $encabezados .= "From: " . $_POST["txt_nombre"] . " " . $_POST["txt_apellido"] . " <" . $_REQUEST["txt_correo"] . ">";
                $adicional = "-f " . $_REQUEST["txt_correo"];


                mail($destinatario, $asunto, $cuerpo, $encabezados, $adicional);

            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
              
          }
          
     }
     
     return isset($error)?$error:-1;
     
 }
?>
