<?php

if(isset($_GET)){
    //pasar variables
    $correo=$_GET['correo'];
    $clave=$_GET['clave'];

    //conexion a la bdd
    include ("../../BDD/conexion.php");

    //validaciones
    $query="SELECT * from usuario where correo='$correo'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num==0){
            echo "<script>alert('ERROR: Este correo no está asociado a una cuenta.');window.location='../vistas/login.html';</script>";
            exit();
        }
    }

    $query="SELECT * from usuario where correo='$correo' and clave='$clave'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num!=0){
            session_start();
            $_SESSION["sesion"] = $nombre;
            echo "<script>alert('Has iniciado sesión');window.location='../vistas/perfil.php';</script>";
            exit();
        }else{
            echo "<script>alert('ERROR: El correo o contraseña son incorrectos.');window.location='../vistas/login.html';</script>";
            exit();
        }
    }


}