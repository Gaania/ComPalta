<?php
if (isset($_GET)){
    //pasar variables
    $nombre=$_GET['nombre'];
    $correo=$_GET['correo'];
    $clave=$_GET['clave'];
    $clave2=$_GET['clave2'];

    $fechacreacion= date('Y-m-d');
    
    //conexion a la BD
    include ("../../BDD/conexion.php");

    //validaciones
    if($clave!=$clave2){
        echo "<script>alert('ERROR: Las contraseñas no son iguales');window.location='../vistas/signup.html';</script>";
        exit();
    }

    if((strlen($nombre)<=3) or (strlen($nombre)>=16)){
        echo "<script>alert('ERROR: Su nombre de usuario debe tener entre 4 y 15 caracteres.');window.location='../vistas/signup.html';</script>";
        exit();
    }

    if((strlen($correo)<=9) or (strlen($correo)>=51)){
        echo "<script>alert('ERROR: Su correo debe tener entre 10 y 50 caracteres.');window.location='../vistas/signup.html';</script>";
        exit();
    }

    if((strlen($clave)<=7) or (strlen($clave)>=13)){
        echo "<script>alert('ERROR: Su contraseña debe tener entre 8 y 12 caracteres.');window.location='../vistas/signup.html';</script>";
        exit();
    }


    //validaciones de repetición
    $query="SELECT * from usuario where nombre='$nombre'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num!=0){
            echo "<script>alert('ERROR: Este nombre de usuario ya está asociado a una cuenta.');window.location='../vistas/signup.html';</script>";
            exit();
        }
    }

    $query="SELECT * from usuario where correo='$correo'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num!=0){
            echo "<script>alert('ERROR: Este correo ya está asociado a una cuenta.');window.location='../vistas/signup.html';</script>";
            exit();
        }
    }

    //guardar registro
    $query="INSERT INTO `usuario`(`nombre`, `clave`, `correo`, `imagen`, `fechaCreacion`) 
    VALUES ('$nombre','$clave','$correo','','$fechacreacion')";
    $res=mysqli_query($conexion, $query);
    if (!$res){
        echo "<script>alert('ERROR: No se guardó su usuario. Vuelva a intentar.');window.location='../vistas/signup.html';</script>";
        exit();
    }

    echo "<script>alert('¡Su usuario se ha registrado!');window.location='';</script>";
    exit();
}
?>