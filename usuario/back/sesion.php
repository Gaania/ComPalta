<?php
    session_start();
    if(!isset($_SESSION["sesion"])){ 
        $sesion='';

    }else{
        $sesion=$_SESSION["sesion"];
    }
?>