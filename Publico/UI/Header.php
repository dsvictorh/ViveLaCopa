        <?php echo isset($recursos)?$recursos:""; ?>

        <title>Vive la Copa - <?php echo $titulo;?></title>
        
       
    </head>

    <body <?php echo isset($body)?$body:""; ?>>
    
    	<div id="wrap">
    
            <div id="contenedor">
            
            	<div id="header">
                
                	<a href="index.php"><img src="recursos/img/layout/vive_la_copa.png" alt="Vive La Copa" /></a>
                
                </div>
                
                <div id="menu">
                
                    <ul>
                        <?php
                        
                         $index = $pagina == "index"?"class=\"selected\"":"href=\"index.php\"";
                         $contactenos = $pagina == "contactenos"?"class=\"selected\"":"href=\"contactenos.php\"";
                         $acerca = $pagina == "acerca"?"class=\"selected twotitles\"":"href=\"acerca.php\" class=\"twotitles\"";
                         $patrocinadores = $pagina == "patrocinadores"?"class=\"selected\"":"href=\"patrocinadores.php\"";
                        
                        
                        ?>
                        
                    	<li><a <?php echo $index; ?> >Torneos</a></li>
                        <li><a <?php echo $contactenos; ?> >Contactenos</a></li>
                        <li><a <?php echo $acerca; ?> ><sup>Acerca de</sup> Nosotros</a></li>
                        <li><a <?php echo $patrocinadores; ?> >Patrocinadores</a></li>
                    
                    </ul>
                
                    <div class="clear"></div>
                
                </div>

                <div id="banner">
                    
                    <?php  pintar_menu_banner($url, $reglamento, ((isset($texto))?$texto:"")); ?>
                    
                
                    <div id="titulo">
                    
                        
                   	 <?php echo ((basename($_SERVER["PHP_SELF"]) == "torneo.php")?"<p>Torneo</p>":""); ?>
                         <h1 <?php echo ((basename($_SERVER["PHP_SELF"]) == "torneo.php")?"id=\"torneo_titulo\"":""); ?>><?php echo $titulo; ?></h1>
                    
                    </div>
                	
                    <div class="clear"></div>
                
                </div>
                
                <div id="contenido">