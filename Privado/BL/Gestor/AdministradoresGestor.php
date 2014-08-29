<?php

require_once 'BL/Persistencia/AdministradorPersistencia.php';
require_once 'BL/Persistencia/TorneoPersistencia.php';
require_once 'BL/Persistencia/UsuarioPersistencia.php';

    
     if(!revisar_usuario() || $_SESSION["tipo"] != "0"){
    
        $_SESSION["test_session"] = true;
        header("Location: error.php");
        exit();
        
    }
        
    $pagina = "administradores";
    $recursos = "<script type=\"text/javascript\" src=\"recursos/js/utilidades.js\"></script>";
    $check = isset($_POST["chk_filtro"])?$_POST["chk_filtro"]:"activo";
    $select = (isset($_REQUEST["cmb_torneo"]))?$_REQUEST["cmb_torneo"]:"";
    $select_torneo = (isset($_REQUEST["cmb_torneos"]))?$_REQUEST["cmb_torneos"]:""; ;
    $load = "onLoad=\"cargar_administradores('". $check ."', '" . $select . "', '" . $select_torneo . "')\";";
    
  
    function validar_datos(){
        //1 - Incompleto
        //2 - Caracteres Especiales
        //3 - Correo no valido
        //4 - Contraseña no valida
        //5 - Contraseña no coincide
        //6 - Correo o usuario ya existe
        //7 - Contraseña menos a 6
        $valido = 0;
        $valido = ($valido == 0)?(isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_nombre"]))?2:0:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_correo"]))
            ?2:(preg_match($GLOBALS["email"], $_POST["txt_correo"]))?0:3:1:$valido;
        
        $valido = ($valido == 0)?(isset($_POST["txt_contrasenna"])?$_POST["txt_contrasenna"]:"") != ""
            ?(preg_match($GLOBALS["novalidos"], $_POST["txt_contrasenna"]))
            ?2:(preg_match($GLOBALS["contrasenna"], $_POST["txt_contrasenna"]))
            ?(strlen($_POST["txt_contrasenna"]) >= 6)
            ?($_POST["txt_contrasenna"] == (isset($_POST["txt_confirmar_contrasenna"])?$_POST["txt_confirmar_contrasenna"]:""))
            ?0:5:7:4:1:$valido;
        
        $valido = ($valido == 0)?UsuarioPersistencia::validar_usuario($_POST["txt_nombre"], $_POST["txt_correo"])?0:6:$valido;
        
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
                $mensaje = "Formato de correo no v&aacute;lido";
                break;
            
            case 4:
                $mensaje = "Formato de contrase&ntilde;a no v&aacute;lido";
                break;  
            
            case 5:
                $mensaje = "Las contrase&ntilde;as no coinciden";
                break;
            
            case 6:
                $mensaje = "Usuario o correo ya est&aacute;n en uso";
                break;
            
            case 7:
                $mensaje = "La contrase&ntilde;a debe contener como minimo 6 caracteres ";
                break;
            
        }
        
        return $mensaje;
        
        
    }
    
    function listar_administradores($check){
        
        try{
            
            if($check == "activo"){

                listar_administradores_activos();

            }else{

                listar_administradores_inactivos();

            }
        }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }
    }
    
    function listar_administradores_activos(){
         
        $administrador = new Administrador();
        $administradores = array();
        $administradores = AdministradorPersistencia::listar_administrador_activo(isset($_REQUEST["cmb_torneo"])?$_REQUEST["cmb_torneo"]:"0");
        
        for($i = 0; $i < count($administradores); $i++){
            
            $administrador = $administradores[$i];  
            
            $ultimo_izq = $i == (count($administradores)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($administradores)-1)?!($i % 2 == 0)?" ultimo_der":"":"";
            
            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $administrador->get_nombre() . "</td>".PHP_EOL;
            echo "  <td>" . $administrador->get_correo() . "</td>".PHP_EOL;
            echo "  <td>" . TorneoPersistencia::buscar_torneo($administrador->get_id_torneo())->get_nombre_torneo() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"administrador_ir\" autocomplete=\"off\" action=\"administrador.php\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_ir\" src=\"recursos/img/ir.png\"  title=\"Ir\" alt=\"Ir\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_administrador\" value=\"" . $administrador ->get_id_administrador() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            echo "      <form name=\"administrador_borrar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_cancelar\" src=\"recursos/img/cancelar.png\" onClick=\"return confirmar('Desea desactivar este administrador?');\" title=\"Desactivar\" alt=\"Desactivar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_administrador\" value=\"" . $administrador ->get_id_administrador() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    }
    
    function listar_administradores_inactivos(){
         
        $administrador = new Administrador();
        $administradores = array();
        $administradores = AdministradorPersistencia::listar_administrador_inactivo(isset($_REQUEST["cmb_torneo"])?$_REQUEST["cmb_torneo"]:"0");
        
        for($i = 0; $i < count($administradores); $i++){
            
            $administrador = $administradores[$i]; 
            
            $ultimo_izq = $i == (count($administradores)-1)?!($i % 2 == 0)?" ultimo_izq":"":"";
            $ultimo_der = $i == (count($administradores)-1)?!($i % 2 == 0)?" ultimo_der":"":"";
            
            echo ($i % 2 == 0)?"<tr>":"<tr class=\"oscuro\">".PHP_EOL;
            echo "  <td class=\"izquierda" . $ultimo_izq . "\">" . $administrador->get_nombre() . "</td>".PHP_EOL;
            echo "  <td>" . $administrador->get_correo() . "</td>".PHP_EOL;
            echo "  <td>" . TorneoPersistencia::buscar_torneo($administrador->get_id_torneo())->get_nombre_torneo() . "</td>".PHP_EOL;
            echo "  <td class=\"boton\">".PHP_EOL;
            echo "      <form name=\"administrador_restaurar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_restaurar\" src=\"recursos/img/restaurar.png\" title=\"Restaurar\" alt=\"Restaurar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_administrador\" value=\"" . $administrador ->get_id_administrador() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "  <td class=\"boton" . $ultimo_der . "\">".PHP_EOL;
            echo "      <form name=\"administrador_eliminar\" autocomplete=\"off\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;
            echo "          <input type=\"image\" name=\"btn_eliminar\" onClick=\"return confirmar('Este administrador ser&aacute; permanentemente eliminado. Desea proseguir?');\"  src=\"recursos/img/eliminar.png\" title=\"Eliminar\" alt=\"Eliminar\" />".PHP_EOL;
            echo "          <input type=\"hidden\" name=\"id_administrador\" value=\"" . $administrador ->get_id_administrador() . "\" />".PHP_EOL;
            echo "      </form>".PHP_EOL;
            echo "  </td>".PHP_EOL;
            echo "</tr>".PHP_EOL;      
        }
    }
    
    function listar_torneos(){
        
        try{
            $torneo = new Torneo();
            $torneos = array();
            $torneos = TorneoPersistencia::listar_torneo();

            echo "<option value=\"0\">Todos</option>".PHP_EOL;

            for($i = 0; $i < count($torneos); $i++){


                $torneo = $torneos[$i];

                echo "<option value=\"" . $torneo->get_id_torneo() . "\">" . $torneo->get_nombre_torneo() . "</option>".PHP_EOL;

            }
        
        }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

        }
    }
    
    function mostrar_detalles($agregar, $check){
        
        if(isset($_POST["btn_agregar_x"]) || $agregar != 0){
            
            try{

                $torneos = array();

                $torneos = TorneoPersistencia::listar_torneo_activo("");

                echo "<div>".PHP_EOL;

                echo "<form name=\"agregar_administrador\" autocomplete=\"off\" action=\"". $_SERVER["PHP_SELF"]."\" method=\"post\">".PHP_EOL;

                echo "<table id=\"registrar_administradores\">".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "       <td class=\"derecha\">Nombre:</td>".PHP_EOL;
                echo "       <td><input type=\"text\" maxlength=\"50\" name=\"txt_nombre\" value=\"" . (isset($_POST["txt_nombre"])?$_POST["txt_nombre"]:"") . "\" /></td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "       <td class=\"derecha\">Correo:</td>".PHP_EOL;
                echo "       <td><input type=\"text\" maxlength=\"100\" name=\"txt_correo\" value=\"" . (isset($_POST["txt_correo"])?$_POST["txt_correo"]:"") . "\" /></td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "      <td class=\"derecha\">Contrase&ntilde;a:</td>".PHP_EOL;
                echo "      <td><input type=\"password\" maxlength=\"20\" name=\"txt_contrasenna\" value=\"" . (isset($_POST["txt_contrasenna"])?$_POST["txt_contrasenna"]:"") . "\" /></td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "      <td class=\"derecha\">Confirmar Contrase&ntilde;a:</td>".PHP_EOL;
                echo "      <td><input type=\"password\" maxlength=\"20\" name=\"txt_confirmar_contrasenna\" value=\"\" /></td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "       <td class=\"derecha\">Torneo:</td>".PHP_EOL;
                echo "       <td>".PHP_EOL;
                echo "           <select name=\"cmb_torneos\">".PHP_EOL;

                for($i=0; $i < count($torneos); $i++){

                    echo "               <option value=\"" . $torneos[$i]->get_id_torneo() . "\">" . $torneos[$i]->get_nombre_torneo() . "</option>".PHP_EOL;    

                }

                echo "          </select>".PHP_EOL;
                echo "       </td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "  <tr>".PHP_EOL;
                echo "      <td colspan=\"2\">".PHP_EOL;
                echo "          <table id=\"boton_error\">".PHP_EOL;
                echo "               <tr>".PHP_EOL;
                echo "                  <td class=\"error\">" . error($agregar) . "</td>".PHP_EOL;
                echo "                   <td class=\"derecha\">".PHP_EOL;
                echo "                      <input type=\"image\" src=\"recursos/img/registrar.png\" title=\"Agregar\" name=\"btn_registrar_administrador\" />".PHP_EOL;
                echo "                      <input type=\"image\" src=\"recursos/img/cancelar_registrar.png\" title=\"Cancelar\" name=\"btn_cancelar_administrador\" />".PHP_EOL;
                echo "                      <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
                echo "                   </td>".PHP_EOL;
                echo "               </tr>".PHP_EOL;
                echo "          </table>".PHP_EOL;
                echo "      </td>".PHP_EOL;
                echo "  </tr>".PHP_EOL;

                echo "</table>".PHP_EOL;

                echo "</form>".PHP_EOL;

                echo "</div>".PHP_EOL;
                
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }

        }
        
        
    }
    
    function ocultar_detalle($agregar, $check){
        
        if(!isset($_POST["btn_agregar_x"])){
            
            if($agregar){
                
                echo " <div class=\"derecha\">".PHP_EOL;
                echo "    <form name=\"mostrar_detalle\" autocomplete=\"off\" action=\"" .  $_SERVER["PHP_SELF"] . "\" method=\"post\">".PHP_EOL;   
                echo "        <input type=\"image\" src=\"recursos/img/agregar.png\" title=\"Agregar administrador\" name=\"btn_agregar\" />".PHP_EOL;
                echo "        <input type=\"hidden\" name=\"chk_filtro\" value=\"" . $check . "\" />".PHP_EOL;
                echo "    </form>".PHP_EOL;
                echo " </div>".PHP_EOL;
            
            }
            
        }
        
    }
    
    function agregar(){
        
        if(isset($_POST["btn_registrar_administrador_x"])){
            
              if(($agregar = validar_datos()) == 0){
                  
                  try{
                  
                     AdministradorPersistencia::agregar_administrador(str_replace(" ", "", $_POST["txt_nombre"]), md5($_POST["txt_contrasenna"]), $_POST["txt_correo"], $_POST["cmb_torneos"]);
                  
              
                  }catch(Exception $ex){

                     echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

                  }
               }
            }   
        
        return isset($agregar)?$agregar:0;
        
    }
    
    function desactivar(){
        
        if(isset($_POST["btn_cancelar_x"])){
            
            try{
            
                administradorPersistencia::desactivar_administrador(isset($_POST["id_administrador"])?$_POST["id_administrador"]:"0");
            
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }
    }
    
    function restaurar(){
        
        if(isset($_POST["btn_restaurar_x"])){
            
            try{
            
                administradorPersistencia::activar_administrador(isset($_POST["id_administrador"])?$_POST["id_administrador"]:"0");
                
            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }  
    }
    
     function eliminar(){
        
        if(isset($_POST["btn_eliminar_x"])){
            
            try{
            
                administradorPersistencia::eliminar_administrador(isset($_POST["id_administrador"])?$_POST["id_administrador"]:"0");

            }catch(Exception $ex){

                echo "<script type=\"text/javascript\">alert('" .  $ex->getMessage() . "');</script>";

            }
        }  
    }
    
    desactivar();
    restaurar();
    eliminar();

?>
