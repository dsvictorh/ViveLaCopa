<?php

require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/EquipoPersistencia.php';

if(!revisar_usuario()){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();

}



$torneo = new Torneo();

if(($torneo = TorneoPersistencia::buscar_torneo($_SESSION["tipo"] ==  0?isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0":$_SESSION["torneo"])) == NULL){

    header("Location: torneos.php");
    exit();

}

$pagina = "equipos";
$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>".PHP_EOL;
$check = isset($_POST["chk_filtro"])?$_POST["chk_filtro"]:"aprobado";
$load = "onLoad=\"cargar_equipos('". $check ."')\";";


function listar_equipos($check, $estado){
    
    try{
    
        if($check == "aprobado"){

            listar_equipos_aprobados($estado);

        }else if($check == "pendiente"){

            listar_equipos_pendientes($estado);

        }else{

            listar_equipos_no_aprobados($estado);

        }
    
    }catch(Exception $ex){

        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

    }
    
}

function listar_equipos_aprobados($estado){
    
    $equipo = new Equipo();
    $equipos = array();
    $equipos = EquipoPersistencia::listar_equipo_aprobado($_POST["id_torneo"]);
        
        for($i = 0; $i < count($equipos); $i++){
            
            $equipo = $equipos[$i];
          
            $ultimo_izq = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_der":"":"";

            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $equipo->get_nombre() . "</td>".PHP_EOL;
            echo "  <td>" . $equipo->get_puntos() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            
            echo "      <form name=\"ir_equipo\" autocomplete=\"off\" action=\"equipo.php\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_ir\" src=\"recursos/img/ir.png\" title=\"Ir\" alt=\"Ir\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"aprobado\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;  
            
//            if($estado == "1"){
//            
//            echo "      <form name=\"notificar_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
//            echo "          <input type=\"image\" name=\"btn_notificar\" src=\"recursos/img/notificar.png\" onClick=\"return confirmar('Desea notificar a este equipo que ha sido aprobado?');\" title=\"Notificar\" alt=\"Notificar\" />".PHP_EOL;
//            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
//            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
//            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"aprobado\" />".PHP_EOL;
//            echo "      </form>".PHP_EOL;
//            
//            }
            
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            
            if($estado == "1"){ 
            
            echo "      <form name=\"pendiente_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_pendiente\" src=\"recursos/img/pendiente.png\" onClick=\"return confirmar('Desea marcar este equipo como pendiente?');\" title=\"Pendiente\" alt=\"Pendiente\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"aprobado\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            
            }
            
            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    
}

function listar_equipos_no_aprobados($estado){
    
    $equipo = new Equipo();
    $equipos = array();
    $equipos = EquipoPersistencia::listar_equipo_no_aprobado($_POST["id_torneo"]);
        
        for($i = 0; $i < count($equipos); $i++){
            
            $equipo = $equipos[$i];
          
            $ultimo_izq = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_der":"":"";

            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $equipo->get_nombre() . "</td>".PHP_EOL;
            echo "  <td>" . $equipo->get_puntos() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"ir_equipo\" autocomplete=\"off\" action=\"equipo.php\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_ir\" src=\"recursos/img/ir.png\" title=\"Ir\" alt=\"Ir\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"noaprobado\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;           
            echo "  <td class=\"boton\">".PHP_EOL;
            
            if($estado == "1"){
            
                echo "      <form name=\"pendiente_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "          <input type=\"image\" name=\"btn_pendiente\" src=\"recursos/img/pendiente.png\" onClick=\"return confirmar('Desea marcar este equipo como pendiente?');\" title=\"Pendiente\" alt=\"Pendiente\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"noaprobado\" />".PHP_EOL;
                echo "      </form>".PHP_EOL;
            
            }
            
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton\"" . $ultimo_der . "\">".PHP_EOL;
            
            if($estado == "1"){
            
                echo "      <form name=\"eliminar_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "          <input type=\"image\" name=\"btn_eliminar\" src=\"recursos/img/eliminar.png\" onClick=\"return confirmar('Desea eliminar este equipo permanentemente?');\" title=\"Eliminar\" alt=\"Eliminar\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"noaprobado\" />".PHP_EOL;
                echo "      </form>".PHP_EOL;
            
            }
            
            echo "  </td>".PHP_EOL;           
            echo "</tr>".PHP_EOL;      
        }
    
}

function listar_equipos_pendientes($estado){
    
    $equipo = new Equipo();
    $equipos = array();
    $equipos = EquipoPersistencia::listar_equipo_pendiente($_POST["id_torneo"]);
        
        for($i = 0; $i < count($equipos); $i++){
            
            $equipo = $equipos[$i];
          
            $ultimo_izq = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_der":"":"";

            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $equipo->get_nombre() . "</td>".PHP_EOL;
            echo "  <td>" . $equipo->get_puntos() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"ir_equipo\" autocomplete=\"off\" action=\"equipo.php\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_ir\" src=\"recursos/img/ir.png\" title=\"Ir\" alt=\"Ir\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"pendiente\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;            
            echo "  <td class=\"boton\">".PHP_EOL;
            
            if($estado == "1"){
            
                echo "      <form name=\"aprobado_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "          <input type=\"image\" name=\"btn_aprobado\" src=\"recursos/img/aprobado.png\" onClick=\"return confirmar('Desea marcar este equipo como aprobado?');\" title=\"Aprobado\" alt=\"Aprobado\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
                echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"pendiente\" />".PHP_EOL;
                echo "      </form>".PHP_EOL;
                
            }
                
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            
            if($estado == "1"){
            
            echo "      <form name=\"no_aprobado_equipo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_no_aprobado\" src=\"recursos/img/no_aprobado.png\" onClick=\"return confirmar('Desea marcar este equipo como no aprobado?');\" title=\"No Aprobado\" alt=\"No Aprobado\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $_POST["id_torneo"] . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"pendiente\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            
            }

            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    
}

function cambiar_a_aprobado($id_torneo){
    
       if(isset($_POST["btn_aprobado_x"])){
           
           try{
                if(count(EquipoPersistencia::listar_equipo_aprobado($id_torneo)) < 8){
                    
                EquipoPersistencia::cambiar_estado($_POST["id_equipo"], "1");
                
                }else{
                    
                  echo  "<script type=\"text/javascript\">alert('No se puede exceder el m\xE1ximo de equipos');</script>";
                    
                }
                                
           }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
           
       }
}

function cambiar_no_aprobado(){
    
       if(isset($_POST["btn_no_aprobado_x"])){
           
           try{
               
           EquipoPersistencia::cambiar_estado($_POST["id_equipo"], "2");
           
           }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

           }
           
       }
}

function cambiar_a_pendiente(){
    
       if(isset($_POST["btn_pendiente_x"])){
           
           try{
           
           $coneccion = Coneccion::conectar();
           mysqli_autocommit($coneccion, false);
               
           EquipoPersistencia::cambiar_estado_transaction($coneccion, $_POST["id_equipo"], "3");
           
           EquipoPersistencia::desasignar_de_grupo_transaction($coneccion, $_POST["id_equipo"]);
           
           mysqli_commit($coneccion);
           
           }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
           
       }
}

function eliminar(){
    
       if(isset($_POST["btn_eliminar_x"])){
           
           try{
           
                EquipoPersistencia::eliminar_equipo($_POST["id_equipo"]);
           
           }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
       }
}

function notificar(){
    
       if(isset($_POST["btn_notificar_x"])){
           
           
       }
}

cambiar_a_aprobado($torneo->get_id_torneo());
cambiar_a_pendiente();
cambiar_no_aprobado();
eliminar();
notificar();
?>
