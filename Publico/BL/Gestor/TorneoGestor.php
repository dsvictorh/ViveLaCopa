<?php

require_once "BL/Persistencia/TorneoPersistencia.php";

$pagina = "torneo";
$url = "";
$reglamento = false;

if(($torneo = TorneoPersistencia::buscar_torneo(isset($_REQUEST["id_torneo"])?$_REQUEST["id_torneo"]:"0")) == NULL){
    
    header("Location: index.php");
    exit();
    
}

if($torneo->get_estado() == 4){
    
    header("Location: index.php");
    exit();
    
}

$titulo = $torneo->get_nombre_torneo();
?>
