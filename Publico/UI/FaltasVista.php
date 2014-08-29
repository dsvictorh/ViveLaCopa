                    <div id="rojo">
                        
                        <div class="head">

                            <h1>Faltas</h1>
                            <div>

                                <h2 class="equipo titulo">Equipo</h2>
                                <h2 class="jugador titulo">Nombre</h2>
                                <h2 class="sanciones"><img src="recursos/img/torneo/head_rojo/amarilla.png" alt="Amarillas" title="Amarillas" /></h2>
                                <h2 class="sanciones"><img src="recursos/img/torneo/head_rojo/roja.png" alt="Rojas" title="Rojas" /></h2>
                                <h2 class="sanciones"><img src="recursos/img/torneo/head_rojo/sanciones.png" alt="Suspenciones" title="Suspenciones" /></h2>                                
                                <div class="clear"></div>

                            </div>

                        </div>
                        
                        <?php pintar_faltas($torneo->get_id_torneo()); ?>
                  
                    </div>