<?php
if (isset($_POST)){
    //pasar variables
    $nombre=$_POST['nombre'];
    $correo=$_POST['correo'];
    $clave=$_POST['clave'];
    $clave2=$_POST['clave2'];

    $creacion= date('Y m d');

    echo $creacion;
    //validaciones
    if((strlen($nombre)<=3) or (strlen($nombre)>=21)){
        echo "<script>alert('ERROR: Su nombre de usuario debe tener entre 4 y 20 caracteres.');window.location='';</script>";
    }

    if((strlen($correo)<=9) or (strlen($correo)>=51)){
        echo "<script>alert('ERROR: Su correo debe tener entre 10 y 50 caracteres.');window.location='';</script>";
    }

    if((strlen($clave)<=7) or (strlen($clave)>=13)){
        echo "<script>alert('ERROR: Su contraseña debe tener entre 8 y 12 caracteres.');window.location='';</script>";
    }

}
?>