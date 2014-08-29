<?php

require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/PartidoPersistencia.php';
require_once 'BL/Persistencia/ConfiguracionPersistencia.php';

    
    if(!revisar_usuario() || $_SESSION["tipo"] != "0"){
    
        $_SESSION["test_session"] = true;
        header("Location: error.php");
        exit();
        
    }
    
    $pagina = "torneos";
    $recursos = "<link rel=\"stylesheet\" type=\"text/css\"  href=\"recursos/css/datepicker.css\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/jquery.js\"></script>"
                 .PHP_EOL
                 ."<script type=\"text/javascript\" src=\"recursos/js/datepicker.js\"></script>";
    $check = isset($_POST["chk_filtro"])?$_POST["chk_filtro"]:"activo";
    $load = "onLoad=\"cargar_torneos('". $check ."', '".(isset($_POST["chk_fases"])?$_POST["chk_fases"]:"1")."')\";";
   
    function validar_datos(){
       
        //1 - Incompleto
        //2 - Caracteres Especiales
        //3 - Fecha no valida
        //4 - Precio no es numero
        //5 - Fecha inicio mayor
        
        $valido = 0;
        $valido = ($valido == 0)?(isset($_POST["txt_torneo"])?$_POST["txt_torneo"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_fecha_inicio"])?$_POST["txt_fecha_inicio"]:"") != ""
            ?(preg_match($GLOBALS["fecha"], $_POST["txt_fecha_inicio"]))
            ?0:3:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_fecha_fin"])?$_POST["txt_fecha_fin"]:"") != ""
            ?(preg_match($GLOBALS["fecha"], $_POST["txt_fecha_fin"]))
            ?0:3:1:$valido;
        
        $valido = ($valido == 0)?strtotime($_POST["txt_fecha_inicio"]) < strtotime($_POST["txt_fecha_fin"])?0:5:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_torneo_detalle"])?$_POST["txt_torneo_detalle"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo_detalle"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_torneo_detalle"])?$_POST["txt_torneo_detalle"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_torneo_detalle"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_precio"])?$_POST["txt_precio"]:"") != ""
            ?(preg_match($GLOBALS["numero"], $_POST["txt_precio"]))
            ?0:4:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_precio_detalle"])?$_POST["txt_precio_detalle"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_precio_detalle"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_primer_premio"])?$_POST["txt_primer_premio"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_primer_premio"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_segundo_premio"])?$_POST["txt_segundo_premio"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_segundo_premio"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_tercer_premio"])?$_POST["txt_tercer_premio"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_tercer_premio"]))
            ?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["chk_fases"])?0:1):$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_reglamento"])?$_POST["txt_reglamento"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_reglamento"]))
            ?2:0:1:$valido;
        
        return $valido;
        
    }
    
    function error($error){
        
        $mensaje = "";
        
        switch ($error){
        
            case 1:
                $mensaje = "Datos Incompletos";
                break;
            
            case 2:
                $mensaje = "No se permiten caracteres especiales";
                break;
            
            case 3:
                $mensaje = "Formato de fecha no v&aacute;lido";
                break;
            
            case 4:
                $mensaje = "El precio debe ser un n&uacute;mero";
                break;  
            
            case 5:
                $mensaje = "La fecha de inicio debe ser menor a la fecha de fin";
                break;
            
        }
        
        return $mensaje;
        
        
    }
    
    function listar_torneos($check){
        
        try{
        
            if($check == "activo"){

                listar_torneos_activos($check);

            }else{

                listar_torneos_cancelados($check);

            }
        
        }catch(Exception $ex){

            echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }
    }
    
    function listar_torneos_activos($check){
         
        $torneo = new Torneo();
        $torneos = array();
        $torneos = TorneoPersistencia::listar_torneo_activo(isset($_POST["txt_busqueda"])?preg_replace($GLOBALS["novalidos"], "", $_POST["txt_busqueda"]):"");
        
        for($i = 0; $i < count($torneos); $i++){
            
            $torneo = $torneos[$i];
            
            $estado = "";
            switch ($torneo->get_estado()){
                
                case 1:
                    $estado = "Abierto";
                    break;
                
                case 2:
                    $estado = "En curso";
                    break;
                
                case 3:
                    $estado = "Finalizado";
                    break;
                
                default:
                    $estado = "";
                    break;
            }
           
            $ultimo_izq = $i == (count($torneos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($torneos)-1)?!($i % 2 == 0)?" ultimo_der":"":"";

            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $torneo->get_nombre_torneo() . "</td>".PHP_EOL;
            echo "  <td>" . $estado . "</td>".PHP_EOL;
            echo "  <td>" . strftime("%A %d de %B %Y", strtotime($torneo->get_fecha_inicio())) . "</td>".PHP_EOL;
            echo "  <td>" . strftime("%A %d de %B %Y", strtotime($torneo->get_fecha_fin())) . "</td>".PHP_EOL;
            echo "  <td>" . (($torneo->get_fase() == "1")?"Grupos":"Llave") . "</td>".PHP_EOL;
            echo "  <td>" . $torneo->get_numero_fases() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"torneo_ir\" autocomplete=\"off\" action=\"torneo.php\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_ir\" src=\"recursos/img/ir.png\" title=\"Ir\" alt=\"Ir\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo ->get_id_torneo() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            echo "      <form name=\"torneo_cancelar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_cancelar\" src=\"recursos/img/cancelar.png\" onClick=\"return confirmar('Desea cancelar este torneo?');\" title=\"Cancelar\" alt=\"Cancelar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo ->get_id_torneo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    }
    
    function listar_torneos_cancelados($check){
         
        $torneo = new Torneo();
        $torneos = array();
        $torneos = TorneoPersistencia::listar_torneo_cancelado(isset($_POST["txt_busqueda"])?preg_replace($GLOBALS["novalidos"], "", $_POST["txt_busqueda"]):"");
        
        for($i = 0; $i < count($torneos); $i++){
            
            $torneo = $torneos[$i];
            
            $estado = $torneo->get_estado() == 4?"Cancelado":"";
            
            $ultimo_izq = $i == (count($torneos)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($torneos)-1)?!($i % 2 == 0)?" ultimo_der":"":"";
            
            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $torneo->get_nombre_torneo() . "</td>".PHP_EOL;
            echo "  <td>" . $estado . "</td>".PHP_EOL;
            echo "  <td>" . strftime("%A %d de %B %Y", strtotime($torneo->get_fecha_inicio())) . "</td>".PHP_EOL;
            echo "  <td>" . strftime("%A %d de %B %Y", strtotime($torneo->get_fecha_fin())) . "</td>".PHP_EOL;
            echo "  <td>" . (($torneo->get_fase() == "1")?"Grupos":"Llave") . "</td>".PHP_EOL;
            echo "  <td>" . $torneo->get_numero_fases() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"torneo_restaurar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_restaurar\" src=\"recursos/img/restaurar.png\" title=\"Restaurar\" alt=\"Restaurar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo ->get_id_torneo() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            echo "      <form name=\"torneo_eliminar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_eliminar\" onClick=\"return confirmar('Este torneo ser&aacute; permanentemente eliminado. Desea proseguir?');\"  src=\"recursos/img/eliminar.png\" title=\"Eliminar\" alt=\"Eliminar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo ->get_id_torneo() . "\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    }
    
    function mostrar_detalles($agregar, $check){
        
        if(isset($_POST["btn_agregar_x"]) || $agregar != 0){
            
           echo "<div>".PHP_EOL;
                 
           echo "   <form name=\"agregar_torneo\" autocomplete=\"off\" action=\"". $_SERVER["PHP_SELF"]."\" method=\"post\">".PHP_EOL;
           
           echo "     <table id=\"agregar_torneo\">".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td class=\"derecha\">Nombre:</td>".PHP_EOL;
           echo "             <td><input type=\"text\" maxlength=\"50\" name=\"txt_torneo\" value=\"" . (isset($_POST["txt_torneo"])?$_POST["txt_torneo"]:"") . "\" /></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Precio (&cent;):</td>".PHP_EOL;
           echo "             <td><input type=\"text\" name=\"txt_precio\"  value=\"" . (isset($_POST["txt_precio"])?$_POST["txt_precio"]:"") . "\" /></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Reglamento:</td>".PHP_EOL;
           echo "             <td rowspan=\"5\"><textarea id=\"txt_reglamento\" name=\"txt_reglamento\">" . (isset($_POST["txt_reglamento"])?$_POST["txt_reglamento"]:ConfiguracionPersistencia::buscar_reglamento_sin_id()) . "</textarea></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td class=\"derecha\">Inicio:</td>".PHP_EOL;
           echo "             <td><input type=\"text\" id=\"txt_fecha_inicio\"  readonly=\"true\" class=\"date\" onclick=\"enableDatePicker('txt_fecha_inicio', this);\" name=\"txt_fecha_inicio\" readonly=\"true\"  value=\"" . (isset($_POST["txt_fecha_inicio"])?$_POST["txt_fecha_inicio"]:date("m/d/Y")) . "\" /> </td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\"></td>".PHP_EOL;
           echo "             <td rowspan=\"2\"><textarea name=\"txt_precio_detalle\" maxlength=\"200\" id=\"txt_precio_detalle\">" . (isset($_POST["txt_precio_detalle"])?$_POST["txt_precio_detalle"]:"" ). "</textarea></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td class=\"derecha\">Fin:</td>".PHP_EOL;
           echo "             <td> <input type=\"text\" id=\"txt_fecha_fin\"  readonly=\"true\" class=\"date\" onclick=\"enableDatePicker('txt_fecha_fin', this);\" name=\"txt_fecha_fin\" readonly=\"true\"  value=\"" . (isset($_POST["txt_fecha_fin"])?$_POST["txt_fecha_fin"]:date('m/d/Y', strtotime("1 months"))) . "\" /></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "        <tr>".PHP_EOL;
           echo "             <td class=\"derecha\">Detalles:</td>".PHP_EOL;
           echo "             <td rowspan=\"3\"><textarea name=\"txt_torneo_detalle\" id=\"txt_torneo_detalle\">" . (isset($_POST["txt_torneo_detalle"])?$_POST["txt_torneo_detalle"]:"" ). "</textarea></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Primer premio:</td>".PHP_EOL;
           echo "             <td><input type=\"text\" maxlength=\"200\" name=\"txt_primer_premio\" value=\"" . (isset($_POST["txt_primer_premio"])?$_POST["txt_primer_premio"]:"" ). "\" /></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Segundo premio:</td>".PHP_EOL;
           echo "             <td><input type=\"text\" maxlength=\"200\" name=\"txt_segundo_premio\" value=\"" . (isset($_POST["txt_segundo_premio"])?$_POST["txt_segundo_premio"]:"" ). "\" /></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Tercer premio:</td>".PHP_EOL;
           echo "             <td><input type=\"text\" maxlength=\"200\" name=\"txt_tercer_premio\" value=\"" . (isset($_POST["txt_tercer_premio"])?$_POST["txt_tercer_premio"]:"" ). "\" /></td>".PHP_EOL;
           echo "             <td class=\"spacer\"></td>".PHP_EOL;
           echo "             <td class=\"derecha\">Fases:</td>".PHP_EOL;
           echo "             <td class=\"izquierda\">".PHP_EOL;
           echo "                 <input type=\"radio\" id=\"chk_uno\"  name=\"chk_fases\"  value=\"1\">1</input>".PHP_EOL;
           echo "                 <input type=\"radio\" id=\"chk_dos\" name=\"chk_fases\" value=\"2\">2</input>".PHP_EOL;
           echo "             </td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "             <td></td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo "         <tr>".PHP_EOL;
           echo "             <td colspan=\"8\">".PHP_EOL;
           echo "                 <table id=\"boton_error\">".PHP_EOL;
           echo "                     <tr>".PHP_EOL;
           echo "                         <td class=\"error\">" . error($agregar) . "</td>".PHP_EOL;
           echo "                         <td class=\"derecha\">".PHP_EOL;
           echo "                                 <input type=\"image\" src=\"recursos/img/registrar.png\" title=\"Agregar torneo\" onclick=\"return confirmar('Al crear el torneo no se podr\\xe1 cambiar el n\\xfamero de fases. Desea registrar este torneo?');\" name=\"btn_agregar_torneo\" />".PHP_EOL;
           echo "                                 <input type=\"image\" src=\"recursos/img/cancelar_registrar.png\" title=\"Cancelar\" name=\"btn_cancelar_torneo\" />".PHP_EOL;
           echo "                                 <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
           echo "                         </td>".PHP_EOL;
           echo "                     </tr>".PHP_EOL;
           echo "                 </table>".PHP_EOL;
           echo "             </td>".PHP_EOL;
           echo "         </tr>".PHP_EOL;

           echo " </table>".PHP_EOL;
           
           echo " </form>".PHP_EOL;

         echo "</div>".PHP_EOL;
  
        }
    
    }
    
    function ocultar_detalle($agregar, $check){
        
        if(!isset($_POST["btn_agregar_x"])){
            
            if($agregar){
                
                echo " <div class=\"derecha\">".PHP_EOL;
                echo "    <form name=\"mostrar_detalle\" autocomplete=\"off\" action=\"" .  $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;   
                echo "        <input type=\"image\" src=\"recursos/img/agregar.png\" title=\"Agregar torneo\" name=\"btn_agregar\" />".PHP_EOL;
                echo "        <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
                echo "    </form>".PHP_EOL;
                echo " </div>".PHP_EOL;
            
            }
            
        }
        
    }
    
    function agregar(){
                
        if(isset($_POST["btn_agregar_torneo_x"])){
            
            if(($agregar = validar_datos()) == 0){
                
                 $coneccion = Coneccion::conectar();
                 mysqli_autocommit($coneccion, false);
                
                try{
                    

                    
                    $id = TorneoPersistencia::agregar_torneo_transaction($coneccion, $_POST["txt_torneo"], $_POST["txt_fecha_inicio"], $_POST["txt_fecha_fin"], $_POST["txt_torneo_detalle"], $_POST["txt_precio"], $_POST["txt_primer_premio"], $_POST["txt_segundo_premio"], $_POST["txt_tercer_premio"], $_POST["txt_precio_detalle"], (($_POST["chk_fases"] == "2")?"1":"2"), "1", $_POST["chk_fases"],$_POST["txt_reglamento"]);
            
                    if($_POST["chk_fases"] == "2"){
                    
                        for($i = 0;$i < (8 / 4);$i++){

                            for($j = 0;$j < 6;$j++){

                                PartidoPersistencia::agregar_partido_transaction($coneccion, date("Y-m-d"), "1200pm", "0", "", "1", "1", "0", $id);

                            }

                        }
                        
                        for($i = 0;$i < ((8 / 2) - 2);$i++){
                        
                            
                            PartidoPersistencia::agregar_partido_transaction($coneccion, date("Y-m-d"), "1200pm", "0", "","2" , "1", "0", $id);
                             
                        
                        }
                    
                    }else{
                        
                        for($i = 0;$i < (8 - 2);$i++){
                        
                            
                            PartidoPersistencia::agregar_partido_transaction($coneccion, date("Y-m-d"), "1200pm", "0", "","2" , "1", "0", $id);
                             
                        
                        }
                        
                    }
                    
                    
                    
                    PartidoPersistencia::agregar_partido_transaction($coneccion, date("Y-m-d"), "1200pm", "0", "","2" , "2", "0", $id);
                    PartidoPersistencia::agregar_partido_transaction($coneccion, date("Y-m-d"), "1200pm", "0", "","2" , "3", "0", $id);
                    
                    mysqli_commit($coneccion);
            
                }catch(Exception $ex){

                    echo "<script type=\"text/javascript\">alert('" .  ($ex->getMessage()) . "');</script>";

                }
            }
            
        }
        
        return isset($agregar)?$agregar:0;
        
    }
    
    function cancelar(){
        
        if(isset($_POST["btn_cancelar_x"])){
            
            try{

            TorneoPersistencia::cancelar_torneo(isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0");
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }
    }
    
    function restaurar(){
        
        if(isset($_POST["btn_restaurar_x"])){
            
            try{
            
                TorneoPersistencia::activar_torneo(isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0");
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }  
    }
    
    function eliminar(){
        
        if(isset($_POST["btn_eliminar_x"])){
            
            try{
            
                TorneoPersistencia::eliminar_torneo(isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0");
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }  
    }
    
    
    cancelar();
    restaurar();
    eliminar();

?>
