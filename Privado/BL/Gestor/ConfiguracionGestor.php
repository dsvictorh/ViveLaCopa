<?php

require_once 'BL/Persistencia/ConfiguracionPersistencia.php';
require_once 'BL/Persistencia/AdministradorPersistencia.php';


if(!revisar_usuario()){
    
    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();
        
 }
 

$pagina = "configuracion";

function mostrar_reglamento(){
    
    if($_SESSION["tipo"] == 0){
        
        echo "<table id=\"reglamento\">".PHP_EOL;
        echo "   <tr>".PHP_EOL;
        echo "      <td class=\"izquierda\">Reglamento</td>".PHP_EOL;
        echo "   </tr>".PHP_EOL;
                             
        echo "    <tr>".PHP_EOL;
        echo "      <td><textarea id=\"txt_reglamento\" name=\"txt_reglamento\">" . (isset($_POST["txt_reglamento"])?$_POST["txt_reglamento"]:ConfiguracionPersistencia::buscar_reglamento($_SESSION["id"])) . "</textarea></td>".PHP_EOL;
        echo "   </tr>".PHP_EOL;

        echo "    <tr>".PHP_EOL;
        echo "      <td  colspan=\"2\" class=\"derecha error\">".PHP_EOL;
        echo "          <table id=\"boton_error\">".PHP_EOL;
        echo "               <tr>".PHP_EOL;
        echo                         guardar_reglamento();
        echo "                  <td><input type=\"image\" src=\"recursos/img/guardar.png\" title=\"Guardar\" name=\"btn_guardar_reglamento\" /></td>".PHP_EOL;
        echo "              </tr>".PHP_EOL;
        echo "          </table>".PHP_EOL;
        echo "      </td>".PHP_EOL;  
        echo "    </tr>".PHP_EOL;
        echo "</table>".PHP_EOL;
        
        
    }
    
}

function guardar_reglamento(){
    
    if(isset($_POST["btn_guardar_reglamento_x"])){
        
        if($_SESSION["tipo"] == 0){
            
            if(!preg_match($GLOBALS["novalidos"], $_POST["txt_reglamento"])){
                
                ConfiguracionPersistencia::guardar_reglamento($_SESSION["id"], (isset($_POST["txt_reglamento"])?$_POST["txt_reglamento"]:""));
                return "<td class=\"mensaje\">Reglamento guardado</td>";
                
            }else{
                return "<td class=\"error\">No se permiten caracteres especiales</td>";
            }
            
        }
    }
    
    
    
}

function modificar(){
    
    
    if(isset($_POST["btn_guardar_x"])){
        
        if(isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"" != "" && (isset($_POST["txt_correo"]))?$_POST["txt_correo"]:"" != ""){
            
          if(!preg_match($GLOBALS["novalidos"], $_POST["txt_nombre"]) && !preg_match($GLOBALS["novalidos"], $_POST["txt_correo"])){
              
             if(preg_match($GLOBALS["email"], $_POST["txt_correo"])){
                 
                 if((isset($_POST["txt_contrasenna"])?$_POST["txt_contrasenna"]:"") == (isset($_POST["txt_re_contrasenna"])?$_POST["txt_re_contrasenna"]:"")){
              
                    if(preg_match($GLOBALS["contrasenna"], $_POST["txt_contrasenna"]) || $_POST["txt_contrasenna"] == ""){
                        
                        if(strlen($_POST["txt_contrasenna"]) >= 6 || strlen($_POST["txt_contrasenna"]) == 0){
                            
                            try{
                                
                                $contrasenna = (strlen($_POST["txt_contrasenna"])) != 0?md5($_POST["txt_contrasenna"]):"";

                                if(UsuarioPersistencia::validar_usuario_diferente($_SESSION["id"], $_POST["txt_nombre"], $_POST["txt_correo"])){
                                
                                    if($_SESSION["tipo"] == "0"){

                                        ConfiguracionPersistencia::modificar_configuracion($_SESSION["id"], str_replace(" ", "", $_POST["txt_nombre"]), $_POST["txt_correo"], $contrasenna);

                                    }else if($_SESSION["tipo"] == "1"){

                                        AdministradorPersistencia::modificar_administrador($_SESSION["id"], str_replace(" ", "", $_POST["txt_nombre"]), $_POST["txt_correo"], $contrasenna);

                                    }

                                    $_SESSION["usuario"] = str_replace(" ", "", $_POST["txt_nombre"]);
                                    $_SESSION["correo"] = $_POST["txt_correo"];

                                    echo "<td class=\"mensaje\">Cambios guardados</td>";
                                
                                }else{
                                    
                                    echo "<td class=\"error\">Usuario o Correo ya est&aacute; en uso</td>";
        
                                }
                               
                           } catch (Exception $ex){

                              echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
                       }else{ 
                           
                           echo "<td class=\"error\">La contrase&ntilde;a debe tener minimo 6 caracteres</td>";
                           
                       }
                    
                    }else{
                        
                        echo "<td class=\"error\">La contrase&ntilde;a debe ser alfanum&eacute;rica</td>";
                        
                    }

                 }else{

                    echo "<td class=\"error\">Contrase&ntilde;as no coinciden</td>"; 

                 }

             }else{
                 
                 echo "<td class=\"error\">Correo no v&aacute;lido</td>";
                 
             }
                 
              
          }else{
              
              echo "<td class=\"error\">No se permiten caracteres especiales</td>";
              
          }          
       
        }else{
            
            echo "<td class=\"error\">Datos incompletos</td>";
            
        }
        
    }else{
        
        echo "<td></td>";
        
    }
    
}

?>
