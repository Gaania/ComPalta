<?php
    //datos del server
    $servidor="localhost";//127.0.0.1
    $Usuario="root";
    $Contrasenia="";
    $nombre_base_de_datos="compalta";
    //variable para la conexion al servidos con "new mysqli"
    $conexion = new mysqli($servidor, $Usuario, $Contrasenia, $nombre_base_de_datos);

    
    if (!$conexion) {

        echo "Error de conexión" ;

    } 
?>