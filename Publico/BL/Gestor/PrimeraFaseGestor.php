<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";
require_once "BL/Persistencia/PartidoEquipoPersistencia.php";
require_once "BL/Persistencia/PartidoPersistencia.php";

$pagina = "primera_fase";
$titulo = "1&deg; Fase";

$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";

if(($torneo = TorneoPersistencia::buscar_torneo(isset($_REQUEST["id_torneo"])?$_REQUEST["id_torneo"]:"0")) == NULL){
    
    header("Location: index.php");
    exit();
    
}

if($torneo->get_estado() == 4 || $torneo->get_numero_fases() == 1){
    
    header("Location: index.php");
    exit();
    
}

$url = "torneo.php?id_torneo=" . $torneo->get_id_torneo();
$reglamento = false;


function pintar_grupos($id_torneo){
    
    try{
        
        $partidos = PartidoPersistencia::listar_partido_primera_fase($id_torneo);
       
        for($i=0;$i < (8/4) ;$i++){
        
            echo "<div class=\"head\">".PHP_EOL;

            echo "     <h1>Grupo " . ($i + 1) . "</h1>".PHP_EOL;
            echo "     <div>".PHP_EOL;

            echo "        <h2 class=\"primera_fase_grupo titulo\">vrs</h2>".PHP_EOL;
            echo "        <div class=\"clear\"></div>".PHP_EOL;

            echo "     </div>".PHP_EOL;

            echo "  </div>".PHP_EOL;

            $par = true;

            for($j=0; $j < 6; $j++){

                $par = !$par;
                $partido_equipo = PartidoEquipoPersistencia::listar_partido_equipo($partidos[($j + ($i * 6))]->get_id_partido());
                $equipo_uno = EquipoPersistencia::buscar_equipo(count(($partido_equipo) > 0)?$partido_equipo[0]->get_id_equipo():"0");
                $equipo_dos = EquipoPersistencia::buscar_equipo(count(($partido_equipo) > 1)?$partido_equipo[1]->get_id_equipo():"0");
                

                echo "    <div onclick=\"block_descripcion_partido('" .$partidos[($j + ($i * 6))]->get_detalle() . "', '" .$partidos[($j + ($i * 6))]->get_numero_cancha() . "', '', event, false);\" onmouseover=\"mostrar_descripcion_partido('" .$partidos[($j + ($i * 6))]->get_detalle() . "', '" .$partidos[($j + ($i * 6))]->get_numero_cancha() . "', '', event, false);\" onmouseout=\"esconder_descripcion_partido();\" " . "class=\"select" . (($par)?" par":"") . "\">".PHP_EOL;

                echo "       <h3 class=\"equipo_primera_fase\">" . (($equipo_uno != NULL)?$equipo_uno->get_nombre():"") . "</h3>".PHP_EOL;
                echo "       <h3 class=\"goles_partido\">" . ((count($partido_equipo) > 0 && $partidos[($j + ($i * 6))]->get_jugado() != 0)?number_format($partido_equipo[0]->get_goles_favor(), 0):"") . "</h3>".PHP_EOL;
                echo "       <h3 class=\"fecha\">" . (strftime("%A %d de %B, %Y", strtotime($partidos[($j + ($i * 6))]->get_fecha())) . " " . $partidos[($j + ($i * 6))]->get_hora_formateada()) . "</h3>".PHP_EOL;
                echo "       <h3 class=\"equipo_primera_fase\">" . (($equipo_dos != NULL)?$equipo_dos->get_nombre():"") . "</h3>".PHP_EOL;
                echo "       <h3 class=\"goles_partido\">" . ((count($partido_equipo) > 1  && $partidos[($j + ($i * 6))]->get_jugado() != 0)?number_format($partido_equipo[1]->get_goles_favor(), 0):"") . "</h3>".PHP_EOL;
                
                echo "   </div>".PHP_EOL;

            }

            echo "<div  class=\"primera_fase\"></div>".PHP_EOL;
            echo "<div class=\"clear\"></div>".PHP_EOL;

        }

            
    }catch(Exception $ex){
        
        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
        
    }
    
}

?>
