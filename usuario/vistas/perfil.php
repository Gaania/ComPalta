<?php
//incluir mantener sesion
include '../back/sesion.php';

//incluir conexion a bdd
include '../../BDD/conexion.php';

//metodo get para acceder a algún perfil
//si la variable get coincide con la variable de sesion, se activa la configuración
if (isset($_GET['usuario'])){
    if($_GET['usuario']==$sesion){
        echo 'funciona';
    }else{
        echo 'nofunciona';
    }
}

//obtener todos los datos de la bdd
$sql = "SELECT nombreUsuario, imagen, fechaCreacion, biografia, correo
    FROM usuario where 
    usuarioID=1";
    $usuario= mysqli_query($conexion, $sql);
    if (!$usuario){
        echo "<script>alert('Ha ocurrido un error. Vuelva a intentar.');history.go(-1);</script>";
        exit();
    }

    $valores=mysqli_fetch_assoc($usuario);

    $nombre= wordwrap($valores['nombreUsuario']);
    $fechacreacion= date("d-m-Y",strtotime($valores['fechaCreacion'])); 
    $imagen= $valores['imagen'];
    $correo= $valores['correo'];
    if($valores['biografia']){
        $biografia= wordwrap($valores['biografia']);
    }else{
        $biografia='';
    }
    
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


//obtener registros de listas del usuario
$sql="SELECT `listaID`, `nombreLista` FROM `lista` WHERE usuarioID=4";
$lis=mysqli_query($conexion,$sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/nav.css">
    <title>Perfil</title>
</head>
<body>

    <!--nav!-->
    <nav class="nav">
        <div class="logo">
            <a href="index.php">
                <img class="img" src="img/logo_palta.png" >
            </a> 
        </div>   
        <ul>
            <li ><a class="enla" href="restaurantes.php"><span class="fa-solid fa-shop"></span>    Restaurantes</a></li> 
            <li><a class="enla" href="comidas.php"><span class="fa-solid fa-carrot"></span>   Comidas</a></li>
            <li>
            <div class="search">
                <input type="text" class="search__input" placeholder="Buscar">
                <button class="search__button">
                    <svg class="search__icon" aria-hidden="true" viewcuadro="0 0 24 24">
                        <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                        </g>
                    </svg>
                </button>
            </div></li>
        </ul>
        <div class="usuario">
        <?php 
        if(isset($_SESSION["sesion"])){
            echo'<a id="uss" href=""><img src="img\icono_us1.jpg" ></a>
            <ul class="sub-elemento1">
                <li class="li"><a><span class="fa-solid fa-user" style="color: #ffffff;"></span>     Perfil</a></li>
                <li class="li"><a href=""><span class="fa-solid fa-bookmark"></span>   Guardados</a></li>
                <li class="li"><a href=""><span class="fa-solid fa-right-to-bracket"></span>      Cerrar sesión</a></li>
            </ul>';
        }
        else{
            echo'<a id="uss" href=""><img src="img\icono_us1.jpg" ></a>
                <ul class="sub-elemento2">
                    <li class="li" ><a href="iniciar-sesion.thml"><span class="fa-solid fa-right-to-bracket"></span>     Iniciar sesión</a></li>
                    <li class="li"><a href="#"><span class="fa-solid fa-user-plus"></span>   Crear cuenta</a></li>
            </ul>';
        }
        ?>
        </div>
    </nav>

        <!--tab-->
    <section class="tab">
        <button class="tablinks" onclick="abrirperfil(event, 'tabperfil')"><h2>Perfil</h2></button>
        <button class="tablinks" onclick="abrirTab(event, 'tabopinion')"><h2>Opiniones</h2></button>
        <button class="tablinks" onclick="abrirTab(event, 'tabguardado')"><h2>Guardados</h2></button>
        <button class="tablinks" onclick="config()"><h2>Configuración</h2></button>
    </section>
       
    <!--inicio grid-->
    <div class="grid" id="grid">
        <!-- Contenido de información de usuario -->
        <section class="usuario" id="usuario">
            
            <h1 class="nombreus" id="nombreus" style="display:none;"><?php echo $nombre; ?></h1>
            <div class="espacioenblanco" id="espacioenblanco" style="display:block;"></div>
            <div class="imagen">
            <?php
            echo'
              <img src="../'.$imagen.'" alt="perfil">
              ';
            ?>
            </div>
            <div class="fecha">
                fecha de creación 
                <br>
                <?php echo $fechacreacion; ?>
            </div>
        </section>

        <!-- Contenido de las pestaña !-->
            <section id="tabperfil" class="tabcontenido" >
            <h1><?php echo $nombre; ?></h1>
                <div class="bio">
                    
                    <h2><?php echo $biografia; ?></h2>
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
                    <?php
                        //si hay registros
                        if($lis){
                            //mientras hayan registros
                            while($lista=mysqli_fetch_assoc($lis)){
                                // info de lista
                                $ID= $lista['listaID'];
                                $nombre= $lista['nombreLista'];
                                
                                echo '<p>'.$nombre.'</p>';
                                //obtener guardados segun su lista
                                $sql="SELECT `nombre`
                                FROM `guardado` 
                                inner join restaurante
                                on guardado.restauranteID=restaurante.restauranteID
                                WHERE listaID=$ID";
                                $guar=mysqli_query($conexion,$sql);
                                if($guar){
                                    while($guardados=mysqli_fetch_assoc($guar)){    
                                        echo '<div class="caja">
                                            <span>'.$guardados['nombre'].'</span>
                                        </div>';
                                    }
                                }
                            }
                            
                        }
                    ?>
                </div>
            </section>


        </div>

        <!-- Contenido de configuración !-->
        <section class="configuracion">
            <div class="formularioperfil">
                <h1>Perfil público</h1>
                <form action="../back/configuraciones.php" method="post">
                    <?php
                    echo'
                    
                        <p>Nombre de usuario</p>
                        <input type="text" name="nombre" id="nombre" maxlength="15" minlength="4" value="'.$nombre.'">
                    
                        <p>Biografía</p>
                        <input type="text" name="biografia" id="biografia" maxlength="200" value="'.$biografia.'">
                    
                        <p>Dirección de correo</p>
                        <input type="text" name="correo" id="correo" maxlength="15" minlength="4" value="'.$correo.'">
                    
                    ';
                    ?>
                    <span id="inputclave" class="inputclave" style="display: none;">
                        <p>Ingresar clave</p>
                        <input type="text" name="clave" id="clave" maxlength="12" minlength="8" required>
                    </span>
                    <span class="botones">
                        <input class="boton" id="actualizar" value="Actualizar" onclick="ingresarclave()"> <br>
                        <input class="boton" id="enviar" type="submit" style="display:none;">
                    </span>
                    </form>

                    <span class="cambiarimagen">
                        <?php
                        echo'
                        <img src="../'.$imagen.'" alt="perfil">
                        ';
                        ?>
                        <form id="subirImagen" enctype="multipart/form-data">                       
                        <button class="botonimg" type="submit">Subir <br> Imagen</button>
                        <div class="cambiarboton">
                            <input class="imagennueva" name="imagennueva" id="imagennueva"type="file">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icono"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                        </div> 
                        <?php
                        echo'
                        <a href="../back/eliminarimagen.php?img='.$imagen.'" class="botonimg">Eliminar imagen</a>
                        ';
                        ?>
                        </form>
                        
                        <div id="message"></div>
                    </span>
                    
                
            </div>

            <div class="formularioclave">
                <form action="../back/configuraciones.php" method="get">
                    <?php
                        echo'
                        <h2>Cambiar contraseña</h2>
                        <span>
                            <p>Contraseña actual</p>
                            <input type="password" name="clave" id="clave" maxlength="12" minlength="8" required>
                        </span>
                        <span>
                            <p>Nueva contraseña</p>
                            <input type="password" name="clavenueva" id="clavenueva" maxlength="12" minlength="8" required>
                        </span>
                        <span>
                            <p>Verifica la nueva contraseña</p>
                            <input type="password" name="clavenueva2" id="clavenueva2" maxlength="12" minlength="8" required>
                        </span>
                        
                            <input class="boton" value="Actualizar"id="boton" type="submit" style="height:3rem; margin-top: 2.5rem;">
                        ';
                    ?>
                    </form>
                </div>
        </section>
        
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
            document.getElementById('grid').style.display = 'grid';
            document.getElementById('nombreus').style.display = 'block';
            document.getElementById('espacioenblanco').style.display = 'none';
            evt.currentTarget.className += " active";
        }

        function abrirperfil(evt, tabId){
            abrirTab(evt, tabId);
            document.getElementById('nombreus').style.display = 'none';
            document.getElementById('espacioenblanco').style.display = 'block';
        }
        function config(){
             // Ocultar informacion de usuario
            document.getElementById('grid').style.display = 'none';
        }

        function ingresarclave(){
            document.getElementById('inputclave').style.display = 'flex';
            document.getElementById('enviar').style.display = 'block';
            document.getElementById('actualizar').style.display = 'none';
        }
    </script>

    <script src="../back/script.js"></script>

</body>
</html>