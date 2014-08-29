                <div id="torneos">

                    <div id="head">

                        <h2 id="torneo">Torneo</h2>
                        <h2 id="estado">Estado</h2>

                    </div>

                    <div id="lista">

                        <?php 

                        $par = true;
                        listar_torneos($par); 

                        ?>


                    </div>    

                    <div id="<?php echo ((($par)?"foot_par":"foot_impar")); ?>"></div>

                </div>