<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";
require_once "BL/Persistencia/PartidoEquipoPersistencia.php";
require_once "BL/Persistencia/PartidoPersistencia.php";

$pagina = "segunda_fase";
$titulo = "2&deg; Fase";

$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";

if(($torneo = TorneoPersistencia::buscar_torneo(isset($_REQUEST["id_torneo"])?$_REQUEST["id_torneo"]:"0")) == NULL){
    
    header("Location: index.php");
    exit();
    
}

if($torneo->get_estado() == 4 && $torneo->get_fase() == 1){
    
    header("Location: index.php");
    exit();
    
}

$url = "torneo.php?id_torneo=" . $torneo->get_id_torneo();
$reglamento = false;

function pintar_llave($torneo){
    
    switch ((8/$torneo->get_numero_fases())){
        
        
        case 4: 
            pintar_llave_cuatro($torneo->get_id_torneo());
            break;
        
        case 8:
            pintar_llave_ocho($torneo->get_id_torneo());
            break;
        
    }
    
}

function pintar_llave_cuatro($id_torneo){
    
    $partidos = PartidoPersistencia::listar_partido_segunda_fase($id_torneo);
    $tercer_mejor = PartidoPersistencia::buscar_partido_tercer_mejor($id_torneo);
    $final = PartidoPersistencia::buscar_partido_final($id_torneo);
    
    if(count($partidos) == 2 && $tercer_mejor != NULL && $final != NULL){
    
        $partido_uno = PartidoEquipoPersistencia::listar_partido_equipo($partidos[0]->get_id_partido());
        $partido_dos = PartidoEquipoPersistencia::listar_partido_equipo($partidos[1]->get_id_partido());
        
        echo "<div id=\"llave_cuatro\">".PHP_EOL;
        echo "  <div id=\"llave\">".PHP_EOL;
        echo "      <div class=\"equipo\">".PHP_EOL;
        
        if(count($partido_uno) == 2 && count($partido_dos) == 2){
            
            pintar_partido($partidos[0], $partido_uno[0]);
            pintar_partido($partidos[1], $partido_dos[0]);
        
        }
        
        echo "      </div>".PHP_EOL;
        echo "      <div class=\"medio\"></div>".PHP_EOL;
        echo "      <div class=\"equipo\">".PHP_EOL;
        
        $partido_final = PartidoEquipoPersistencia::listar_partido_equipo($final->get_id_partido());
        
        if(count($partido_final) == 2){
            
            echo "          <div class=\"centro\">".PHP_EOL;
            
            pintar_partido($final, $partido_final[0]);
            pintar_partido($final, $partido_final[1]);
            
            echo "          </div>".PHP_EOL;
        
        }
        
        echo "      </div>".PHP_EOL;
        echo "      <div class=\"medio\"></div>".PHP_EOL;
        echo "      <div class=\"equipo\">".PHP_EOL;
        
        
        
        if(count($partido_uno) == 2 && count($partido_dos) == 2){
            
            pintar_partido($partidos[0], $partido_uno[1]);
            pintar_partido($partidos[1], $partido_dos[1]);
        
        }
        
        echo "      </div>".PHP_EOL;
        echo "      <div class=\"equipo\">".PHP_EOL;
        
        $partido_tercer_mejor = PartidoEquipoPersistencia::listar_partido_equipo($tercer_mejor->get_id_partido());
        
        if(count($partido_tercer_mejor) == 2){
            
            echo "          <div class=\"centro\">".PHP_EOL;
            
            pintar_partido($tercer_mejor, $partido_tercer_mejor[0]);
            pintar_partido($tercer_mejor, $partido_tercer_mejor[1]);
            
            echo "          </div>".PHP_EOL;
        
        }
        
        echo "      </div>".PHP_EOL;
        echo "  </div>".PHP_EOL;

        echo "</div>".PHP_EOL;
        
    }     
}

function pintar_llave_ocho($id_torneo){
    
    $partidos = PartidoPersistencia::listar_partido_segunda_fase($id_torneo);
    $tercer_mejor = PartidoPersistencia::buscar_partido_tercer_mejor($id_torneo);
    $final = PartidoPersistencia::buscar_partido_final($id_torneo);
    
    if(count($partidos) == 6 && $tercer_mejor != NULL && $final != NULL){
    
        $partido_uno = PartidoEquipoPersistencia::listar_partido_equipo($partidos[0]->get_id_partido());
        $partido_dos = PartidoEquipoPersistencia::listar_partido_equipo($partidos[1]->get_id_partido());
        $partido_tres = PartidoEquipoPersistencia::listar_partido_equipo($partidos[2]->get_id_partido());
        $partido_cuatro = PartidoEquipoPersistencia::listar_partido_equipo($partidos[3]->get_id_partido());
        $partido_cinco = PartidoEquipoPersistencia::listar_partido_equipo($partidos[4]->get_id_partido());
        $partido_seis = PartidoEquipoPersistencia::listar_partido_equipo($partidos[5]->get_id_partido());
        
        echo "<div id=\"llave_ocho\">".PHP_EOL;

        echo "  <div id=\"llave\">".PHP_EOL;

        echo "      <div class=\"equipo_arriba\">".PHP_EOL;
        
        pintar_partido($partidos[0], $partido_uno[0]);
        pintar_partido($partidos[2], $partido_tres[0]);
                  

        echo "      </div>".PHP_EOL;
        
        echo "      <div class=\"equipo_medio\">".PHP_EOL;

        echo "          <div class=\"semi_centro\">".PHP_EOL;

        pintar_partido($partidos[4], $partido_cinco[0]);
        pintar_partido($partidos[5], $partido_seis[0]);

        echo "          </div>".PHP_EOL;

        echo "      </div>".PHP_EOL;
        
        echo "      <div class=\"equipo_abajo\">".PHP_EOL;

        pintar_partido($partidos[0], $partido_uno[1]);
        pintar_partido($partidos[2], $partido_tres[1]);

        echo "      </div>".PHP_EOL;
        
        $partido_final = PartidoEquipoPersistencia::listar_partido_equipo($final->get_id_partido());
        
        echo "      <div class=\"equipo_final\">".PHP_EOL;

        echo "          <div class=\"centro\">".PHP_EOL;

        pintar_partido($final, $partido_final[0]);
        pintar_partido($final, $partido_final[1]);

        echo "          </div>".PHP_EOL;

        echo "      </div>".PHP_EOL;
                
        echo "      <div class=\"equipo_arriba\">".PHP_EOL;

        pintar_partido($partidos[1], $partido_dos[0]);
        pintar_partido($partidos[3], $partido_cuatro[0]);

        echo "      </div>".PHP_EOL;
        
        echo "      <div class=\"equipo_medio\">".PHP_EOL;

        echo "          <div class=\"semi_centro\">".PHP_EOL;

        pintar_partido($partidos[4], $partido_cinco[1]);
        pintar_partido($partidos[5], $partido_seis[1]);

        echo "          </div>".PHP_EOL;

        echo "      </div>".PHP_EOL;
        
        $partido_tercer_mejor = PartidoEquipoPersistencia::listar_partido_equipo($tercer_mejor->get_id_partido());
        
        echo "      <div class=\"equipo_tercer_mejor\">".PHP_EOL;
        
        pintar_partido($partidos[1], $partido_dos[1]);
        pintar_partido($tercer_mejor, $partido_tercer_mejor[0], "segundo");
        pintar_partido($tercer_mejor, $partido_tercer_mejor[1], "tercero");
        pintar_partido($partidos[3], $partido_cuatro[1]);

        echo "      </div>".PHP_EOL;

        echo "  </div>".PHP_EOL;

        echo "</div>".PHP_EOL;
    
    }
        
}

function pintar_partido($partido, $partido_equipo, $clase = ""){
    
    echo "              <div onclick=\"block_descripcion_partido('" .$partido->get_detalle() . "', '" . $partido->get_numero_cancha() . "', '" . strftime("%d/%m/%Y", strtotime($partido->get_fecha())) . " " . $partido->get_hora_formateada() . "', event, true);\" onmouseover=\"mostrar_descripcion_partido('" .$partido->get_detalle() . "', '" .$partido->get_numero_cancha() . "', '" . strftime("%d/%m/%Y", strtotime($partido->get_fecha())) . " " . $partido->get_hora_formateada() . "', event, true);\" onmouseout=\"esconder_descripcion_partido();\" class=\"box " . $clase . "\">".PHP_EOL; 
    
    if($partido_equipo != null){
    
        echo "                  <p>" . EquipoPersistencia::buscar_equipo($partido_equipo->get_id_equipo())->get_nombre() . "</p>".PHP_EOL;
        echo "                  <p>" . str_replace(".0", "", $partido_equipo->get_goles_favor()) . "</p>".PHP_EOL;

    }
    
    echo "              </div>".PHP_EOL;
    
}

?>
