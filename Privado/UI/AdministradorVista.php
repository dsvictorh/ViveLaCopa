                 <form name="agregar_administrador" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                    <table id="configuracion">

                        <tr>
                            <td class="derecha">Nombre:</td>
                            <td><input type="text" name="txt_nombre" value="<?php echo ((isset($_POST["txt_nombre"]) && !isset($_POST["btn_cancelar_x"]))?str_replace(" ", "", $_POST["txt_nombre"]):$administrador->get_nombre()); ?>"/></td>
                        </tr>

                        <tr>
                            <td class="derecha">Correo:</td>
                            <td><input type="text" name="txt_correo" value="<?php echo ((isset($_POST["txt_correo"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_correo"]:$administrador->get_correo()); ?>"/></td>
                        </tr>

                        <tr>
                            <td class="derecha">Contrase&ntilde;a:</td>
                            <td><input type="password" name="txt_contrasenna" value="" /></td>
                        </tr>

                        <tr>
                            <td class="derecha">Confirmar Contrase&ntilde;a:</td>
                            <td><input type="password" name="txt_confirmar_contrasenna" value="" /></td>
                        </tr>

                        <tr>
                            <td colspan="2">

                            <table id="boton_error">
                                <tr>
                                    <td class="error"><?php $modificar = modificar($_POST["id_administrador"]); echo error($modificar) ?></td>
                                    <td class="derecha">
                                        <input type="image" src="recursos/img/guardar_editar.png" title="Guardar" name="btn_editar" />
                                        <input type="image" src="recursos/img/cancelar_editar.png" title="Cancelar" name="btn_cancelar" />
                                        <input type="hidden" name="id_administrador" value="<?php echo $administrador->get_id_administrador(); ?>"/>
                                    </td>
                                </tr>
                            </table>

                            </td>
                        </tr>

                        </table>

                    </form>