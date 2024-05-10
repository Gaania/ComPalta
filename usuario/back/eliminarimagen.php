<?php
    include '../../BDD/conexion.php';
    include 'sesion.php';

    if (isset($_SESSION)){
        if(isset($_GET['img'])){

            $imagen='../'.$_GET['img'].'';
            $imagenestandar='img/usuarioestandar.png';
            if($_GET['img']==$imagenestandar){
                echo "<script>alert('ERROR:No puede eliminar esa imagen.');history.go(-1);</script>";
                exit();
            }else{
                //eliminar la imagen de carpeta local
                if(unlink($imagen)){
                    //eliminar la imagen y poner una estándar
                    $query="UPDATE usuario SET `imagen`='$imagenestandar' WHERE usuarioID='$sesion'";
                    $res=mysqli_query($conexion,$query);
                    if($res){
                        echo "<script>window.location='../vistas/perfil.php';</script>";
                        exit();
                    }
                }else{
                    echo "<script>alert('ERROR:No se pudo eliminar su imagen de perfil.');history.go(-1);</script>";
                    exit();
                }
            }
            
            
        }
        
    }
    
    
?>