<?php
//incluir mantener sesion
include '../back/sesion.php';

//incluir conexion a bdd
include '../../BDD/conexion.php';

//metodo get para acceder a algún perfil
//si la variable get coincide con la variable de sesion, se activa la configuración
if (isset($_GET['usuario'])){
    if($_GET['usuario']==$sesion){
        
    }
}

//obtener todos los datos de la bdd
$sql = "SELECT nombreUsuario, imagen, fechaCreacion, biografia 
    FROM usuario where 
    usuarioID=4";
    $usuario= mysqli_query($conexion, $sql);
    if (!$usuario){
        echo "<script>alert('Ha ocurrido un error. Vuelva a intentar.');history.go(-1);</script>";
        exit();
    }

    $valores=mysqli_fetch_assoc($usuario);

    $nombre= wordwrap(utf8_encode($valores['nombreUsuario']));
    $fechacreacion= date("d-m-Y",strtotime($valores['fechaCreacion'])); 
    $imagen= $valores['imagen'];
    $biografia= wordwrap(utf8_encode($valores['biografia']));

//obtener datos de opiniones
$sql="SELECT `nombre`,`nombreComida`, `puntaje`, `comentario` 
    FROM `puntaje` 
    inner join usuario 
    on puntaje.usuarioID=usuario.usuarioID
    inner join comida
    on puntaje.comidaID=comida.comidaID
    inner join restaurante
    on comida.restauranteID=restaurante.restauranteID
    WHERE usuario.usuarioID=4";
    $datos= mysqli_query($conexion,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>Perfil</title>
</head>
<body>

    <!--nav-->
    <div class="nav">
    </div>

    <!--inicio grid-->
    <div class="grid">
        <!--tab-->
        <section class="tab">
            <button class="tablinks" onclick="abrirTab(event, 'tabperfil')"><h2>Perfil</h2></button>
            <button class="tablinks" onclick="abrirTab(event, 'tabopinion')"><h2>Opiniones</h2></button>
            <button class="tablinks" onclick="abrirTab(event, 'tabguardado')"><h2>Guardados</h2></button>
        </section>
       
        <!--perfil-->
        <section class="usuario">
            
            <h1 class="nombre"><?php echo $nombre; ?></h1>
            <div class="imagen">
              <img src="../img/usuarioestandar.png" alt="perfil">
            </div>

            <div class="fecha">
                fecha de creación 
                <br>
                <?php echo $fechacreacion; ?>
            </div>
        </section>

        <!-- Contenido de las pestaña !-->
            <section id="tabperfil" class="tabcontenido">
                <div class="bio">
                    <h2><?php echo $biografia; ?></h2>
                </div>
                <div class="frec">
                    <h2>Opiniones populares</h2>
                </div>
            </section>
            
            <section id="tabopinion" class="tabcontenido" style="display:none;">
                <h1 class="titulo">Opiniones</h1>
                <div class="listado">
                    <?php
                    if($datos){
                        while ($opinion=mysqli_fetch_assoc($datos)){
                            $comidanombre= $opinion['nombreComida'];
                            $restaurantenombre= $opinion['nombre'];
                            $puntaje=$opinion['puntaje'];
                            $comentario=$opinion['comentario'];
                            echo '<div class="caja">
                            <p>'.$comidanombre.'</p>
                            <p>'.$restaurantenombre.'</p> 
                            <p>'.$puntaje.'</p><p>'.$comentario.'</p>
                            </div>';
                        }
                        
                    }
                    
                    ?>
                </div>
            </section>
            
            <section id="tabguardado" class="tabcontenido" style="display:none;">
                <h1 class="titulo">Guardados</h1>
                <div class="listado">
                    <div class="caja">

                    </div>
                    <div class="caja">

                    </div>
                    <div class="caja">

                    </div>
                    <div class="caja">

                    </div>
                    <div class="caja">

                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        function abrirTab(evt, tabId) {
            var i, tabcontent, tablinks;
    
            // Ocultar todos los elementos con clase "tabcontenido"
            tabcontent = document.getElementsByClassName("tabcontenido");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
    
            // Remover la clase "active" de todos los elementos con clase "tablinks"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
    
            // Mostrar el contenido de la pestaña seleccionada y agregar la clase "active" al botón
            document.getElementById(tabId).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function config(){

        }
    </script>
</body>
</html>