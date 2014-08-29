                    <img src="recursos/img/administracion.png" alt="administracion" width="400" height="100" />
                    
                    <form id="ingresar_seguro" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    
                        <table id="formulario" class="centrado">

                                <tr>
                                    <td class="derecha">Nombre:</td> 
                                    <td>
                                        <input type="text" maxlength="50" name="txt_usuario" value="<?php cargar_usuario(); ?>" />
                                    </td>  
                                </tr>  
                                <tr>
                                    <td class="derecha">Contrase&ntilde;a:</td> 
                                    <td>
                                        <input type="password" maxlength="20" name="txt_contrasenna" value="" />
                                    </td>  
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <table class="check">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="chk_recordarme" value="recordarme" />
                                                </td>
                                                <td class="check">Recordarme</td>
                                            </tr>
                                        </table>    
                                    </td>  
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="derecha error">
                                        <table id="boton_error">
                                            <tr>
                                                <td><?php ingresar(); ?></td>
                                                <td><input type="image"  name="btn_ingresar" src="recursos/img/ingresar.png" alt="Ingresar" title="Ingresar" /></td>
                                            </tr>
                                        </table>
                                    </td>  
                                </tr>
                            
                          </table>
                        
                       </form>
                        
                        
                    
                   