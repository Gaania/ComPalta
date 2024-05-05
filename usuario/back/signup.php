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
        echo "<script>alert('ERROR: Las contraseñas no son iguales');history.go(-1);</script>";
        exit();
    }

    if((strlen($nombre)<=3) or (strlen($nombre)>=16)){
        echo "<script>alert('ERROR: Su nombre de usuario debe tener entre 4 y 15 caracteres.');history.go(-1);</script>";
        exit();
    }

    if((strlen($correo)<=9) or (strlen($correo)>=51)){
        echo "<script>alert('ERROR: Su correo debe tener entre 10 y 50 caracteres.');history.go(-1);</script>";
        exit();
    }

    if((strlen($clave)<=7) or (strlen($clave)>=13)){
        echo "<script>alert('ERROR: Su contraseña debe tener entre 8 y 12 caracteres.');history.go(-1);</script>";
        exit();
    }


    //validaciones de repetición
    $query="SELECT * from usuario where nombreUsuario='$nombre'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num!=0){
            echo "<script>alert('ERROR: Este nombre de usuario ya está asociado a una cuenta.');history.go(-1);</script>";
            exit();
        }
    }

    $query="SELECT * from usuario where correo='$correo'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $num=mysqli_num_rows($res);
        if($num!=0){
            echo "<script>alert('ERROR: Este correo ya está asociado a una cuenta.');history.go(-1);</script>";
            exit();
        }
    }

    //guardar registro
    $query="INSERT INTO `usuario`(`nombreUsuario`, `clave`, `correo`, `fechaCreacion`, `tipoUsuarioID`) 
    VALUES ('$nombre','$clave','$correo','$fechacreacion','2')";
    $res=mysqli_query($conexion, $query);
    if (!$res){
        echo "<script>alert('ERROR: No se guardó su usuario. Vuelva a intentar.');history.go(-1);</script>";
        exit();
    }

    //obtener el ID del usuario recién creado
    $query="SELECT usuarioID from usuario where nombreUsuario='$nombre'";
    $res=mysqli_query($conexion, $query);
    if ($res){
        $usuario=mysqli_fetch_assoc($res);
        $ID=$usuario['usuarioID'];

        //Crear lista para guardar restaurantes, de no funcionar se borra el perfil del usuario
        $query="INSERT INTO `lista`(`usuarioID`, `nombreLista`) 
        VALUES ('$ID','Por visitar')";
        $res=mysqli_query($conexion, $query);
        if (!$res){
            $query="DELETE FROM usuario WHERE usuarioID='$ID'";
            echo "<script>alert('ERROR: No se guardó su usuario. Vuelva a intentar.');history.go(-1);</script>";
            exit();
        }
        
        //iniciar sesión del usuario, con su ID
        session_start();
        $_SESSION["sesion"] = $usuario['usuarioID'];
        echo "<script>alert('¡Su usuario se ha registrado!');window.location='../vistas/perfil.php';</script>";
        exit();
    }

}
?>