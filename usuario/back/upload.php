<?php
include '../../BDD/conexion.php';
include 'sesion.php';
if ($_FILES["imagennueva"]["error"] > 0) {
    echo "Error: " . $_FILES["imagennueva"]["error"];
} else {
    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["imagennueva"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $nombreimagennueva=htmlspecialchars( basename( $_FILES["imagennueva"]["name"]));
    
    // Verificar si el archivo es una imagennueva real o una imagennueva falsa
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imagennueva"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["imagennueva"]["size"] > 500000) {
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado en 0 por algún error
    if ($uploadOk == 0) {
        echo "El archivo no fue subido.";
        $query="UPDATE usuario SET `imagen`='img/usuarioestandar.png' WHERE usuarioID='$sesion'";
        $res=mysqli_query($conexion,$query);
    // Si todo está bien, intentar subir el archivo
    } else {

            $query="UPDATE usuario SET `imagen`='img/$nombreimagennueva' WHERE usuarioID='$sesion'";
            $sql=mysqli_query($conexion,$query);
            if ($sql){
                if (move_uploaded_file($_FILES["imagennueva"]["tmp_name"], $target_file)) {
                    echo "Se actualizó su imagen de perfil";
                }
            }else{
                echo "Error al subir el archivo.";
            }
        }
    }

?>
