<?php

require_once 'BL/Persistencia/TorneoPersistencia.php';

$pagina = "index";
$titulo = "Torneos";
$url = "";
$reglamento = false;

$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";

function listar_torneos(&$foot){
    
    try{
    
        $torneos = TorneoPersistencia::listar_torneo();
        $par = "";

        for($i=0; $i < count($torneos); $i++){

            $estado = "";
            $par = (($foot = (($i % 2) != 0))?"row_par":"row_impar");


            switch ($torneos[$i]->get_estado()){

                case 1:
                    $estado = "Abierto";
                    break;

                case 2:
                    $estado = "En curso";
                    break;

                case 3:
                    $estado = "Finalizado";
                    break;

                case 4:
                    $estado = "Cancelado";
                    break;
            } 


            echo "<div title=\"Ir a torneo\" class=\"" . $par . "\" " . (($torneos[$i]->get_estado() != 4)?"onclick=\"torneo_click('" . $torneos[$i]->get_id_torneo() . "');\"":"") . ">".PHP_EOL;

            echo "    <h3 class=\"torneo\">" . $torneos[$i]->get_nombre_torneo() . "</h3>".PHP_EOL;
            echo "    <h3 class=\"estado\">" . $estado . "</h3>".PHP_EOL;

            echo "</div>".PHP_EOL;

        }
    
    }catch(Exception $ex){

        echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

    }
    
    
}

?>
