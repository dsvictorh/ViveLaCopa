<?php
require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/EquipoPersistencia.php';
require_once 'BL/Persistencia/PartidoPersistencia.php';
require_once 'BL/Persistencia/PartidoEquipoPersistencia.php';

if(!revisar_usuario()){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();
}

$pagina = "partidos";
$recursos = "<link rel=\"stylesheet\" type=\"text/css\"  href=\"recursos/css/datepicker.css\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/jquery.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/datepicker.js\"></script>";
$load_bottom = "<script type=\"text/javascript\">window.onload=cargar_partidos('". (isset($_POST["hora"])?$_POST["hora"]:"0") ."', '". (isset($_POST["minutos"])?$_POST["minutos"]:"0") . "', '" . (isset($_POST["ampm"])?$_POST["ampm"]:"am") . "');</script>";

$torneo = new Torneo();


if(($torneo = TorneoPersistencia::buscar_torneo($_SESSION["tipo"] ==  0?isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0":$_SESSION["torneo"])) == NULL || !isset($_POST["grupo"])){

    header("Location: torneos.php");
    exit();

}

function listar_partidos($grupo, $torneo){
    
    $equipos = array();
    
    try{
    
    $equipos = EquipoPersistencia::buscar_grupo($torneo->get_id_torneo(), $grupo);
    $partidos = PartidoPersistencia::listar_partido_primera_fase($torneo->get_id_torneo());
    
    pintar_partido(count($equipos) > 0?$equipos[0]:null, count($equipos) > 1?$equipos[1]:null, $partidos[(0 + (($grupo - 1) * 6))], $torneo, "txt_fecha_uno", $grupo);
    pintar_partido(count($equipos) > 2?$equipos[2]:null, count($equipos) > 3?$equipos[3]:null, $partidos[(1 + (($grupo - 1) * 6))], $torneo, "txt_fecha_dos", $grupo);
    pintar_partido(count($equipos) > 0?$equipos[0]:null, count($equipos) > 2?$equipos[2]:null, $partidos[(2 + (($grupo - 1) * 6))], $torneo, "txt_fecha_tres", $grupo);
    pintar_partido(count($equipos) > 1?$equipos[1]:null, count($equipos) > 3?$equipos[3]:null, $partidos[(3 + (($grupo - 1) * 6))], $torneo, "txt_fecha_cuatro", $grupo);
    pintar_partido(count($equipos) > 0?$equipos[0]:null, count($equipos) > 3?$equipos[3]:null, $partidos[(4 + (($grupo - 1) * 6))], $torneo, "txt_fecha_cinco", $grupo);
    pintar_partido(count($equipos) > 1?$equipos[1]:null, count($equipos) > 2?$equipos[2]:null, $partidos[(5 + (($grupo - 1) * 6))], $torneo, "txt_fecha_seis", $grupo);
    

    }catch(Exception $ex){
        
        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
        
    }
    
}

function pintar_partido($primer_equipo, $segundo_equipo, $partido, $torneo, $id_txt_fecha, $grupo){

    $equipo_uno = PartidoEquipoPersistencia::buscar_partido_equipo($partido->get_id_partido(), (($primer_equipo != null)?$primer_equipo->get_id_equipo():"0"));
    $equipo_dos = PartidoEquipoPersistencia::buscar_partido_equipo($partido->get_id_partido(), (($segundo_equipo != null)?$segundo_equipo->get_id_equipo():"0"));
    $edit = ($partido->get_id_partido() == (isset($_POST["id_partido"])?$_POST["id_partido"]:"0"));
    $edit_goles = (($partido->get_id_partido() == (isset($_POST["id_partido"])?$_POST["id_partido"]:"0")) && ($torneo->get_estado() == "2") && ($torneo->get_fase() == "1") && $equipo_uno != null && $equipo_dos != null);
    
    echo "<form name=\"partido_edicion\" method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "\">".PHP_EOL;
    echo "<table class=\"partido custom_grid\">".PHP_EOL;
    echo "  <tr>".PHP_EOL;
    echo "      <th class=\"equipo\">" . (($primer_equipo != null)?($primer_equipo->get_nombre()):"") . "</th>".PHP_EOL;
    echo "      <th class=\"fecha_hora\" colspan=\"2\">vrs</th>".PHP_EOL;
    echo "      <th class=\"equipo\">" . (($segundo_equipo != null)?($segundo_equipo->get_nombre()):"") . "</th>".PHP_EOL;
    echo "      <th class=\"boton\"><a href=\"impresion.php?partido=" . ($partido->get_id_partido()) . "\" target=\"blank\"><img src=\"recursos/img/imprimir.png\" title=\"Imprimir Partido\" alt=\"Imprimir Partido\" /></a></th>".PHP_EOL;
    echo "  </tr>".PHP_EOL;
    echo "  <tr>".PHP_EOL;
    echo "      <td>" . (($edit_goles)?("<input type=\"text\" name=\"txt_goles_equipo_uno\" value=\"" . (($equipo_uno != null)?number_format($equipo_uno->get_goles_favor(), 0):"0") . "\" />"):((($equipo_uno != null)?number_format($equipo_uno->get_goles_favor(), 0):"0"))) . "</td>".PHP_EOL;
    echo "      <td colspan=\"2\">" 
                . (($edit)?("<input type=\"text\" id=\"" . ($id_txt_fecha) . "\"  readonly=\"true\" class=\"date\" onclick=\"enableDatePicker('" . ($id_txt_fecha) ."', this);\" name=\"txt_fecha\" value=\"" . date("m/d/y", strtotime($partido->get_fecha())) . "\" />".PHP_EOL
                . "<select id=\"cmb_hora\" name=\"cmb_hora\">".PHP_EOL
                . "  <option value=\"01\">01</option>".PHP_EOL
                . "  <option value=\"02\">02</option>".PHP_EOL
                . "  <option value=\"03\">03</option>".PHP_EOL
                . "  <option value=\"04\">04</option>".PHP_EOL
                . "  <option value=\"05\">05</option>".PHP_EOL
                . "  <option value=\"06\">06</option>".PHP_EOL
                . "  <option value=\"07\">07</option>".PHP_EOL
                . "  <option value=\"08\">08</option>".PHP_EOL
                . "  <option value=\"09\">09</option>".PHP_EOL
                . "  <option value=\"10\">10</option>".PHP_EOL
                . "  <option value=\"11\">11</option>".PHP_EOL
                . "  <option value=\"12\">12</option>".PHP_EOL
                . "</select>".PHP_EOL
                . ":".PHP_EOL
                . "<select id=\"cmb_minutos\"  name=\"cmb_minutos\">"
                . "  <option value=\"00\">00</option>".PHP_EOL
                . "  <option value=\"05\">05</option>".PHP_EOL
                . "  <option value=\"10\">10</option>".PHP_EOL
                . "  <option value=\"15\">15</option>".PHP_EOL
                . "  <option value=\"20\">20</option>".PHP_EOL
                . "  <option value=\"25\">25</option>".PHP_EOL
                . "  <option value=\"30\">30</option>".PHP_EOL
                . "  <option value=\"35\">35</option>".PHP_EOL
                . "  <option value=\"40\">40</option>".PHP_EOL
                . "  <option value=\"45\">45</option>".PHP_EOL
                . "  <option value=\"50\">50</option>".PHP_EOL
                . "  <option value=\"55\">55</option>".PHP_EOL
                . "</select>".PHP_EOL
                . "<select id=\"cmb_am_pm\"  name=\"cmb_am_pm\">"
                . "  <option value=\"am\">am</option>".PHP_EOL
                . "  <option value=\"pm\">pm</option>".PHP_EOL
                . "</select>".PHP_EOL):strftime("%A %d de %B %Y", strtotime($partido->get_fecha())) . " " . $partido->get_hora_formateada()) .PHP_EOL;
    echo "      </td>".PHP_EOL;
    echo "      <td>" . (($edit_goles)?("<input type=\"text\" name=\"txt_goles_equipo_dos\" value=\"" . (($equipo_dos != null)?number_format($equipo_dos->get_goles_favor(), 0):"0") . "\" />"):(($equipo_dos != null)?number_format($equipo_dos->get_goles_favor(), 0):"0")) . "</td>".PHP_EOL;
    echo "      <td>".PHP_EOL;
    
    if($torneo->get_estado() != 3 && $torneo->get_fase() == 1){
    
        echo (($edit)?("          <input type=\"image\" name=\"btn_guardar\" src=\"recursos/img/guardar.png\" title=\"Guardar\" alt=\"Guardar\" onclick=\"return confirmar_guardar_partido_nuevo();\" />"):("          <input type=\"image\" name=\"btn_editar\" src=\"recursos/img/editar.png\" title=\"Editar Partido\" alt=\"Editar Partido\" />")).PHP_EOL;
        echo "          <input type=\"hidden\" name=\"hora\" value=\"" . substr($partido->get_hora(), 0, 2) . "\" />".PHP_EOL;
        echo "          <input type=\"hidden\" name=\"minutos\" value=\"" . substr($partido->get_hora(), 2, 2) . "\" />".PHP_EOL;
        echo "          <input type=\"hidden\" name=\"ampm\" value=\"" . substr($partido->get_hora(), 4, 2) . "\" />".PHP_EOL;
        echo "          <input type=\"hidden\" name=\"grupo\" value=\"" . $grupo . "\" />".PHP_EOL;
        echo (($edit_goles)? ("          <input type=\"hidden\" name=\"guardar\" value=\"" . (($partido->get_jugado() != "0")?"true":"false")) . "\" />":"").PHP_EOL;
        echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo->get_id_torneo() . "\" />".PHP_EOL;
        echo "          <input type=\"hidden\" name=\"id_equipo_uno\" value=\"" . (($primer_equipo != null)?($primer_equipo->get_id_equipo()):"") . "\" />".PHP_EOL;
        echo "          <input type=\"hidden\" name=\"id_equipo_dos\" value=\"" . (($segundo_equipo != null)?($segundo_equipo->get_id_equipo()):"") . "\" />".PHP_EOL;
        echo ((!$edit)?("          <input type=\"hidden\" name=\"id_partido\" value=\"" . $partido->get_id_partido() . "\" />"):("          <input type=\"hidden\" name=\"id_guardar\" value=\"" . $partido->get_id_partido() . "\" />")).PHP_EOL;
    }
    
    echo "      </td>".PHP_EOL;
    echo "  </tr>".PHP_EOL;
    echo "  <tr>".PHP_EOL;
    echo "      <td class=\"subtitulo\">Cancha</td>".PHP_EOL;
    echo "      <td class=\"subtitulo\" colspan=\"2\">Detalle</td>".PHP_EOL;
    echo "      <td class=\"subtitulo\"></td>".PHP_EOL;
    echo "      <td class=\"subtitulo\"></td>".PHP_EOL;
    echo "  </tr>".PHP_EOL;
    echo "  <tr>".PHP_EOL;
    echo "      <td class=\"subseccion\">" . (($edit)?("<input type=\"text\" name=\"txt_cancha\" value=\"" . (($partido->get_numero_cancha() == "0"?"":$partido->get_numero_cancha())) . "\" />"):((($partido->get_numero_cancha() == "0"?"":$partido->get_numero_cancha())))) . "</td>".PHP_EOL;
    echo "      <td class=\"izquierda subseccion\" colspan=\"4\">".PHP_EOL;
    echo (($edit)?("          <textarea name=\"txt_partido_detalle\">" . $partido->get_detalle() . "</textarea>"):("          <span class=\"wrap\">" . $partido->get_detalle() . "</span>")).PHP_EOL;
    echo "      </td>".PHP_EOL;
    echo "  </tr>".PHP_EOL;
    echo "</table>".PHP_EOL;
    echo "</form>".PHP_EOL;                            
    
}

function guardar_cambios($estado, $fase){
    
    if(isset($_POST["btn_guardar_x"])){
        
        $coneccion = Coneccion::conectar();
        mysqli_autocommit($coneccion, false);
     
        try{
        
            $partido = PartidoPersistencia::buscar_partido(isset($_POST["id_guardar"])?$_POST["id_guardar"]:"0");
            
            if($fase == "1" && $partido != null){
                
                if(isset($_POST["txt_fecha"]) && isset($_POST["cmb_hora"]) && isset($_POST["cmb_minutos"]) && isset($_POST["cmb_am_pm"])  && isset($_POST["txt_cancha"]) && isset($_POST["txt_partido_detalle"]))
                    PartidoPersistencia::modificar_partido_transaction($coneccion, $partido->get_id_partido(), $_POST["txt_fecha"], $_POST["cmb_hora"] . $_POST["cmb_minutos"] . $_POST["cmb_am_pm"], (strlen($_POST["txt_cancha"])) != 0?$_POST["txt_cancha"]:"0", $_POST["txt_partido_detalle"]);

                    if($estado == "2"){
                        
                        if(isset($_POST["txt_goles_equipo_uno"]) && isset($_POST["txt_goles_equipo_dos"])){
                            
                            if(preg_match($GLOBALS["numero"], $_POST["txt_goles_equipo_uno"]) && preg_match($GLOBALS["numero"], $_POST["txt_goles_equipo_dos"])){

                                $equipo_uno = PartidoEquipoPersistencia::buscar_partido_equipo($partido->get_id_partido(), isset($_POST["id_equipo_uno"])?$_POST["id_equipo_uno"]:"0");
                                $equipo_dos = PartidoEquipoPersistencia::buscar_partido_equipo($partido->get_id_partido(), isset($_POST["id_equipo_dos"])?$_POST["id_equipo_dos"]:"0");

                                if($equipo_uno != null && $equipo_dos != null){

                                    if(($partido->get_jugado()) == "1"){

                                        $puntos = ($equipo_uno->get_goles_favor() <= $equipo_uno->get_goles_contra())?($equipo_uno->get_goles_favor() == $equipo_uno->get_goles_contra())?"-1":"0":"-3";

                                        EquipoPersistencia::modificar_puntos_transaction($coneccion, $equipo_uno->get_id_equipo(), $puntos);

                                        $puntos = ($equipo_dos->get_goles_favor() <= $equipo_dos->get_goles_contra())?($equipo_dos->get_goles_favor() == $equipo_dos->get_goles_contra())?"-1":"0":"-3";

                                        EquipoPersistencia::modificar_puntos_transaction($coneccion, $equipo_dos->get_id_equipo(), $puntos);

                                    }else{
                                        
                                        if(((isset($_POST["guardar"])?$_POST["guardar"]:"false") == "true") || $equipo_uno->get_goles_favor() != 0)
                                            PartidoPersistencia::marcar_jugado_transaction($coneccion, $partido->get_id_partido());

                                    }
                                    
                                    if(((isset($_POST["guardar"])?$_POST["guardar"]:"false") == "true") || $equipo_uno->get_goles_favor() != 0){

                                        $puntos = ($_POST["txt_goles_equipo_uno"] <= $_POST["txt_goles_equipo_dos"])?($_POST["txt_goles_equipo_uno"] == $_POST["txt_goles_equipo_dos"])?"1":"0":"3";

                                        EquipoPersistencia::modificar_puntos_transaction($coneccion, $equipo_uno->get_id_equipo(), $puntos);
                                        PartidoEquipoPersistencia::modificar_partido_equipo_transaction($coneccion, $equipo_uno->get_id_equipo(), $partido->get_id_partido(), $_POST["txt_goles_equipo_uno"], $_POST["txt_goles_equipo_dos"]);

                                        $puntos = ($_POST["txt_goles_equipo_dos"] <= $_POST["txt_goles_equipo_uno"])?($_POST["txt_goles_equipo_dos"] == $_POST["txt_goles_equipo_uno"])?"1":"0":"3";

                                        EquipoPersistencia::modificar_puntos_transaction($coneccion, $equipo_dos->get_id_equipo(), $puntos);
                                        PartidoEquipoPersistencia::modificar_partido_equipo_transaction($coneccion, $equipo_dos->get_id_equipo(), $partido->get_id_partido(), $_POST["txt_goles_equipo_dos"], $_POST["txt_goles_equipo_uno"]);

                                    }
                                    
                                }

                            }
                        }
                    }

                }
                
            mysqli_commit($coneccion);
            
        }catch(Exception $ex){
            
             echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
            
        }
        
    }    
    
}

guardar_cambios($torneo->get_estado(), $torneo->get_fase());

?>
