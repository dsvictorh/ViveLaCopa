                       <h3 class="titulo"><?php echo $equipo->get_nombre(); ?></h3>
                       
                       <form class="derecha" autocomplete="off" name="frm_regresar" action="equipos.php" method="post">
                            <input type="image" name="btn_regresar" src="recursos/img/regresar.png" title="Regresar" alt="Regresar" />
                            <input type="hidden" name="id_torneo" value="<?php echo (isset($_POST["id_torneo"])?$_POST["id_torneo"]:"0"); ?>" />
                       </form>
                       
                       <table id="jugadores" class="custom_grid">

                                <tr>
                                    <th id="nombre" class="izquierda">Nombre</th>
                                    <th id="cedula">Cedula</th>
                                    <th id="correo">Correo</th>
                                    <th id="telefono">Telefono</th>
                                    
                                    <?php 
                                    
                                     $modificar = guardar_jugador();
                                     $agregar = agregar_jugador($torneo->get_id_torneo());
                                     
                                     eliminar_jugador();
                                    
                                    if($equipo->get_estado() == 1 && $torneo->get_estado() == 2)
                                      echo "<th class=\"boton\">".PHP_EOL;
                                      echo "    <form name=\"nuevo_jugador\" action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\" >".PHP_EOL;
                                      echo "        <input type=\"image\" name=\"btn_nuevo\" src=\"recursos/img/agregar.png\" title=\"Agregar\" alt=\"Agregar\" />".PHP_EOL;
                                      echo "        <input type=\"hidden\" value=\"" . $equipo->get_id_equipo() . "\" name=\"id_equipo\" />".PHP_EOL;
                                      echo "        <input type=\"hidden\" name=\"id_torneo\" value=\"" . $torneo->get_id_torneo() . "\" />".PHP_EOL;
                                      echo "    </form>".PHP_EOL;
                                      echo "</th>".PHP_EOL;
                                    
                                    ?>
                                    
                                </tr>                  
                                
                                <?php listar_jugadores($equipo->get_id_equipo(), $equipo->get_estado(), $torneo); ?>
                       </table>
                       
                       <?php 
                       
                      
                       editar_jugador($modificar, $equipo->get_id_equipo());
                       
                       nuevo_jugador($agregar, $equipo->get_id_equipo());
                       
                      
                       
                       ?>
                       
                       
                       
                       
                    