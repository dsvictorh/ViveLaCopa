
                    <div>
                        
                        <?php  mostrar_menu_torneo($cancelado, $torneo->get_id_torneo(), $torneo->get_numero_fases(), $torneo->get_estado(), $torneo->get_fase()); ?>
                        
                        <form name="editar_torneo" autocomplete="off" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

                            <table id="editar_torneo">

                                <tr>
                                    <td class="derecha">Nombre:</td>
                                    <td><input type="text" maxlength="50" name="txt_torneo" value="<?php echo ((isset($_POST["txt_torneo"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_torneo"]:$torneo->get_nombre_torneo()); ?>" /></td>
                                    <td class="spacer"></td>
                                    <td class="derecha">Precio (&cent;):</td>
                                    <td><input type="text" name="txt_precio"  value="<?php echo ((isset($_POST["txt_precio"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_precio"]:$torneo->get_precio()); ?>" /></td>
                                    <td class="spacer"></td>
                                    <td class="derecha">Reglamento:</td>
                                    <td rowspan="6"><textarea id="txt_reglamento" name="txt_reglamento"><?php echo ((isset($_POST["txt_reglamento"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_reglamento"]:$torneo->get_reglamento()); ?></textarea></td>
                                </tr>

                                <tr>
                                    <td class="derecha">Inicio:</td>
                                    <td><input type="text" id="txt_fecha_inicio"  readonly="true" class="date" onclick="enableDatePicker('txt_fecha_inicio', this);" name="txt_fecha_inicio" readonly="true"  value="<?php echo ((isset($_POST["txt_fecha_inicio"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_fecha_inicio"]:date('m/d/Y', strtotime($torneo->get_fecha_inicio()))); ?>" /> </td>
                                    <td class="spacer"></td>
                                    <td class="derecha"></td>
                                    <td rowspan="2"><textarea name="txt_precio_detalle" id="txt_precio_detalle"><?php echo ((isset($_POST["txt_precio_detalle"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_precio_detalle"]:$torneo->get_descripcion_precio()); ?></textarea></td>
                                </tr>

                                <tr>
                                    <td class="derecha">Fin:</td>
                                    <td> <input type="text" id="txt_fecha_fin"  readonly="true" class="date" onclick="enableDatePicker('txt_fecha_fin', this);" name="txt_fecha_fin" readonly="true"  value="<?php echo ((isset($_POST["txt_fecha_fin"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_fecha_fin"]:date('m/d/Y', strtotime($torneo->get_fecha_fin()))); ?>" /></td>
                                    <td class="spacer"></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td class="derecha">Detalles:</td>
                                    <td rowspan="3"><textarea name="txt_torneo_detalle" id="txt_torneo_detalle"><?php echo ((isset($_POST["txt_torneo_detalle"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_torneo_detalle"]:$torneo->get_detalle()); ?></textarea></td>
                                    <td class="spacer"></td>
                                    <td class="derecha">Primer premio:</td>
                                    <td><input type="text" maxlength="200" name="txt_primer_premio" value="<?php echo ((isset($_POST["txt_primer_premio"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_primer_premio"]:$torneo->get_primer_premio()); ?>" /></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="spacer"></td>
                                    <td class="derecha">Segundo premio:</td>
                                    <td><input type="text" maxlength="200" name="txt_segundo_premio" value="<?php echo ((isset($_POST["txt_segundo_premio"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_segundo_premio"]:$torneo->get_segundo_premio()); ?>" /></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="spacer"></td>
                                    <td class="derecha">Tercer premio:</td>
                                    <td><input type="text" maxlength="200" name="txt_tercer_premio" value="<?php echo ((isset($_POST["txt_tercer_premio"]) && !isset($_POST["btn_cancelar_x"]))?$_POST["txt_tercer_premio"]:$torneo->get_tercer_premio()); ?>" /></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="spacer" colspan="3"></td>
                                </tr>

                                <tr>
                                    <td colspan="8">
                                        <?php $modificar = modificar(); ?>
                                        <table id="boton_error">
                                            <tr>
                                                <td class="<?php echo (($finalizado)?"derecha mensaje":"error"); ?>"><?php echo error($modificar); echo validar_estado($cancelado, $finalizado); ?></td>
                                                <td class="derecha">
                                                    <?php 

                                                    if(!$cancelado && !$finalizado){

                                                        echo "<input type=\"image\" src=\"recursos/img/guardar_editar.png\" title=\"Guardar\" name=\"btn_editar_torneo\" />".PHP_EOL; 
                                                        echo "<input type=\"image\" src=\"recursos/img/cancelar_editar.png\" title=\"Cancelar\" name=\"btn_cancelar\" />".PHP_EOL; 


                                                    }
                                                    ?>
                                                    <input type="hidden" name="id_torneo" value="<?php echo $torneo->get_id_torneo(); ?>" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table>

                        </form>
   
                    </div>

