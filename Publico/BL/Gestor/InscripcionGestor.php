<?php

require_once "BL/Persistencia/TorneoPersistencia.php";
require_once "BL/Persistencia/EquipoPersistencia.php";
require_once "BL/Persistencia/JugadorPersistencia.php";

$pagina = "inscripcion";
$titulo = "Inscripcion";



$recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";

if(($torneo = TorneoPersistencia::buscar_torneo(isset($_REQUEST["id_torneo"])?$_REQUEST["id_torneo"]:"0")) == NULL){
    
    header("Location: index.php");
    exit();
    
}


if($torneo->get_estado() != 1){
    
    header("Location: index.php");
    exit();
    
}


$url = "torneo.php?id_torneo=" . $torneo->get_id_torneo();
$reglamento = true;

function inscribir_equipo($id_torneo){
    
    if(isset($_POST["btn_inscribir_x"])){
    
        $inscribir = true;
        
        if((isset($_POST["txt_equipo"])?$_POST["txt_equipo"]:"") == ""){

            echo "<script type=\"text/javascript\">alert('El Nombre del equipo es requerido');</script>";
            $inscribir = false;

        }else if(preg_match($GLOBALS["novalidos"], $_POST["txt_equipo"]) && $inscribir){

            echo "<script type=\"text/javascript\">alert('No se permiten caracteres especiales en el nombre del equipo');</script>";
            $inscribir = false;

        }else if(strlen($_POST["txt_equipo"]) > 20 && $inscribir){

            echo "<script type=\"text/javascript\">alert('El nombre del equipo no puede tener m\xE1s de 20 caracteres');</script>";
            $inscribir = false;

        }

        if(!isset($_POST["chk_reglamento"]) && $inscribir){
            
            echo "<script type=\"text/javascript\">alert('El equipo debe aceptar el reglamento');</script>";
            $inscribir = false;
            
        }

        if($inscribir){

            $jugadores = explode("|", isset($_POST["jugadores"])?$_POST["jugadores"]:"");
            
            if(count($jugadores) > 4 && $_POST["jugadores"] != ""){

                try{

                    $coneccion = Coneccion::conectar();
                    mysqli_autocommit($coneccion, false);
                    
                    if(EquipoPersistencia::buscar_equipo_por_nombre($_POST["txt_equipo"], $id_torneo) == NULL){

                        $id_equipo = EquipoPersistencia::agregar_equipo_transaction($coneccion, $_POST["txt_equipo"], $id_torneo);

                        for($i = 0; $i < count($jugadores) - 1; $i++){

                            $jugador = explode(";", $jugadores[$i]);

                            if(count($jugador) != 5){

                                mysqli_rollback($coneccion);
                                throw new Exception("Los datos de los jugadores han sido manipulados. Por favor reingrese a la p\xE1gina.");

                            } 

                            JugadorPersistencia::agregar_jugador_transaction($coneccion, $jugador[0], $jugador[1], $jugador[2], $jugador[4], $jugador[3], $id_equipo);

                        }

                        mysqli_commit($coneccion);

                        unset($_POST["txt_equipo"]);
                        unset($_POST["jugadores"]);

                        echo "<script type=\"text/javascript\">alert('El equipo ha sido agregado a la lista. Este ser\xE1 aprobado por el administrador una vez cancelado el precio del torneo');</script>";
                    
                    }else{
                        
                        echo "<script type=\"text/javascript\">alert('Este nombre de equipo ya est\xE1 siendo usado en este torneo');</script>";
                        
                    }

                }catch(Exception $ex){

                    echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

                }

            }else{

                echo "<script type=\"text/javascript\">alert('No hay suficientes jugadores en el equipo');</script>";

            }
        
        }
        
    }
    
}

inscribir_equipo($torneo->get_id_torneo());

$body = "onload=\"guardar_correos('" . JugadorPersistencia::obtener_correos_por_torneo($torneo->get_id_torneo())  . "'); retrieve_jugadores('" . (isset($_POST["jugadores"])?$_POST["jugadores"]:"") . "');\"";
$texto = $torneo->get_reglamento();

?>
