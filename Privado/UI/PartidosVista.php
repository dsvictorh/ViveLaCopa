                                <h3 class="titulo"><?php echo $torneo->get_nombre_torneo();?> - Grupo <?php echo$_POST["grupo"];?></h3>
                                
                                <form class="derecha" autocomplete="off" name="frm_regresar" action="primera-fase.php" method="post">
                                    <input type="image" name="btn_regresar" src="recursos/img/regresar.png" title="Regresar" alt="Regresar" />
                                    <input type="hidden" name="id_torneo" value="<?php echo $_POST["id_torneo"]; ?>" />
                                </form>
                                    
                                <?php listar_partidos($_POST["grupo"], $torneo); ?>

                                <div class="clear"></div>