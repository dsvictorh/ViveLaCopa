<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";

$pagina = "grupos";
$titulo = "Grupos";

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

            echo "<div>".PHP_EOL;
            echo " <h3>Grupo " . ($i + 1) . "</h3>".PHP_EOL;                     
            echo "     <div>".PHP_EOL;

            foreach(EquipoPersistencia::buscar_grupo($id_torneo, ($i+1)) as $equipo){

                echo "             <span>" . $equipo->get_posicion() . "- " . $equipo->get_nombre() . "</span>".PHP_EOL;

            }

            echo "      </div>".PHP_EOL;
            echo "</div>".PHP_EOL;            

        }
    
    }catch(Exception $ex){
        
      echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";  
        
    }
    
    
}

?>
