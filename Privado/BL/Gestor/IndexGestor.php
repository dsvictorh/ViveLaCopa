<?php

$pagina = "index";

if(revisar_usuario()){
                  
        header("Location: principal.php");
        exit();   
      
}

function cargar_usuario(){    
    
    if(isset($_POST["txt_usuario"])){
        
        echo $_POST["txt_usuario"];
        
    }else{
        
        echo isset($_COOKIE["ultusr"])?$_COOKIE["ultusr"]:"";
        
    }
       
}

function buscar_usuario($usr, $con){
    
    try{
    
        $usuario = UsuarioPersistencia::buscar_usuario($usr, md5($con)); 

        return $usuario;
    
    }catch(Exception $ex){

        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

    }
    
}

function ingresar(){
    
    if(isset($_POST["btn_ingresar_x"])){
        
        if((isset($_POST["txt_usuario"]))?$_POST["txt_usuario"]:"" != "" && (isset($_POST["txt_contrasenna"]))?$_POST["txt_contrasenna"]:"" != "" ){
                 
            if(!preg_match($GLOBALS["novalidos"], $_POST["txt_usuario"]) && !preg_match($GLOBALS["novalidos"], $_POST["txt_contrasenna"])){
                
                $usuario = buscar_usuario($_POST["txt_usuario"], $_POST["txt_contrasenna"]);

                if ($usuario == NULL){

                    echo "Datos no validos";

                }else{

                    $_SESSION["id"] = $usuario->get_id_usuario();
                    $_SESSION["usuario"] = $usuario->get_usuario();
                    $_SESSION["correo"] = $usuario->get_correo();
                    $_SESSION["tipo"] = $usuario->get_tipo();
                    $_SESSION["torneo"] = $usuario->get_torneo();

                    if(isset($_POST["chk_recordarme"])){

                        setcookie("id", $_SESSION["id"], time()+60*24*30*100, "/privado", "vivelacopa.com");
                        setcookie("usuario", $_SESSION["usuario"], time()+60*24*30*100, "/privado", "vivelacopa.com");
                        setcookie("correo", $_SESSION["correo"], time()+60*24*30*100, "/privado", "vivelacopa.com");
                        setcookie("tipo", $_SESSION["tipo"], time()+60*24*30*100, "/privado", "vivelacopa.com");
                        setcookie("torneo", $_SESSION["torneo"], time()+60*24*30*100, "/privado", "vivelacopa.com");

                    }

                    setcookie("ultusr", $_SESSION["usuario"], time()+60*24*30*100, "/privado", "vivelacopa.com");

                    header("Location: principal.php");
		    exit();

               }
               
           }else{
               
                echo "No se permiten caracteres especiales";
               
           }
           
       }else {
           
           echo "Datos incompletos";
           
       }

    }
    
}


?>
