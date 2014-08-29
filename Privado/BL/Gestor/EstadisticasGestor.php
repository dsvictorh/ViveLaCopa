<?php


if(!revisar_usuario()){

    $_SESSION["test_session"] = true;
    header("Location: error.php");
    exit();

}



?>
