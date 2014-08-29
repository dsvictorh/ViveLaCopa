<?php

require_once 'BL/Persistencia/EquipoPersistencia.php';
require_once 'BL/Persistencia/PartidoEquipoPersistencia.php';
require_once 'BL/Persistencia/JugadorPersistencia.php';

$partidos = PartidoEquipoPersistencia::listar_partido_equipo(isset($_REQUEST["partido"])?$_REQUEST["partido"]:"0");

function pintar_equipo($id_equipo){
    
    if(($equipo = EquipoPersistencia::buscar_equipo($id_equipo)) != NULL){
        
        $jugadores = JugadorPersistencia::listar_jugador($equipo->get_id_equipo());
        
        echo "<tr>".PHP_EOL;

        echo "    <th class=\"equipo izquierda\">" . $equipo->get_nombre() . "</th>".PHP_EOL;
        echo "    <th>Goles</th>".PHP_EOL;
        echo "    <th>Amarillas</th>".PHP_EOL;
        echo "    <th>Rojas</th>".PHP_EOL;

        echo "</tr>".PHP_EOL;
        
        for($i = 0; $i < count($jugadores); $i++){
            
            echo "<tr>".PHP_EOL;

            echo "    <td class=\"izquierda\">" . $jugadores[$i]->get_nombre() . " " . $jugadores[$i]->get_apellido() . "</td>".PHP_EOL;
            echo "    <td class=\"borde\"></td>".PHP_EOL;
            echo "    <td class=\"borde\"></td>".PHP_EOL;
            echo "    <td class=\"borde\"></td>".PHP_EOL;

            echo "</tr>".PHP_EOL;
            
            
        }
       
        
        
    }
    
    
}


?>

<!DOCTYPE html>
<html>

    <head>
        
        <?php setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); ?>
       <title>Vive la Copa - Impresi&oacute;n de Partido</title> 
       <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
       <link rel="stylesheet" href="recursos/css/impresion.css" />

    </head>

    <body>

        <div>

            <table>

                 <?php pintar_equipo((count($partidos) > 0)?$partidos[0]->get_id_equipo():"0"); ?>

            </table>

            <table>

                <?php pintar_equipo((count($partidos) > 1)?$partidos[1]->get_id_equipo():"0"); ?>

            </table>

        </div>

    </body>
	
	
</html>
