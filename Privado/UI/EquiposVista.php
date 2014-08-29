                        <h3 class="titulo"><?php echo $torneo->get_nombre_torneo(); ?></h3>
                        
                         <form class="derecha" autocomplete="off" name="frm_regresar" action="torneo.php" method="post">
                            <input type="image" name="btn_regresar" src="recursos/img/regresar.png" title="Regresar" alt="Regresar" />
                            <input type="hidden" name="id_torneo" value="<?php echo $_POST["id_torneo"]; ?>" />
                        </form>
                        
                        <div id="equipos_filtro">
                            <form name="frm_filtro" autocomplete="off" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                <div id="filtro">
                                        <input type="radio" id="chk_aprobados" name="chk_filtro"  onclick="submit(this);" value="aprobado" />Aprobados
                                        <input type="radio" id="chk_pendientes" name="chk_filtro"  onclick="submit(this);" value="pendiente" />Pendientes  
                                        <input type="radio" id="chk_no_aprobados" name="chk_filtro"  onclick="submit(this);" value="noaprobado" />No Aprobados
                                        <input type="hidden" name="id_torneo" value="<?php echo $_POST["id_torneo"]; ?>" />
                                </div> 
                                <div class="clear"></div>
                            </form>
                            <table id="equipos" class="custom_grid">

                                <tr>
                                    <th id="nombre" class="izquierda">Nombre</th>
                                    <th id="puntos">Puntos</th>
                                    <th class="boton"></th>
                                    <th class="boton"></th>
                                    <th class="boton"></th>
                                </tr>                  
                                <?php 

                                listar_equipos($check, $torneo->get_estado()); 

                                ?>

                            </table>
                      
                        </div>
                        
                        