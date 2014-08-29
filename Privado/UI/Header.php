    <?php echo isset($recursos)?$recursos:""; ?>
	   
   </head>
      
   <body <?php echo isset($load)?$load:""; ?>> 
   
       <div id="wrap">
       
           <div id="contenedor">
               
            <?php if(basename($_SERVER["PHP_SELF"]) != "index.php"){ 
                      
                      $principal = $pagina == "principal"?"class=\"estatico\"":"href=\"principal.php\"";
                      $torneos = $pagina == "torneos"?"class=\"estatico\"":"href=\"torneos.php\"";
                      $torneo_admin = $pagina == "torneo"?"class=\"estatico\"":"href=\"torneo.php\"";
                      $administradores = $pagina == "administradores"?"class=\"estatico\"":"href=\"administradores.php\"";
                      $configuracion = $pagina == "configuracion"?"class=\"estatico\"":"href=\"configuracion.php\"";
                      
                      echo "<a href=\"principal.php\">".PHP_EOL;
                      echo "    <img src=\"recursos/img/administracion.png\" />".PHP_EOL;
                      echo "</a>".PHP_EOL;

                      echo "<div id=\"menu\">".PHP_EOL;

                      echo "    <ul>".PHP_EOL;
                      echo "       <li><a " . $principal . "><span><img src=\"recursos/img/menu/home.png\" width=\"20\" height=\"33\"/></span></a></li>".PHP_EOL;
                      
                      if($_SESSION["tipo"] == 0){
                      echo "       <li><a " . $torneos . "><span>Torneos</span></a></li>".PHP_EOL;
                      echo "       <li><a " . $administradores . "><span>Administradores</span></a></li>".PHP_EOL;
                      }else{
                        echo "       <li><a " . $torneo_admin . "><span>Torneo</span></a></li>".PHP_EOL;    
                      }
                      
                      echo "    </ul>".PHP_EOL;

                      echo "    <ul class=\"right\">".PHP_EOL;
                      echo "        <li><a " . $configuracion . " ><span><img src=\"recursos/img/menu/configuracion.png\" width=\"20\" height=\"33\"/></span></a></li>".PHP_EOL;
                      echo "        <li><a href=\"" . $_SERVER["PHP_SELF"] . "?logout=" . md5($_SESSION["usuario"]) . "\"><span>" . $_SESSION["usuario"] . " <sup>(logout)</sup>" . "</span></a></li>".PHP_EOL;
                      echo "    </ul>".PHP_EOL;

                      echo "</div>".PHP_EOL;
                     
                      
                      echo "<div id=\"contenido\" class=\"centrado\">".PHP_EOL;

                  }else{

                      echo "<div id=\"ingresar\" class=\"centrado\">".PHP_EOL;    

                  } 
                  
                ?>