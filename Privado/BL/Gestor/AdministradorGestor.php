<?php

require_once 'BL/Persistencia/AdministradorPersistencia.php';

 if(!revisar_usuario() || $_SESSION["tipo"] != "0"){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();
}


 
 $pagina = "administrador";
//    $recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";
//    $check = isset($_POST["chk_filtro"])?$_POST["chk_filtro"]:"activo";
//    $select = (isset($_REQUEST["cmb_torneo"]))?$_REQUEST["cmb_torneo"]:"";
//    $load = "onLoad=\"cargar_administradores('". $check ."', '" . $select . "')\";";
    
$administrador = new Administrador();

if(($administrador = AdministradorPersistencia::buscar_administrador(isset($_POST["id_administrador"])?$_POST["id_administrador"]:"0")) == NULL){

    header("Location: administradores.php");
    exit();

}

 function validar_datos($id_administrador){
        //1 - Incompleto
        //2 - Caracteres Especiales
        //3 - Correo no valido
        //4 - Contraseña no valida
        //5 - Contraseña no coincide
        //6 - Correo o usuario ya existe
        //7 - Contraseña menos a 6
        $valido = 0;
        $valido = ($valido == 0)?(isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_nombre"]))?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_correo"]))
            ?2:(preg_match($GLOBALS["email"], $_POST["txt_correo"]))?0:3:1:$valido;
        
        $valido = ($valido == 0)?((isset($_POST["txt_contrasenna"])?$_POST["txt_contrasenna"]:"") == (isset($_POST["txt_confirmar_contrasenna"])?$_POST["txt_confirmar_contrasenna"]:""))
            ?(preg_match($GLOBALS["contrasenna"], $_POST["txt_contrasenna"]) || strlen($_POST["txt_contrasenna"]) == 0)
            ?(strlen($_POST["txt_contrasenna"]) >= 6 || strlen($_POST["txt_contrasenna"]) == 0)
            ?0:7:4:5:$valido;
        
        $valido = ($valido == 0)?UsuarioPersistencia::validar_usuario_diferente($id_administrador, $_POST["txt_nombre"], $_POST["txt_correo"])?0:6:$valido;
        
        return $valido;
        
    }
    
    function error($error){
        
        $mensaje = "";
        
        switch ($error){
        
            case 1:
                $mensaje = "Datos Incompletos";
                break;
            
            case 2:
                $mensaje = "No se permiten caracteres especiales";
                break;
            
            case 3:
                $mensaje = "Formato de correo no v&aacute;lido";
                break;
            
            case 4:
                $mensaje = "Formato de contrase&ntilde;a no v&aacute;lido";
                break;  
            
            case 5:
                $mensaje = "Las contrase&ntilde;as no coinciden";
                break;
            
            case 6:
                $mensaje = "Usuario o correo ya est&aacute;n en uso";
                break;
            
            case 7:
                $mensaje = "La contrase&ntilde;a debe contener como minimo 6 caracteres ";
                break;
            
        }
        
        return $mensaje;
        
        
    }
    
    function modificar($id_administrador){
        
        if(isset($_POST["btn_editar_x"])){
            
              if(($modificar = validar_datos($id_administrador)) == 0){
                  
                  try{
                  
                     $contrasenna = (strlen($_POST["txt_contrasenna"])) != 0?md5($_POST["txt_contrasenna"]):"";
  
                     AdministradorPersistencia::modificar_administrador($id_administrador, str_replace(" ", "", $_POST["txt_nombre"]), $_POST["txt_correo"], $contrasenna);
              
                  }catch(Exception $ex){

                     echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

                  }
               }
            }   
        
        return isset($modificar)?$modificar:0;
        
    }


?>
