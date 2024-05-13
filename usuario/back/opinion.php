<?php
if(isset($_POST['idrestaurante'])){
    //incluir mantener sesion
    include 'sesion.php';

    //incluir conexion a bdd
    include '../../BDD/conexion.php';

    $comentario=$_POST['comentario'];
    $idrestaurante=$_POST['idrestaurante'];
    $puntaje=$_POST['puntaje'];

    //validaciones
    if($sesion==''){
        echo "<script>alert('ERROR: Debe iniciar sesión para hacer un comentario.');history.go(-1);</script>";
        exit();
    }

    $query="INSERT INTO `puntaje`(`puntaje`, `usuarioID`, `restauranteID`, `comentario`) 
    VALUES ('$puntaje','$sesion','$idrestaurante','$comentario')";
    $res=mysqli_query($conexion,$query);
    if($res){
        echo "<script>alert('Su comentario se ha publicado exitosamente.');history.go(-1);</script>";
        exit();
    }else{
        echo "<script>alert('ERROR: Su comentario no se ha publicado. Vuelva a intentar.');history.go(-1);</script>";
        exit();
    }

}else{
    echo "<script>history.go(-1);</script>";
    exit();
}
