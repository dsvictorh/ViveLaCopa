   

            <ul id="menu_footer">
                    <?php

                        $index = $pagina == "index"?"class=\"selected\"":"href=\"index.php\"";
                        $contactenos = $pagina == "contactenos"?"class=\"selected\"":"href=\"contactenos.php\"";
                        $acerca = $pagina == "acerca"?"class=\"selected twotitles\"":"href=\"acerca.php\"";
                        $patrocinadores = $pagina == "patrocinadores"?"class=\"selected\"":"href=\"patrocinadores.php\"";


                    ?>

                    <li><a <?php echo $index; ?> >Torneos</a> <span class="pipe">|</span></li>
                    <li><a <?php echo $contactenos; ?> >Contactenos</a> <span class="pipe">|</span></li>
                    <li><a <?php echo $acerca; ?> >Acerca de Nosotros</a> <span class="pipe">|</span></li>
                    <li><a <?php echo $patrocinadores; ?> >Patrocinadores</a></li>

                </ul>


                </div>
            
             </div>
            
        </div>
        
         <?php echo isset($footer)?$footer:""; ?>
    
    </body>
    
</html>
