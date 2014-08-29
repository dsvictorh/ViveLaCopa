<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";
require_once "BL/Persistencia/PartidoEquipoPersistencia.php";

$pagina = "puntos";
$titulo = "Puntos";

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
    
        for($i=0;$i < (8/4); $i++){

            echo "<div class=\"head_puntos\">".PHP_EOL;

            echo "  <h1>Grupo " . ($i + 1) . "</h1>".PHP_EOL;    
            echo "  <div>".PHP_EOL;

            echo "      <h2 class=\"equipo\">Equipo</h2>".PHP_EOL;
            echo "      <h2 class=\"goles_favor\">GF</h2>".PHP_EOL;
            echo "      <h2 class=\"goles_contra\">GC</h2>".PHP_EOL;
            echo "      <h2 class=\"puntos\">Puntos</h2>".PHP_EOL;
            echo "      <div class=\"clear\"></div>".PHP_EOL;

            echo "  </div>".PHP_EOL;

            echo "</div>".PHP_EOL;
            
            $par = true;

            foreach(EquipoPersistencia::buscar_grupo($id_torneo, ($i+1)) as $equipo){
                
                $par = !$par;

                echo "    <div " . (($par)?"class=\"par\"":"") . ">".PHP_EOL;

                echo "       <h3 class=\"equipo\">" . $equipo->get_nombre() . "</h3>".PHP_EOL;
                echo "       <h3 class=\"goles_favor\">" . (number_format(PartidoEquipoPersistencia::obtener_goles_favor($equipo->get_id_equipo()), 0)) . "</h3>".PHP_EOL;
                echo "       <h3 class=\"goles_contra\">" . (number_format(PartidoEquipoPersistencia::obtener_goles_contra($equipo->get_id_equipo()), 0)) . "</h3>".PHP_EOL;
                echo "       <h3 class=\"puntos\">" . $equipo->get_puntos() . "</h3>".PHP_EOL;

                echo "   </div>".PHP_EOL;

            }

        }
    
    }catch(Exception $ex){
        
        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
        
    }
    
}

?>
