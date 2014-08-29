<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/JugadorPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";

$pagina = "goleadores";
$titulo = "Goleadores";

if(($torneo = TorneoPersistencia::buscar_torneo(isset($_REQUEST["id_torneo"])?$_REQUEST["id_torneo"]:"0")) == NULL){
    
    header("Location: index.php");
    exit();
    
}

if($torneo->get_estado() == 4){
    
    header("Location: index.php");
    exit();
    
}


$url = "torneo.php?id_torneo=" . $torneo->get_id_torneo();
$reglamento = false;


function pintar_goleadores($id_torneo){
    
    try{
            $par = true;

            foreach(JugadorPersistencia::buscar_goleadores($id_torneo) as $jugador){
                
                $par = !$par;

                echo "    <div " . (($par)?"class=\"par\"":"") . ">".PHP_EOL;

                echo "       <h3 class=\"equipo\">" . EquipoPersistencia::buscar_equipo($jugador->get_id_equipo())->get_nombre() . "</h3>".PHP_EOL;
                echo "       <h3 class=\"jugador\">" . $jugador->get_nombre() . " " . $jugador->get_apellido() . "</h3>".PHP_EOL;
                echo "       <h3 class=\"goles\">" . (number_format($jugador->get_goles(), 0)) . "</h3>".PHP_EOL;

                echo "   </div>".PHP_EOL;

            }
            
            echo "<div  class=\"goleadores " . (($par)?"par":"") . "\"></div>".PHP_EOL;
            
            
    }catch(Exception $ex){
        
        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";
        
    }
    
}

?>
