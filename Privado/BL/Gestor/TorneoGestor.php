<?php
require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/EquipoPersistencia.php';
require_once 'BL/Persistencia/PartidoEquipoPersistencia.php';
require_once 'BL/Persistencia/PartidoPersistencia.php';




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

$pagina = "torneo";
$recursos = "<link rel=\"stylesheet\" type=\"text/css\"  href=\"recursos/css/datepicker.css\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/jquery.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/datepicker.js\"></script>";


function validar_estado($cancelado, $finalizado){

    return $cancelado?"Este torneo ha sido cancelado":$finalizado?"Este torneo ha finalizado":""; 

}

function validar_datos(){

    //1 - Incompleto
    //2 - Caracteres Especiales
    //3 - Fecha no valida
    //4 - Precio no es numero
    //5 - Fecha inicio mayor
    $valido = 0;

    $valido = ($valido == 0)?(isset($_POST["txt_torneo"])?$_POST["txt_torneo"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_fecha_inicio"])?$_POST["txt_fecha_inicio"]:"") != ""
        ?(preg_match($GLOBALS["fecha"], $_POST["txt_fecha_inicio"]))
        ?0:3:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_fecha_fin"])?$_POST["txt_fecha_fin"]:"") != ""
        ?(preg_match($GLOBALS["fecha"], $_POST["txt_fecha_fin"]))
        ?0:3:1:$valido;

    $valido = ($valido == 0)?strtotime($_POST["txt_fecha_inicio"]) < strtotime($_POST["txt_fecha_fin"])?0:5:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_torneo_detalle"])?$_POST["txt_torneo_detalle"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo_detalle"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_torneo_detalle"])?$_POST["txt_torneo_detalle"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo_detalle"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_precio"])?$_POST["txt_precio"]:"") != ""
        ?(preg_match($GLOBALS["numero"], $_POST["txt_precio"]))
        ?0:4:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_precio_detalle"])?$_POST["txt_precio_detalle"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_precio_detalle"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_primer_premio"])?$_POST["txt_primer_premio"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_primer_premio"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_segundo_premio"])?$_POST["txt_segundo_premio"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_segundo_premio"]))
        ?2:0:1:$valido;

    $valido = ($valido == 0)?(isset($_POST["txt_tercer_premio"])?$_POST["txt_tercer_premio"]:"") != ""
        ?(preg_match($GLOBALS["novalidos"], $_POST["txt_tercer_premio"]))
        ?2:0:1:$valido;
    
    $valido = ($valido == 0)?(isset($_POST["txt_reglamento"])?$_POST["txt_reglamento"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_reglamento"]))
            ?2:0:1:$valido;

    return $valido;

}

function mostrar_menu_torneo($cancelado, $id_torneo, $fases, $estado, $fase){
    
    if(!$cancelado){

        echo "<table id=\"menu_torneo\">".PHP_EOL;

        echo "    <tr>".PHP_EOL;
        echo "        <td>".PHP_EOL;
        echo "            <form name=\"equipos\" autocomplete=\"off\" action=\"equipos.php\" method=\"post\">".PHP_EOL;
        echo "              <input type=\"image\" src=\"recursos/img/equipos.png\" alt=\"Equipos\" title=\"Equipos\" name=\"btn_equipos\" />".PHP_EOL;
        echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
        echo "            </form>".PHP_EOL;
        echo "        </td>".PHP_EOL;

        if($fases == "2"){
        
            echo "        <td>".PHP_EOL;
            echo "            <form name=\"primera_fase\" autocomplete=\"off\" action=\"primera-fase.php\" method=\"post\">".PHP_EOL;
            echo "              <input type=\"image\" src=\"recursos/img/primera_fase.png\" alt=\"Grupos\" title=\"Grupos\" name=\"btn_primera_fase\" />".PHP_EOL;
            echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
            echo "            </form>".PHP_EOL;
            echo "        </td>".PHP_EOL;

        }
      
        echo "        <td>".PHP_EOL;
        echo "            <form name=\"segunda_fase\" autocomplete=\"off\" action=\"segunda-fase.php\" method=\"post\">".PHP_EOL;
        echo "            <input type=\"image\" src=\"recursos/img/segunda_fase.png\" alt=\"Llave\" title=\"Llave\" name=\"btn_segunda_fase\" />".PHP_EOL;
        echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
        echo "            </form>".PHP_EOL;
        echo "        </td>".PHP_EOL;
        
        if($estado == 1){
         
            echo "        <td>".PHP_EOL;
            echo "            <form name=\"abrir_torneo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "            <input type=\"image\" src=\"recursos/img/abrir_torneo.png\" alt=\"Abrir Torneo\" title=\"Abrir Torneo\" onclick=\"return confirmar('Est\xE1 seguro que desea abrir el torneo?');\" name=\"btn_abrir_torneo\" />".PHP_EOL;
            echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
            echo "            </form>".PHP_EOL;
            echo "        </td>".PHP_EOL;
            
            
        }elseif($estado == 2){
          
            if($fase == 1){
             
                echo "        <td>".PHP_EOL;
                echo "            <form name=\"primera_segunda_fase\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "            <input type=\"image\" src=\"recursos/img/primera_segunda_fase.png\" alt=\"Concluir Primera Fase\" title=\"Concluir Primera Fase\" onclick=\"return confirmar('Est\xE1 seguro que desea pasar a la segunda fase?');\" name=\"btn_primera_segunda_fase\" />".PHP_EOL;
                echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
                echo "            </form>".PHP_EOL;
                echo "        </td>".PHP_EOL;
                
                
            }else{
                
                echo "        <td>".PHP_EOL;
                echo "            <form name=\"finalizar_torneo\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
                echo "            <input type=\"image\" src=\"recursos/img/finalizar_torneo.png\" alt=\"Finalizar Torneo\" title=\"Finalizar Torneo\" onclick=\"return confirmar('Est\xE1 seguro que desea finalizar el torneo el torneo?');\" name=\"btn_finalizar_torneo\" />".PHP_EOL;
                echo "              <input type=\"hidden\" value=\"" . $id_torneo . "\" name=\"id_torneo\" />".PHP_EOL;
                echo "            </form>".PHP_EOL;
                echo "        </td>".PHP_EOL;
                
            }
            
        }

        echo "    </tr>".PHP_EOL;

        echo " </table>".PHP_EOL;
       
    }
    
}


function modificar(){

    if(isset($_POST["btn_editar_torneo_x"])){

        if(($modificar = validar_datos()) == 0){
            
            try{

            TorneoPersistencia::modificar_torneo($_SESSION["tipo"] == 0?$_POST["id_torneo"]:$_SESSION["torneo"], $_POST["txt_torneo"], $_POST["txt_fecha_inicio"], $_POST["txt_fecha_fin"], $_POST["txt_torneo_detalle"], $_POST["txt_precio"], $_POST["txt_primer_premio"], $_POST["txt_segundo_premio"], $_POST["txt_tercer_premio"], $_POST["txt_precio_detalle"], $_POST["txt_reglamento"]);

            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }

    }

    return isset($modificar)?$modificar:0;

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
            $mensaje = "Formato de fecha no v&aacute;lido";
            break;

        case 4:
            $mensaje = "El precio debe ser un n&uacute;mero";
            break;  

        case 5:
            $mensaje = "La fecha de inicio debe ser menor a la fecha de fin";
            break;


    }

    return $mensaje;


}

function abrir_torneo(&$torneo){
    
    if(isset($_POST["btn_abrir_torneo_x"]) && $torneo->get_estado() == 1){
        
        try{
            
            $coneccion = Coneccion::conectar();
            mysqli_autocommit($coneccion, false);
        
            if(count($equipos = EquipoPersistencia::listar_equipo_aprobado($torneo->get_id_torneo())) == 8){

            if($torneo->get_numero_fases() == 2){

                if(count(EquipoPersistencia::listar_equipo_no_asignado($torneo->get_id_torneo())) == 0){
                    
                    $partidos = PartidoPersistencia::listar_partido_primera_fase($torneo->get_id_torneo());
                                     
                    if(count($partidos) == ((8/4)*6)){

                    for($i=0; $i < (8/4); $i++){

                        $equipos = EquipoPersistencia::buscar_grupo_transaction($coneccion, $torneo->get_id_torneo(), ($i +1));

                        if(count($equipos) == 4){
                            
                            //1 vs 2
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[0]->get_id_equipo(), $partidos[(0 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[1]->get_id_equipo(), $partidos[(0 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                            //3 vs 4
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[2]->get_id_equipo(), $partidos[(1 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[3]->get_id_equipo(), $partidos[(1 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                            //1 vs 3
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[0]->get_id_equipo(), $partidos[(2 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[2]->get_id_equipo(), $partidos[(2 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                            //2 vs 4
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[1]->get_id_equipo(), $partidos[(3 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[3]->get_id_equipo(), $partidos[(3 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                            //1 vs 4
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[0]->get_id_equipo(), $partidos[(4 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[3]->get_id_equipo(), $partidos[(4 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                            //2 vs 3
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[1]->get_id_equipo(), $partidos[(5 + ($i * 6))]->get_id_partido(), "0", "0");
                            PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[2]->get_id_equipo(), $partidos[(5 + ($i * 6))]->get_id_partido(), "0", "0");
                            
                        }else{
                            
                            mysqli_rollback($coneccion);
                            throw new Exception("Insuficientes equipos en los grupos");
                            
                        }
                    }
                    
                    TorneoPersistencia::cambiar_estado_transaction($coneccion,$torneo->get_id_torneo(), "2");
                    $torneo->set_estado("2");
                    
                    }else{
                        
                        mysqli_rollback($coneccion);
                        throw new Exception("Los datos de este torneo han sido manipulados o est\xE1n imcompletos.Por favor comunicarse con el administrador de base de datos y desarrollador");
                        
                    }


                }else{

                    echo "<script type=\"text/javascript\">alert('Faltan equipos por asignar a un grupo');</script>";

                }

            }else{

                $partidos = PartidoPersistencia::listar_partido_segunda_fase($torneo->get_id_torneo());
                                     
                    if(count($partidos) == (8-2)){
                        
                        for($i = 0, $j = 0; $i < count($equipos); $i += 2, $j++){
                        
                         PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[$i]->get_id_equipo(), $partidos[$j]->get_id_partido(), "0", "0");
                         
                         PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $equipos[$i + 1]->get_id_equipo(), $partidos[$j]->get_id_partido(), "0", "0");
                        
                        }
                        
                         TorneoPersistencia::cambiar_estado_transaction($coneccion, $torneo->get_id_torneo(), "2");
                         $torneo->set_estado("2");
                         
                    }else{
                        
                        mysqli_rollback($coneccion);
                        throw new Exception("Los datos de este torneo han sido manipulados o est\xE1n imcompletos.Por favor comunicarse con el administrador de base de datos y desarrollador");
                        
                    }
           
            }
            

            }else{

            echo "<script type=\"text/javascript\">alert('No hay suficientes equipos aprobados');</script>"; 

            }
            
           
            mysqli_commit($coneccion);
            
        }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }
    }
    
    
}

function finalizar_torneo(&$torneo){
    
    if(isset($_POST["btn_finalizar_torneo_x"]) && $torneo->get_estado() == 2){
        
        if($torneo->get_fase() == 2){
            
            $partidos = PartidoPersistencia::listar_partido_segunda_fase($torneo->get_id_torneo());
            $final = PartidoPersistencia::buscar_partido_final($torneo->get_id_torneo());
            $tercer_lugar = PartidoPersistencia::buscar_partido_tercer_mejor($torneo->get_id_torneo());
            
            $finalizado = true;
            
            for($i = 0; $i < count($partidos); $i++){
                
                $finalizado = $finalizado && ($partidos[$i]->get_jugado() == 1);
                
            }
            
            $finalizado = ($finalizado && ($final->get_jugado() == 1));
            $finalizado = ($finalizado && ($tercer_lugar->get_jugado() == 1));
            
            if($finalizado){
                
                TorneoPersistencia::cambiar_estado($torneo->get_id_torneo(), "3");
                $torneo->set_estado("3");
                
            }else{
            
            echo "<script type=\"text/javascript\">alert('No se han jugado todas las fases de este torneo');</script>";
            
            }
            
        }
            
        
    }
    
    
}

function concluir_primera_fase(&$torneo){
    
    if(isset($_POST["btn_primera_segunda_fase_x"]) && $torneo->get_estado() == 2 && $torneo->get_fase() == 1){
        
            $partidos = PartidoPersistencia::listar_partido_primera_fase($torneo->get_id_torneo());
            $segunda_fase = PartidoPersistencia::listar_partido_segunda_fase($torneo->get_id_torneo());
            
            if(count($partidos) != ((8/4)*6) || count($segunda_fase) != ((8/2)-2))             
                 throw new Exception("Los datos de este torneo han sido manipulados o est\xE1n imcompletos.Por favor comunicarse con el administrador de base de datos y desarrollador");
                    
            
            $finalizado = true;

            for($i = 0; $i < count($partidos); $i++){

                $finalizado = $finalizado && ($partidos[$i]->get_jugado() == 1);

            }
            
             if($finalizado){
                
                $coneccion = Coneccion::conectar();
                mysqli_autocommit($coneccion, false);
                
                $ganadores = array();
                $eliminados = array();
                $iguales = array();
                
                for($i = 0; $i < (8/4) ;$i++){
                    
                    $equipos = EquipoPersistencia::buscar_grupo_transaction($coneccion, $torneo->get_id_torneo(), ($i + 1));
                    
                    if(count($equipos) == 4){
                    
                        
                        
                         $primero = $equipos[0];
                         $segundo = $equipos[1];
                         $iguales[] = 0;
                         $es_primero = false;
                         $es_igual = false;
                         
                         
                         if($segundo->get_puntos() >= $primero->get_puntos()){
                            
                             if($segundo->get_puntos() == $primero->get_puntos()){
                             
                                if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo()) >= PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){
        
                                     if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){

                                         if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo()) > PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){

                                                $primero = $equipos[1];
                                                $segundo = $equipos[0];
                                                
                                         }else{
                                             
                                             
                                             if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){
                                             
                                                 if($segundo->get_puntos_extra() >= $primero->get_puntos_extra()){
                                                     
                                                     if($segundo->get_puntos_extra() == $primero->get_puntos_extra()){
                                                     
                                                        $iguales[$i] += 2; 
                                                     
                                                     }else{
                                                        
                                                        $primero = $equipos[1];
                                                        $segundo = $equipos[0];
                                                        
                                                     }
                                                         
                                                 }
                                             
                                            }
                                             
                                         }      

                                     }else{

                                        $primero = $equipos[1];
                                        $segundo = $equipos[0];

                                    }


                                }
                                
                             }else{
                                    
                                    $primero = $equipos[1];
                                    $segundo = $equipos[0];                
                             }
                                 
                         }
                         
                         
                         if($equipos[2]->get_puntos() >= $primero->get_puntos()){
                            
                             if($equipos[2]->get_puntos() == $primero->get_puntos()){
                             
                                if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[2]->get_id_equipo()) >= PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){
        
                                     if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[2]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){

                                         if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[2]->get_id_equipo()) > PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){

                                                $eliminados[] = $segundo;
                                                $segundo = $primero;
                                                $primero = $equipos[2];
                                                $es_primero = true;
                                                
                                                if($iguales[$i] == 2)
                                                   $iguales[$i] += 2;

                                                
                                         }else{
                                             
                                             if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[2]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){
                                                
                                                 if($equipos[2]->get_puntos_extra() >= $primero->get_puntos_extra()){
                                                     
                                                     if($equipos[2]->get_puntos_extra() == $primero->get_puntos_extra()){
                                                     
                                                       if($iguales[$i] == 2) 
                                                            $iguales[$i] += 1;
                                                        else
                                                            $iguales[$i] += 2;

                                                        $es_igual = true; 
                                                     
                                                     }else{
                                                        
                                                        $eliminados[] = $segundo;
                                                        $segundo = $primero;
                                                        $primero = $equipos[2];
                                                        $es_primero = true;

                                                        if($iguales[$i] == 2)
                                                        $iguales[$i] += 2;
                                                        
                                                     }
                                                         
                                                 }
                                             }
                                         }      

                                     }else{

                                        $eliminados[] = $segundo;
                                        $segundo = $primero;
                                        $primero = $equipos[2];
                                        $es_primero = true;
                                        
                                        if($iguales[$i] == 2)
                                           $iguales[$i] += 2;
  

                                    }


                                }
                                
                             }else{
                                    
                                    $eliminados[] = $segundo;
                                    $segundo = $primero;
                                    $primero = $equipos[2];
                                    $es_primero = true;
                                    
                                    if($iguales[$i] == 2)
                                       $iguales[$i] += 2;

                                    
                             }
                                 
                         }
                         
                         if(!$es_primero && $equipos[2]->get_puntos() >= $segundo->get_puntos()){
                             
                             if($equipos[2]->get_puntos() == $segundo->get_puntos()){
                             
                                if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[2]->get_id_equipo()) >= PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo())){
        
                                     if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[2]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo())){

                                         if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[2]->get_id_equipo()) > PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo())){

                                                $eliminados[] = $segundo;
                                                $segundo = $equipos[2];
                                         }else{

                                             if(!$es_igual){
                                                 
                                                 if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[2]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo())){
                                         
                                                     if($equipos[2]->get_puntos_extra() >= $segundo->get_puntos_extra()){
                                                     
                                                        if($equipos[2]->get_puntos_extra() == $segundo->get_puntos_extra()){

                                                            $iguales[$i] += 1;

                                                        }else{

                                                           $eliminados[] = $segundo;
                                                           $segundo = $equipos[2];

                                                        }

                                                    }  
 
                                                 }
                                                 
                                             }
                                             
                                         }     

                                     }else{

                                        $eliminados[] = $segundo;
                                        $segundo = $equipos[2];

                                    }


                                }
                                
                             }else{
                                    
                                    $eliminados[] = $segundo;
                                    $segundo = $equipos[2];
                                    
                             }
                             
                         }else{
                             
                             $eliminados[] = $equipos[2]; 
                         }
                         
                         $es_primero = false;
                         $es_igual = false;
                         
                         if($equipos[3]->get_puntos() >= $primero->get_puntos()){
                            
                             if($equipos[3]->get_puntos() == $primero->get_puntos()){
                             
                                if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[3]->get_id_equipo()) >= PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){
        
                                     if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[3]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $primero->get_id_equipo())){

                                         if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[3]->get_id_equipo()) > PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){

                                                $eliminados[] = $segundo;
                                                $segundo = $primero;
                                                $primero = $equipos[3];
                                                $es_primero = true;
                                                
                                                 if($iguales[$i] == 4)
                                                    $iguales[$i] = 2;


                                                
                                         }else{
                                             
                                             if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[3]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $primero->get_id_equipo())){
                                             
                                                 if($equipos[3]->get_puntos_extra() >= $primero->get_puntos_extra()){
                                                     
                                                     if($equipos[3]->get_puntos_extra() == $primero->get_puntos_extra()){
                                                     
                                                       if($iguales[$i] == 4)
                                                            $iguales[$i] = 2;
                                                        elseif($iguales[$i] == 0)
                                                            $iguales[$i] += 2;
                                                        else
                                                            $iguales[$i] += 1; 

                                                        $es_igual = true; 
                                                     
                                                     }else{
                                                        
                                                        $eliminados[] = $segundo;
                                                        $segundo = $primero;
                                                        $primero = $equipos[3];
                                                        $es_primero = true;

                                                        if($iguales[$i] == 4)
                                                            $iguales[$i] = 2;
                                                        
                                                     }
                                                         
                                                 }
                                             
                                             }
                                             
                                         }      

                                     }else{

                                        $eliminados[] = $segundo;
                                        $segundo = $primero;
                                        $primero = $equipos[3];
                                        $es_primero = true;
                                        
                                         if($iguales[$i] == 4)
                                            $iguales[$i] = 2;

                                    }


                                }
                                
                             }else{
                                    
                                    $eliminados[] = $segundo;
                                    $segundo = $primero;
                                    $primero = $equipos[3];
                                    $es_primero = true;
                                    
                                     if($iguales[$i] == 4)
                                        $iguales[$i] = 2;
                             }
                                 
                         }
                         
                         if(!$es_primero && $equipos[3]->get_puntos() > $segundo->get_puntos()){
                             
                             if($equipos[3]->get_puntos() == $segundo->get_puntos()){
                             
                                if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[3]->get_id_equipo()) >= PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo())){
        
                                     if(PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $equipos[3]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_netos_transaction($coneccion, $segundo->get_id_equipo())){

                                         if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[3]->get_id_equipo()) > PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo())){

                                                $eliminados[] = $segundo;
                                                $segundo = $equipos[3];
                                                
                                                 if($iguales[$i] == 4)
                                                    $iguales[$i] = 2;
                                                
                                         }else{
                                             
                                             if(!$es_igual){
                                               
                                                 if(PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $equipos[3]->get_id_equipo()) == PartidoEquipoPersistencia::obtener_goles_favor_transaction($coneccion, $segundo->get_id_equipo())){
                                                 
                                                    if($equipos[3]->get_puntos_extra() >= $segundo->get_puntos_extra()){
                                                     
                                                        if($equipos[3]->get_puntos_extra() == $segundo->get_puntos_extra()){

                                                        $iguales[$i] += 1; 

                                                        }else{

                                                            $eliminados[] = $segundo;
                                                            $segundo = $equipos[3];

                                                            if($iguales[$i] == 4)
                                                                $iguales[$i] = 2;

                                                        }

                                                     } 

                                                 }
                                                 
                                             }
                                             
                                         }      

                                     }else{

                                        $eliminados[] = $segundo;
                                        $segundo = $equipos[3];
                                        
                                         if($iguales[$i] == 4)
                                            $iguales[$i] = 2;

                                    }


                                }
                                
                             }else{
                                    
                                    $eliminados[] = $segundo;
                                    $segundo = $equipos[3];
                                    
                                     if($iguales[$i] == 4)
                                        $iguales[$i] = 2;
                                    
                             }
                             
                         }else{
                             
                             $eliminados[] = $equipos[3]; 
                             
                         }
                    
                         $ganadores[] = $primero;
                         $ganadores[] = $segundo;
                         
                    }else{
                    
                        mysqli_rollback($coneccion);
                        throw new Exception("Los datos de este torneo han sido manipulados o est\xE1n imcompletos.Por favor comunicarse con el administrador de base de datos y desarrollador");
                    }
                }
                
                $estadisticas = true;
                
                for($i = 0; $i < count($iguales); $i++){
                    
                    $estadisticas = $estadisticas && $iguales[$i] <= 2;

                }
                
                if($estadisticas){
                
                    for($i = 0; $i < count($ganadores); $i+=4){

                        PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $ganadores[$i]->get_id_equipo(), $segunda_fase[$i / 2]->get_id_partido() ,"0","0");
                        PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $ganadores[$i + 3]->get_id_equipo(), $segunda_fase[$i / 2]->get_id_partido() ,"0","0");

                        PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $ganadores[$i + 2]->get_id_equipo(), $segunda_fase[($i / 2) + 1]->get_id_partido() ,"0","0");
                        PartidoEquipoPersistencia::agregar_partido_equipo_transaction($coneccion, $ganadores[$i + 1]->get_id_equipo(), $segunda_fase[($i / 2) + 1]->get_id_partido() ,"0","0");
                    }

                    for($i = 0; $i < count($eliminados); $i++){

                        EquipoPersistencia::marcar_eliminado_transaction($coneccion, $eliminados[$i]->get_id_equipo());

                    }


                    TorneoPersistencia::cambiar_fase_transaction($coneccion, $torneo->get_id_torneo());
                    $torneo->set_fase("2");
                
                }else{
                    
                    echo "<script type=\"text/javascript\">alert('Hay m\xE1s de dos equipo o dos equipo en segundo lugar con las mismas estad\xEDsticas (puntos, goles netos y goles a favor). No se pueden determinar equipos ganadores.');</script>";
                    
                }
                
                mysqli_commit($coneccion);
                
            }else{
            
                echo "<script type=\"text/javascript\">alert('No se han jugado todos los partidos de la primera fase');</script>";
               
           }            
     }    
}

abrir_torneo($torneo);
concluir_primera_fase($torneo);
finalizar_torneo($torneo);

$cancelado = ($torneo->get_estado() == 4);
$finalizado = ($torneo->get_estado() == 3);

?>
