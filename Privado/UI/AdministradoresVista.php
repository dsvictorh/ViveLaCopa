                    <div id="administradores_filtro">
                        <form name="frm_filtro" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div id="filtro">
                                    <input type="radio" id="chk_activos" name="chk_filtro"  onclick="submit(this);" value="activo" />Activos
                                    <input type="radio" id="chk_cancelados" name="chk_filtro"  onclick="submit(this);" value="cancelado" />Cancelados        
                            </div> 
                            <div id="busqueda">
                                <table>
                                    <tr>    
                                        <td>
                                            <select id="cmb_torneo" name="cmb_torneo" onchange="submit(this);">
                                                <?php listar_torneos(); ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="clear"></div>
                        </form>
                        <table id="administradores" class="custom_grid">

                            <tr>
                                <th id="nombre" class="izquierda">Nombre</th>
                                <th id="correo">Correo</th>
                                <th id="torneo">Torneo</th>
                                <th class="boton"></th>
                                <th class="boton"></th>
                            </tr>                  
                            <?php 
                            
                                $agregar = agregar();
                                listar_administradores($check); 
                            
                            ?>

                       </table>
                         
                        <?php 
    
                        ocultar_detalle($agregar == 0, $check);
                        mostrar_detalles($agregar, $check); 
                        
                        ?>
                       
                      
                   </div>
   