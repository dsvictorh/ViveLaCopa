<?php
require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/EquipoPersistencia.php';



if(!revisar_usuario()){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();
}

$pagina = "primerafase";
$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";


$torneo = new Torneo();


if(($torneo = TorneoPersistencia::buscar_torneo($_SESSION["tipo"] ==  0?isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0":$_SESSION["torneo"])) == NULL){

    header("Location: torneos.php");
    exit();

}


    function listar_equipos_no_asignados($id_torneo){

        try{

            $equipos = array();

            $equipos = EquipoPersistencia::listar_equipo_no_asignado($id_torneo);

            for($i = 0;$i < count($equipos);$i++){

                $equipo = new Equipo();
                $equipo = $equipos[$i];

                $ultimo_izq = $i == (count($equipos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
                $ultimo_der = $i == (count($equipos)-1)?!($i % 2 == 0)?"class=\"ultimo_der\"":"":"";

                echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
                echo "  <td class=\"izquierda " . $ultimo_izq . "\">" . $equipo->get_nombre() . "</td>".PHP_EOL;
                echo "  <td " . $ultimo_der . ">".PHP_EOL;
                echo "   <form name=\"grupo_asignar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "      <select  name=\"cmb_grupos\" onchange=\"submit(this);\">".PHP_EOL;
                echo "          <option value=\"0\">-</option>".PHP_EOL;

                for($j = 0; $j < (8 / 4); $j++)                    
                echo "          <option value=\"" . ($j + 1) . "\">" . ($j + 1) . "</option>".PHP_EOL;

                echo "      </select>".PHP_EOL;
                echo "      <input type=\"hidden\" name=\"id_torneo\" value=\"" . $id_torneo . "\"  />".PHP_EOL;
                echo "      <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\"  />".PHP_EOL;
                echo "   </form>".PHP_EOL;
                echo "  </td>".PHP_EOL;
                echo "</tr>".PHP_EOL;

            }

        }catch(Exception $ex){

            echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }

    }
    
    function listar_grupos($id_torneo, $estado, $fase){
        
        try{
           
            for($i = 0; $i < (8 / 4);$i++){

                echo "<table class=\"grupo custom_grid\">".PHP_EOL;
                echo "  <tr>".PHP_EOL;
                echo "      <th colspan=\"3\">Grupo " . ($i + 1) . "</th>".PHP_EOL;
                //echo "      <th class=\"puntos\">Puntos</th>".PHP_EOL;
                //echo "      <th class=\"boton\"></th>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                $grupo= EquipoPersistencia::buscar_grupo($id_torneo, ($i + 1));
                $ultimo_izq = "";
                $ultimo_der = "";
                $oscuro  = false;
                
                $equipo = new Equipo();
                
                for($j = 0; $j < count($grupo); $j++){
                    
                   
                    $equipo = $grupo[$j];

                    if($equipo != null){
                        
                        $oscuro = ($j % 2 == 0);
                        $ultimo_izq = $j == (count($grupo)-1)?($j % 2 == 0)?" ultimo_izq":"":"";
                        $ultimo_der = $j == (count($grupo)-1)?($j % 2 == 0)?" ultimo_der":"":"";
                   

                        echo ($j % 2 == 0)?"  <tr>":"<tr class=\"oscuro\">".PHP_EOL;
                        echo "    <td class=\"izquierda centrado grupo_equipo" . $ultimo_izq . "\">" . $equipo->get_nombre() . "</td>".PHP_EOL;
                        echo "    <td class=\"puntos\">" . $equipo->get_puntos() . (($equipo->get_puntos_extra() > 0)?("<sup>" . $equipo->get_puntos_extra() . "</sup>"):"") . "</td>".PHP_EOL; 
                        echo "    <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
                        if($estado == "1"){
                        echo "        <form name=\"desasignar_equipo\" autocomplete=\"off\" method=\"post\" accion=\"" . $_SERVER["PHP_SELF"] . " \">".PHP_EOL;
                        echo "            <input type=\"image\" name=\"btn_desasignar\" src=\"recursos/img/cancelar.png\" title=\"Desasignar Equipo\" alt=\"Desasignar Equipo\" />".PHP_EOL;
                        echo "            <input type=\"hidden\" name=\"id_torneo\" value=\"" . $id_torneo . "\"  />".PHP_EOL;
                        echo "            <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\"  />".PHP_EOL;
                        echo "            <input type=\"hidden\" name=\"posicion\" value=\"" . $equipo->get_posicion() . "\"  />".PHP_EOL;
                        echo "            <input type=\"hidden\" name=\"grupo\" value=\"" . $equipo->get_grupo() . "\"  />".PHP_EOL;
                        echo "        </form>".PHP_EOL;
                        }elseif($estado == "2" && $fase == "1"){
                           echo "        <form name=\"controlar_puntos\" autocomplete=\"off\" method=\"post\" accion=\"" . $_SERVER["PHP_SELF"] . " \">".PHP_EOL;
                           echo "            <input type=\"image\" name=\"btn_agregar_punto\" src=\"recursos/img/agregar_punto.png\" title=\"Agregar Punto\" alt=\"Agregar Punto\" onClick=\"return confirmar('Desea agregar un punto extra a: " . $equipo->get_nombre() . "?');\" />".PHP_EOL;
                           echo "            <input type=\"image\" name=\"btn_remover_punto\" src=\"recursos/img/remover_punto.png\" title=\"Remover Punto\" alt=\"Remover Punto\" onClick=\"return confirmar('Desea remover un punto a: " . $equipo->get_nombre() . "?');\" />".PHP_EOL;
                           echo "            <input type=\"hidden\" name=\"id_torneo\" value=\"" . $id_torneo . "\"  />".PHP_EOL;
                           echo "            <input type=\"hidden\" name=\"id_equipo\" value=\"" . $equipo->get_id_equipo() . "\"  />".PHP_EOL;
                           echo "        </form>".PHP_EOL; 
                            
                        }
                        echo "    </td>".PHP_EOL;
                        echo "  </tr>".PHP_EOL;
                    }

                }
                
                 echo ($oscuro)?"<tr class=\"oscuro\">":"<tr>".PHP_EOL;
                 echo "    <td class=\"grupo_equipo" . ($ultimo_izq) . "\"></td>".PHP_EOL;
                 echo "    <td class=\"puntos\"></td>".PHP_EOL; 
                 echo "    <td class=\"boton" . ($ultimo_der) . "\">".PHP_EOL;
                 echo "        <form name=\"ver_partidos\" autocomplete=\"off\" method=\"post\" action=\"partidos.php\">".PHP_EOL;
                 echo "            <input type=\"image\" name=\"btn_partidos\" src=\"recursos/img/partidos.png\" title=\"Ir a partidos\" alt=\"Ir a partidos\" />".PHP_EOL;
                 echo "            <input type=\"hidden\" name=\"id_torneo\" value=\"" . $id_torneo . "\"  />".PHP_EOL;
                 echo "            <input type=\"hidden\" name=\"grupo\" value=\"" . ($i + 1) . "\"  />".PHP_EOL;
                 echo "        </form>".PHP_EOL;
                 echo "    </td>".PHP_EOL;
                 echo "  </tr>".PHP_EOL;
                

                echo "</table>".PHP_EOL.PHP_EOL;
            
        }
        
        }catch(Exception $ex){
                
            echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
                                
        }    
    }
    
    
    function asignar_equipo($id_torneo){
        
        if(isset($_POST["cmb_grupos"]) && isset($_POST["id_equipo"])){
            
            try{
            
            if(($posicion = EquipoPersistencia::obtener_siguiente_posicion($id_torneo, $_POST["cmb_grupos"])) < 5){
                
                if($posicion > 0){
                    
                    EquipoPersistencia::asignar_a_grupo($_POST["id_equipo"], $_POST["cmb_grupos"], $posicion);
                    
                }
         
            }
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
                                
           }
            
            
        }
        
        
    }
    
    function desasignar_equipo($id_torneo){
  
        if(isset($_POST["btn_desasignar_x"]) && isset($_POST["id_equipo"]) && isset($_POST["posicion"]) && isset($_POST["grupo"])){
            
            $coneccion = Coneccion::conectar();
            mysqli_autocommit($coneccion, false);
           
            try{
                
            $siguiente_posicion = EquipoPersistencia::obtener_siguiente_posicion($id_torneo, $_POST["grupo"]);
            
            echo $_POST["posicion"] + 1;
            echo $siguiente_posicion;
            
            for($i = $_POST["posicion"] + 1; $i < $siguiente_posicion; $i++ ){
                
                EquipoPersistencia::modificar_posicion_transaction($coneccion, $i, $i - 1, $_POST["grupo"], $id_torneo);

            }
            
            EquipoPersistencia::desasignar_de_grupo_transaction($coneccion, $_POST["id_equipo"]);
            
            mysqli_commit($coneccion);
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
                                
           }
            
        }
        
    }
    
    function asignar_aleatorio($id_torneo){
        
        if(isset($_POST["btn_random_x"])){
            
            $coneccion = Coneccion::conectar();
            mysqli_autocommit($coneccion, false);

            try{

                $equipos = array();

                $equipo = new Equipo();

                EquipoPersistencia::desasignar_por_torneo_transaction($coneccion, $id_torneo);

                $equipos = EquipoPersistencia::listar_equipo_no_asignado_transaction($coneccion, $id_torneo);


                if(shuffle($equipos)){

                        $grupo = 1;
                        $posicion = 1;

                        for($i = 0; $i < count($equipos); $i++, $posicion ++){

                            if($i % 4 == 0 && $i != 0){

                                $grupo++;
                                $posicion = 1;

                            }

                            $equipo = $equipos[$i];

                            EquipoPersistencia::asignar_a_grupo_transaction($coneccion, $equipo->get_id_equipo(), $grupo, $posicion);

                        }

                }


                mysqli_commit($coneccion);

            }catch(Exception $ex){

                    echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        
        }
            
    }  
    
   function agregar_punto(){
        
        if(isset($_POST["btn_agregar_punto_x"]) && isset($_POST["id_equipo"])){
            
            try{
            
                EquipoPersistencia::agregar_punto_extra($_POST["id_equipo"]);
         
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
                                
           }
            
            
        }
        
        
    }
    
    function remover_punto(){
        
        if(isset($_POST["btn_remover_punto_x"]) && isset($_POST["id_equipo"])){
            
            try{
            
                EquipoPersistencia::remover_punto_extra($_POST["id_equipo"]);
         
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
                                
           }
            
            
        }
        
        
    }
    

    asignar_equipo($torneo->get_id_torneo());
    desasignar_equipo($torneo->get_id_torneo());
    asignar_aleatorio($torneo->get_id_torneo());
    agregar_punto();
    remover_punto();
    
    
    
?>
