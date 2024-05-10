<?php
include ("../../BDD/conexion.php");
include 'sesion.php';
echo $sesion;
//PRIMER FORM

    if (isset($_POST['clave'])){
        //obtener datos nuevos
        $nombre=$_POST['nombre'];
        $correo=$_POST['correo'];
        $biografia=$_POST['biografia'];
        $clave=$_POST['clave'];

        //obtener datos originales
        $query="SELECT nombreUsuario, clave, correo, biografia, imagen from usuario where usuarioID='$sesion'";
        $res=mysqli_query($conexion, $query);
        if ($res){
            $datosprevio=mysqli_fetch_assoc($res);
            $clavep=$datosprevio['clave'];
            $nombrep=$datosprevio['nombreUsuario'];
            $correop=$datosprevio['correo'];
            $biografiap=$datosprevio['biografia'];
        }
     
                //validaciones de clave
        if($clave!==$clavep){
            echo '<script>alert("ERROR: La contraseña es incorrecta.");history.go(-1);</script>';
            exit();
        }
        
        //nombre de usuario
        if ($nombre==''){
            $nombre=$nombrep;
        }else{
            //validaciones
            //si el nombre es distinto al original
            if ($nombre!==$nombrep){
                //si el nombre ya está asociado a un usuario
                $query="SELECT usuarioID from usuario where nombreUsuario='".$nombre."'";
                $res=mysqli_query($conexion, $query);
                if ($res){
                    $num=mysqli_num_rows($res);
                    if($num!=0){
                        echo '<script>alert("ERROR: Este nombre de usuario no está disponible.");history.go(-1);</script>';
                        exit();
                    }
                }
            }
        }
        
        
        //correo
        if($correo==''){
            $correo=$correop;
        }else{
        //validaciones
        //si el correo es distinto al original
            if($correo!==$correop){
                //si el correo ya está asociado a un usuario
                $query="SELECT usuarioID from usuario where correo='".$correo."'";
                $res=mysqli_query($conexion, $query);
                if ($res){
                    $num=mysqli_num_rows($res);
                    if($num!=0){
                        echo '<script>alert("ERROR: Este correo no está disponible.");history.go(-1);</script>';
                        exit();
                    }
                }
            }
        }

        //biografia
        if($biografia==''){
            $biografia=$biografiap;
        }

        //actualizar datos
        $query="UPDATE `usuario` 
        SET `nombreUsuario`='".$nombre."',`correo`='".$correo."', `biografia`='".$biografia."' 
        where usuarioID=".$sesion."";
        $res=mysqli_query($conexion,$query);
        if($res){
            echo '<script>alert("Se ha actualizado exitosamente");window.location="../vistas/perfil.php";</script>';
            exit();
        }else{
            echo '<script>alert("ERROR: No se pudo actualizar. Vuelva a intentar.");history.go(-1);</script>';
            exit();
        }
    }

//SEGUNDO FORM
    if(isset($_GET['clave'])){
        $clave=$_GET['clave'];
        $clavenueva=$_GET['clavenueva'];
        $clavenueva2=$_GET['clavenueva2'];

        //validar clave
        $query="SELECT usuarioID from usuario where clave='$clave' AND usuarioID='$sesion'";
        $res=mysqli_query($conexion, $query);
        if ($res){
            $num=mysqli_num_rows($res);
            if($num==0){
               echo "<script>alert('ERROR: La contraseña es incorrecta.');history.go(-1);</script>";
                exit();
            }
        }

        //igualar claves
        if($clavenueva!=$clavenueva2){
            echo "<script>alert('ERROR: Las contraseñas no son iguales.');history.go(-1);</script>";
                exit();
        }

        if($clavenueva==$clave){
            echo "<script>alert('ERROR: No puedes actualizar con la misma contraseña.');history.go(-1);</script>";
                exit();
        }

        $query="UPDATE `usuario` 
        SET `clave`='$clavenueva'
        where usuarioID='$sesion'";
        $res=mysqli_query($conexion,$query);
        if($res){
            echo '<script>alert("Su contraseña se ha actualizado exitosamente");window.location="../vistas/perfil.php";</script>';
            exit();
        }else{
            echo '<script>alert("ERROR: Su contraseña no se pudo actualizar. Vuelva a intentar.");history.go(-1);</script>';
            exit();
        }
    }

?>