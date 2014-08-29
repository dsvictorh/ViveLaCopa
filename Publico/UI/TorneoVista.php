
                <div id="torneo">
                    
                    <div id="descripcion_premios">

                        <div>
                            <h1>Descripcion</h1>
                            
                            <div>
                                
                                <div id="descripcion">
                                    
                                    <span><?php echo $torneo->get_detalle(); ?></span>
                                    
                                </div>
                                
                                <span id="premios">Premios</span>
                                
                                <div id="premio">
                                    
                                    <span>Primer Premio: <?php echo $torneo->get_primer_premio(); ?></span>
                                    <span>Segundo Premio: <?php echo $torneo->get_segundo_premio(); ?></span>
                                    <span>Tercer Premio: <?php echo $torneo->get_tercer_premio(); ?></span>
                                    
                                </div>
                                
                            </div>   
                            
                        </div>

                    </div>

                    <div id="datos">

                        <div id="estado">
                            
                            <h3>Estado</h3>
                            
                            <div>
                                 <span>
                                     <?php switch($torneo->get_estado()){
                                         
                                         case 1:
                                             echo "Abierto";
                                             break;
                                         
                                         case 2:
                                             echo "En curso";
                                             break;
                                         
                                         case 3:
                                             echo "Finalizado";
                                             break;
                                         
                                         case 4:
                                             echo "Cancelado";
                                             break;
                                     }
                                     ?>
                                 </span>
                            </div>
                            
                        </div>

                        <div id="costo">
                            <h3>Costo</h3>
                            
                            <div>
                                <span><a href="javascript:void(0)" title="<?php echo $torneo->get_descripcion_precio(); ?>">&cent;<?php echo $torneo->get_precio(); ?></a></span>
                            </div>
                            
                        </div>

                        <div id="fecha">
                            
                            <h3>Fecha</h3>
                            
                             <div>
                                <span>Desde: <?php echo date("d/m/Y", strtotime($torneo->get_fecha_inicio())); ?></span>
                                <span>Hasta: <?php echo date("d/m/Y", strtotime($torneo->get_fecha_fin())); ?></span>
                            </div>
                            
                        </div>


                    </div>

                    <div id="menu_torneo">

                        <ul>
                            <li <?php echo (($torneo->get_estado() != 1)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() == 1)?"href=\"inscripcion.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/inscripcion.png" alt="" title="" /> <span>Inscripcion</span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2 || $torneo->get_numero_fases() != 2)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1 && $torneo->get_numero_fases() == 2)?"href=\"grupos.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/grupos.png" alt="" title="" /> <span>Grupos</span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2 || $torneo->get_numero_fases() != 2)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1 && $torneo->get_numero_fases() == 2)?"href=\"primera_fase.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/primera_fase.png" alt="" title="" /> <span>1<sup>ra</sup> Fase</span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2 || $torneo->get_numero_fases() != 2)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1 && $torneo->get_numero_fases() == 2)?"href=\"puntos.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/puntos.png" alt="" title="" /> <span>Puntos</span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2 || $torneo->get_fase() != 2 )?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1 && $torneo->get_fase() == 2)?"href=\"segunda_fase.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/segunda_fase.png" alt="" title="" /> <span><?php echo (($torneo->get_numero_fases() == "2")?"2<sup>da</sup> Fase":"Llave"); ?></span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1)?"href=\"goleadores.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/goleadores.png" alt="" title="" /> <span>Goleadores</span></a></li>
                            <li <?php echo (($torneo->get_estado() < 2)?"class=\"desactivado\"":""); ?>><a <?php echo (($torneo->get_estado() > 1)?"href=\"faltas.php?id_torneo=" . $torneo->get_id_torneo() . "\"":""); ?>><img src="recursos/img/torneo/menu/faltas.png" alt="" title="" /> <span>Faltas</span></a></li>
                        </ul>
                    </div>

                    <div class="clear"></div>

                </div>

    
