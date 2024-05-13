<?php
    session_start();
    if(!isset($_SESSION["sesion"])){ 
        $sesion='0';

    }else{
        $sesion=$_SESSION["sesion"];
    }
?>