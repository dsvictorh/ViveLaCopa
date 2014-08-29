<!DOCTYPE HTML>
<html>
  
   <head>
         
       <title>Vive la Copa</title> 
       <link rel="stylesheet" href="recursos/css/estilos.css" />
         
   </head>
   
   <body>
   
       <div id="wrap">
       
           <div id="contenedor">
               
               <a href="index.php">
                   <img src="recursos/img/administracion.png" />
               </a>
                   
               <div id="menu"></div>
               
               <div id="contenido" class="centrado">
                    
                    <h1>Posici&oacute;n Prohibida</h1>
                    <img src="recursos/img/error.png" width="600" heigth="400" />
                    <h6>Acceso denegado. Para ingresar presione <a href="index.php">aqu&iacute;</a></h6>

               </div>
                                
            </div>   
           
       </div>
       
   </body>
   
</html> 

<?php

    session_start();
    if(!isset($_SESSION["test_session"])){
            
            header("Location: nosession.php");
            exit();
            
    }

?>