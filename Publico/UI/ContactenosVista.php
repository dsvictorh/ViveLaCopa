<?php

$error = enviar();

?>
    
    <form name="enviar_correo" method="post" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        
        <table id="contacto">
            
            <tr>
                <td class="derecha">Nombre:</td>
                <td><input type="text" name="txt_nombre" value="<?php echo ((isset($_POST["txt_nombre"]))?$_POST["txt_nombre"]:""); ?>" /></td>
                <td rowspan="5"><textarea class="no_resizable" name="txt_descripcion"><?php echo ((isset($_POST["txt_descripcion"]) && $error != 0)?$_POST["txt_descripcion"]:""); ?></textarea></td>
            </tr>
            
            <tr>
                <td class="derecha">Apellido:</td>
                <td><input type="text" name="txt_apellido" value="<?php echo ((isset($_POST["txt_apellido"]))?$_POST["txt_apellido"]:""); ?>" /></td>
                
            </tr>
            
            <tr>
                <td class="derecha">Correo:</td>
                <td><input type="text" name="txt_correo" value="<?php echo ((isset($_POST["txt_correo"]))?$_POST["txt_correo"]:""); ?>" /></td>
            </tr>
            
            <tr>
                <td class="derecha">Tel:</td>
                <td><input type="text" name="txt_telefono" value="<?php echo ((isset($_POST["txt_telefono"]))?$_POST["txt_telefono"]:""); ?>" /></td>
            </tr>
           
            <tr>
                <td class="derecha">Asunto:</td>
                <td><input type="text" name="txt_asunto" value="<?php echo ((isset($_POST["txt_asunto"]) && $error != 0)?$_POST["txt_asunto"]:""); ?>" /></td>
            </tr>     

            <tr>
                <?php mensaje($error); ?>
                <td class="derecha"><input type="image" name="btn_enviar" src="recursos/img/layout/enviar.png" alt="Enviar" title="Enviar" /></td>
               
            </tr>
            
            
            
        </table>
    </form>
