<?php

require_once 'BL/Persistencia/EquipoPersistencia.php';
require_once 'BL/Persistencia/JugadorPersistencia.php';
require_once 'BL/Persistencia/TorneoPersistencia.php';

if(!revisar_usuario()){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();

}


$equipo = new Equipo();

if(($equipo = EquipoPersistencia::buscar_equipo(isset($_POST["id_equipo"])?$_POST["id_equipo"]:"0")) == NULL){

    header("Location: torneos.php");
    exit();

}

if(($torneo = TorneoPersistencia::buscar_torneo($_SESSION["tipo"] ==  0?isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0":$_SESSION["torneo"])) == NULL){

    header("Location: torneos.php");
    exit();

}

$pagina = "equipo";
$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>".PHP_EOL;

function validar_datos($editar){

    //1 - Incompleto
    //2 - No es numero
    //3 - No se permiten caracteres especiales
    //4 - Nombre y Apellido > 50
    //5 - Correo no valido
    //6 - Telefono no valido
    //7 - Telefono > 50
    //8 - Correo > 100
    $valido = 0;

    if($editar){
    
        $valido = ($valido == 0)?(isset($_POST["txt_amarillas"])?$_POST["txt_amarillas"]:"") != ""
            ?(!preg_match($GLOBALS["numero"], $_POST["txt_amarillas"]))
            ?2:0:1:$valido;

        $valido = ($valido == 0)?(isset($_POST["txt_rojas"])?$_POST["txt_rojas"]:"") != ""
            ?(!preg_match($GLOBALS["numero"], $_POST["txt_rojas"]))
            ?2:0:1:$valido;

        $valido = ($valido == 0)?(isset($_POST["txt_sanciones"])?$_POST["txt_sanciones"]:"") != ""
            ?(!preg_match($GLOBALS["numero"], $_POST["txt_sanciones"]))
            ?2:0:1:$valido;

        $valido = ($valido == 0)?(isset($_POST["txt_goles"])?$_POST["txt_goles"]:"") != ""
            ?(!preg_match($GLOBALS["numero"], $_POST["txt_goles"]))
            ?2:0:1:$valido;
        
    }else{
    
    $valido = ($valido == 0)?(isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") != ""
        ?(!preg_match($GLOBALS["novalidos"], $_POST["txt_nombre"]))
        ?(strlen($_POST["txt_nombre"]) > 50)
        ?4:0:3:1:$valido;
    
    $valido = ($valido == 0)?(isset($_POST["txt_apellido"])?$_POST["txt_apellido"]:"") != ""
        ?(!preg_match($GLOBALS["novalidos"], $_POST["txt_apellido"]))
        ?(strlen($_POST["txt_apellido"]) > 50)
        ?4:0:3:1:$valido;
    
    $valido = ($valido == 0)?(isset($_POST["txt_telefono"])?$_POST["txt_telefono"]:"") != ""
        ?(preg_match($GLOBALS["telefono"], $_POST["txt_telefono"]))
        ?(strlen($_POST["txt_telefono"]) > 50)
        ?7:0:6:1:$valido;
    
    $valido = ($valido == 0)?(isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") != ""
        ?(preg_match($GLOBALS["email"], $_POST["txt_correo"]))
        ?(strlen($_POST["txt_correo"]) > 100)
        ?8:0:5:1:$valido;
    
    
    }

    return $valido;

}


function error($error){

    $mensaje = "";

    switch ($error){

        case 1:
            $mensaje = "Datos Incompletos";
            break;

        case 2:
            $mensaje = "Goles, Amarilla, Rojas o Sanciones no son n&uacute;mero";
            break;
        
        case 3:
            $mensaje = "No se permiten caracteres especiales";
            break;
        
        case 4:
            $mensaje = "Nombre y Apellido no pueden exceder los 50 caracteres";
            break;
        
        case 5:
            $mensaje = "Correo no v&aacute;lido";
            break;
        
        case 6:
            $mensaje = "Tel&eacute;fono no v&aacute;lido";
            break;

    }

    return $mensaje;


}

function listar_jugadores($equipo , $estado, $torneo){
    
     try{
        $jugador = new Jugador();
        $jugadores = array();
        $jugadores = JugadorPersistencia::listar_jugador($equipo);       
        
            for($i = 0; $i < count($jugadores); $i++){

                $jugador = $jugadores[$i];

                $ultimo_izq = $i == (count($jugadores)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
                $ultimo_der = $i == (count($jugadores)-1)?!($i % 2 == 0)?"class=\"ultimo_der\"":"":"";

                echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
                echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $jugador->get_nombre() . " " . $jugador->get_apellido() . "</td>".PHP_EOL;
                echo "  <td>" . $jugador->get_cedula() . "</td>".PHP_EOL;
                echo "  <td>" . $jugador->get_correo() . "</td>".PHP_EOL;

                if ($torneo->get_estado() == 2 && $estado == 1){

                    echo "  <td>" . $jugador->get_telefono() . "</td>".PHP_EOL;
                    echo "  <td " . $ultimo_der . ">".PHP_EOL;
                    echo "      <form name=\"editar_jugador\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\" >".PHP_EOL;
                    echo "          <input type=\"image\" name=\"btn_editar\" src=\"recursos/img/editar.png\" title=\"Editar\" alt=\"Editar\" />".PHP_EOL;
                    echo "          <input type=\"hidden\" name=\"id_jugador\" value=\"" . $jugador->get_id_jugador() . "\" />".PHP_EOL;
                    echo "          <input type=\"hidden\" value=\"" . $equipo . "\" name=\"id_equipo\" />".PHP_EOL;
                    echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo->get_id_torneo() . "\" />".PHP_EOL;
                    echo "      </form>".PHP_EOL;
                    echo "  </td>".PHP_EOL;

                }else{
                    
                   echo "  <td  " . $ultimo_der . ">" . $jugador->get_telefono() . "</td>".PHP_EOL; 
                    
                }
                
                echo "</tr>".PHP_EOL;
            }
        
     }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
} 

function editar_jugador($modificar, $id_equipo){
    
    if((isset($_POST["btn_editar_x"]) || $modificar != 0) && ($jugador = JugadorPersistencia::buscar_jugador(isset($_POST["id_jugador"])?$_POST["id_jugador"]:"0")) != null){
    
        echo "<div id=\"editar_jugador\">".PHP_EOL;
        echo "  <div>".PHP_EOL;

        echo "    <form autocomplete=\"off\" name=\"frm_editar_jugador\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;

        echo "        <table class=\"izquierda\">".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td colspan=\"3\">C&eacute;dula: " . $jugador->get_cedula() . "</td>".PHP_EOL;
        echo "            <td colspan=\"3\">Nombre: " . $jugador->get_nombre() . " " . $jugador->get_apellido() . "</td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td colspan=\"6\"></td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "                Amarillas".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"text\" maxlength=\"2\" name=\"txt_amarillas\" value=\"" . $jugador->get_amarillas() . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "                Rojas".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"text\" maxlength=\"2\" name=\"txt_rojas\" value=\"" . $jugador->get_rojas() . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "                Goles".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"text\" maxlength=\"2\" name=\"txt_goles\" value=\"" . $jugador->get_goles() . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "                Sanciones".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"text\" maxlength=\"2\" name=\"txt_sanciones\" value=\"" . $jugador->get_sanciones() . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"image\" name=\"btn_guardar\" src=\"recursos/img/guardar.png\" alt=\"Guardar\" title=\"Guardar\" />".PHP_EOL;
        echo "                <input type=\"image\" name=\"btn_eliminar\" src=\"recursos/img/eliminar.png\" alt=\"Eliminar\" title=\"Eliminar\" onclick=\"return confirmar('Est\xE1 seguro que desea eliminar este jugador?');\" />".PHP_EOL;
        echo "                <input type=\"image\" name=\"btn_cancelar\" src=\"recursos/img/cancelar.png\" alt=\"Cancelar\" title=\"Cancelar\" />".PHP_EOL;
        echo "                <input type=\"hidden\" name=\"id_jugador\" value=\"" . $jugador->get_id_jugador() . "\" />".PHP_EOL;
        echo "                <input type=\"hidden\" value=\"" . $id_equipo . "\" name=\"id_equipo\" />".PHP_EOL;
        echo "                <input type=\"hidden\" name=\"id_torneo\" value=\"" . (isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "              <td  colspan=\"6\" class=\"error\">" . error($modificar) . "</td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "        </table>".PHP_EOL;

        echo "      </form>".PHP_EOL;
        echo "  </div>".PHP_EOL;
            
        echo "</div>".PHP_EOL;
                    
    }
    
}

function nuevo_jugador($agregar, $id_equipo){
    
    if(isset($_POST["btn_nuevo_x"]) || $agregar != 0){
    
        echo "<div id=\"agregar_jugador\">".PHP_EOL;
        echo "  <div>".PHP_EOL;

        echo "    <form autocomplete=\"off\" name=\"frm_agregar_jugador\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;

        echo "        <table class=\"izquierda\">".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "             Nombre: <input type=\"text\" maxlength=\"50\" name=\"txt_nombre\" value=\"" . (isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "             Apellido: <input type=\"text\" maxlength=\"50\" name=\"txt_apellido\" value=\"" . (isset($_POST["txt_apellido"])?$_POST["txt_apellido"]:"") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td colspan=\"2\"></td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "              Tel&eacute;fono: <input type=\"text\" maxlength=\"50\" name=\"txt_telefono\" value=\"" . (isset($_POST["txt_telefono"])?$_POST["txt_telefono"]:"") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "            <td>".PHP_EOL;
        echo "              Correo:<input type=\"text\" maxlength=\"50\" name=\"txt_correo\" value=\"" . (isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;
        
        echo "          <tr>".PHP_EOL;
        echo "            <td colspan=\"2\" class=\"derecha\">".PHP_EOL;
        echo "                <br />".PHP_EOL;
        echo "                <input type=\"image\" name=\"btn_agregar\" src=\"recursos/img/guardar.png\" alt=\"Guardar\" title=\"Guardar\" />".PHP_EOL;
        echo "                <input type=\"image\" name=\"btn_cancelar\" src=\"recursos/img/cancelar.png\" alt=\"Cancelar\" title=\"Cancelar\" />".PHP_EOL;
        echo "                <input type=\"hidden\" value=\"" . $id_equipo . "\" name=\"id_equipo\" />".PHP_EOL;
        echo "                <input type=\"hidden\" name=\"id_torneo\" value=\"" . (isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0") . "\" />".PHP_EOL;
        echo "            </td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "          <tr>".PHP_EOL;
        echo "              <td colspan=\"2\" class=\"error\">" . error($agregar) . "</td>".PHP_EOL;
        echo "          </tr>".PHP_EOL;

        echo "        </table>".PHP_EOL;

        echo "      </form>".PHP_EOL;
        echo "  </div>".PHP_EOL;
            
        echo "</div>".PHP_EOL;
                    
    }
    
}

function guardar_jugador(){
    
    if(isset($_POST["btn_guardar_x"]) && isset($_POST["id_jugador"])){
        
        if(($modificar = validar_datos(true)) == 0){
                 
            try{

                JugadorPersistencia::modificar_jugador($_POST["id_jugador"], $_POST["txt_goles"], $_POST["txt_amarillas"], $_POST["txt_rojas"], $_POST["txt_sanciones"]);

            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
   
        }  
  
    }
    
    return isset($modificar)?$modificar:0;
    
}

function agregar_jugador($id_torneo){
    
    if(isset($_POST["btn_agregar_x"])){
        
        if(($agregar = validar_datos(false)) == 0){
                 
            try{
                
                 if(JugadorPersistencia::existe_correo($_POST["txt_correo"], $id_torneo)){                   
                    echo "<script text=\"text/javascript\">alert('Correo ya est\xE1 en uso en este torneo');</script>";
                    $agregar = -1;
                 }else{
                    JugadorPersistencia::agregar_jugador($_POST["txt_nombre"], $_POST["txt_apellido"],  "-", $_POST["txt_correo"], $_POST["txt_telefono"], $_POST["id_equipo"], $id_torneo);
                 }
                    
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
   
        }  
  
    }
    
    return isset($agregar)?$agregar:0;
    
}


function eliminar_jugador(){
    
    if(isset($_POST["btn_eliminar_x"]) && isset($_POST["id_jugador"])){
                 
        try{

            JugadorPersistencia::eliminar_jugador($_POST["id_jugador"]);

        }catch(Exception $ex){

            echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }
  
    }
    
}
    

?>
