                    <h3 class="titulo"><?php echo $torneo->get_nombre_torneo(); ?></h3>
                    
                    <form class="derecha" autocomplete="off" name="frm_regresar" action="torneo.php" method="post">
                        <input type="image" name="btn_regresar" src="recursos/img/regresar.png" title="Regresar" alt="Regresar" />
                        <input type="hidden" name="id_torneo" value="<?php echo $_POST["id_torneo"]; ?>" />
                    </form>
                    
                    <div id="grupos">
                    
                        <?php listar_grupos($torneo->get_id_torneo(), $torneo->get_estado(), $torneo->get_fase()); ?>
                        
                   </div>
                 
                    
                    <div id="asignar_equipos">
                        
                        <?php 

                        if($torneo->get_estado() == "1"){
                            
                            echo "<table class=\"custom_grid\">".PHP_EOL;

                            echo "        <tr>".PHP_EOL;
                            echo "            <th id=\"nombre\" class=\"izquierda\">Nombre</th>".PHP_EOL;
                            echo "            <th id=\"grupo\">Grupo</th>".PHP_EOL;

                            echo "        </tr>".PHP_EOL;                  


                            listar_equipos_no_asignados($torneo->get_id_torneo()); 

                            echo "</table>".PHP_EOL;
                        
                         
                
                            echo "<div class=\"derecha\">".PHP_EOL;
                            echo "<form name=\"asignar_aleatorio\" autocomplete=\"off\" method=\"post\" action=\" " . $_SERVER["PHP_SELF"] . "\">".PHP_EOL;
                            echo "    <input type=\"image\" name=\"btn_random\" src=\"recursos/img/random.png\" title=\"Aleatorio\" alt=\"Aleatorio\" onclick=\"return confirmar('Los equipos ser\xe1n borrados y reasignados aleatoriamente.Desea continuar?')\" />".PHP_EOL;
                            echo "    <input type=\"hidden\" name=\"id_torneo\" value=\"".$_POST["id_torneo"]."\"  />".PHP_EOL;
                            echo "</form>".PHP_EOL;
                            echo "</div>".PHP_EOL;

                        }

                        ?>
                        
                     </div>
                         
                         
                    <div class="clear"></div>
                   
                    