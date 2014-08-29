<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    
        <?php setlocale(LC_ALL,"es_ES@euro","es_ES","esp"); ?>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <meta name="robots" content="index/follow" />
        <meta name="description" content="Vive La Copa - Torneos de futbol de Costa Rica." />
        <meta name="keywords" content="vive la copa, torneos costa rica, futbol cinco, futbol 5, futbol costa rica, futbol, torneos de futbol, torneo nacional, campeonato de futbol, campeonato, torneo, torneos" />
        <link rel="shortcut icon" href="recursos/img/layout/logo.ico" />
        <link rel="stylesheet" href="recursos/css/estilos.css" />
        
        <?php
        
            function pintar_menu_banner($url, $reglamento, $texto){
                
                if($url != ""){
                    
                    echo "<ul>".PHP_EOL;
                    
                    if($reglamento){

                        echo "     <li>".PHP_EOL;
                        echo "        <input type=\"hidden\" name=\"reglamento\" value=\"" . ((isset($texto))?str_replace("\n", "\\n", $texto):"") . "\" />".PHP_EOL;
                        echo "         <a onclick=\"mostrar_reglamento();\"><img src =\"recursos/img/layout/reglamento.png\" alt=\"Reglamento\" title=\"Reglamento\" />".PHP_EOL;
                        echo "         <span>Reglamento</span></a>".PHP_EOL;
                        echo "     </li>".PHP_EOL;

                    }
                    
                    echo "    <li>".PHP_EOL;                
                    echo "        <a href=\"" . $url . "\"><img src =\"recursos/img/layout/regresar.png\" alt=\"Regresar\" title=\"Regresar\" />".PHP_EOL;
                    echo "        <span>Regresar</span></a>".PHP_EOL;
                    echo "    </li>".PHP_EOL;

                    echo " </ul> ".PHP_EOL;   
                }
                
            }
        
        ?>

        
      