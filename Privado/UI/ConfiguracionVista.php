                    <form name="editar_configuracion" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                        
                        <table id="configuracion" >
                            
                            <tr>
                                <td class="derecha">Nombre:</td>
                                <td>
                                    <input type="text" maxlength="50" name="txt_nombre" value="<?php echo isset($_POST["txt_nombre"])?str_replace(" ", "", $_POST["txt_nombre"]):$_SESSION["usuario"]; ?>" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="derecha">Correo:</td>
                                <td>
                                    <input type="text" maxlength="100" name="txt_correo" value="<?php echo isset($_POST["txt_correo"])?$_POST["txt_correo"]:$_SESSION["correo"]; ?>" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="derecha">Nueva contrase&ntilde;a:</td>
                                <td>
                                    <input type="password" maxlength="20" name="txt_contrasenna" value="" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="derecha">Confirmar contrase&ntilde;a:</td>
                                <td>
                                    <input type="password" maxlength="20" name="txt_re_contrasenna" value="" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td  colspan="2" class="derecha error">
                                    <table id="boton_error">
                                        <tr>
                                            <?php modificar(); ?>
                                            <td><input type="image" src="recursos/img/guardar.png" title="Guardar" name="btn_guardar" /></td>
                                        </tr>
                                    </table>
                                </td>  
                            </tr>
                            
                        </table>
                        <?php mostrar_reglamento(); ?>
                        
                    </form>