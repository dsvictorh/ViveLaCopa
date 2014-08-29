<form name="inscribir_equipo" autocomplete="off" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>?id_torneo=<?php echo $torneo->get_id_torneo(); ?>" onsubmit="parse_jugadores();">
                    
                    <div id="equipo_jugadores">
                         
                        <div id="equipo">
                            <h1>Equipo</h1>
                            
                            <div>
                                
                                <table>
                                    
                                    <tr>
                                        <td><input type="text" name="txt_equipo" value="<?php echo (isset($_POST["txt_equipo"])?$_POST["txt_equipo"]:"")?>" /></td>
                                        <td rowspan="2"><input type="image" name="btn_inscribir"  src="recursos/img/torneo/inscripcion/check.png" width="32" height="34" alt="Inscribir Equipo" title="Inscribir Equipo" /></td>
                                    </tr>
                                    
                                     <tr>
                                         <td><p>El equipo acepta el reglamento</p><input type="checkbox" name="chk_reglamento" /></td>
                                    </tr>
                                    
                                </table>
                                
                            </div>
                            
                        </div>
                        
                        <div id="jugador">
                            <h1>Jugador</h1>
                            
                             <div>
                                
                                <table>
                                    
                                    <tr>
                                        <td>
                                            <span>Nombre</span>
                                         </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <input type="text" name="txt_nombre"  value="" />
                                        </td>
                                    </tr>
                                   
                                     <tr>
                                        <td>        
                                            <span>Apellidos</span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <input type="text" name="txt_apellidos"  value="" />
                                        </td>
                                    </tr>
                                    
<!--                                    <tr>
                                        <td>        
                                            <span>C&eacute;dula</span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <input type="text" name="txt_cedula"  value="" />
                                        </td>
                                    </tr>-->
                                    
                                    <tr>
                                        <td>        
                                            <span>Tel&eacute;fono</span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <input type="text" name="txt_telefono" value="" />
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <span>Correo</span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <input type="text" name="txt_correo" value="" />
                                            
                                        </td>
                                         
                                    </tr>
                                    
                                </table>
                                
                            </div>
                            
                        </div>
                        
                        <div id="botones">
                               
                            <span onclick="guardar_registro();">Registrar</span>

                            <span onclick="cancelar_registro();">Cancelar</span>
                               
                        </div>
                        
                        
                    </div>

                    <div id="lista_jugadores">
                        
                        <div id="jugadores_registrados">
                            
                            <div id="registros"></div>
                            
                        </div>
                        
                    </div>

                     <div class="clear"></div>
                 
                </form>
