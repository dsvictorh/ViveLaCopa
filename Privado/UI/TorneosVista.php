                    <div id="torneos_filtro">
                        <form name="frm_filtro" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div id="filtro">
                                    <input type="radio" id="chk_activos" name="chk_filtro"  onclick="submit(this);" value="activo" />Activos
                                    <input type="radio" id="chk_cancelados" name="chk_filtro"  onclick="submit(this);" value="cancelado" />Cancelados        
                            </div> 
                            <div id="busqueda">
                                <table>
                                    <tr>    
                                        <td>
                                            <input type="text" maxlength="50" name="txt_busqueda" value="<?echo isset($_REQUEST["txt_busqueda"])?preg_replace($GLOBALS["novalidos"], "", $_REQUEST["txt_busqueda"]):"" ?>" />
                                        </td>
                                        <td>
                                             <input type="image" src="recursos/img/buscar.png" title="Buscar" name="btn_buscar" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="clear"></div>
                        </form>
                        <table id="torneos" class="custom_grid">

                            <tr>
                                <th id="torneo" class="izquierda">Torneo</th>
                                <th id="estado">Estado</th>
                                <th id="fecha_inicio">De</th>
                                <th id="fecha_fin">Hasta</th>
                                <th id="fase">Fase</th>
                                <th id="numero_fases">Fases</th>
                                <th class="boton"></th>
                                <th class="boton"></th>
                            </tr>                  
                            <?php 
                            
                            $agregar = agregar();
                            listar_torneos($check); 
                            
                            ?>

                       </table>
                        
                        <?php 
    
                        ocultar_detalle($agregar == 0, $check);
                        mostrar_detalles($agregar, $check); 
                        
                        ?>
                      
                   </div>
   