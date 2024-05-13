<?php
//incluir mantener sesion
include '../back/sesion.php';

//incluir conexion a bdd
include '../../BDD/conexion.php';

//obtener las opiniones de un restaurante
$query="SELECT `nombreUsuario`, `puntaje`, `comentario` 
FROM `puntaje` 
inner join usuario on puntaje.usuarioID=usuario.usuarioID 
WHERE restauranteID=1";
$op=mysqli_query($conexion,$query);
?>
<head>
    <link rel="stylesheet" href="css/opiniones.css">
</head>
<?php
    
?>
<section class="botonesopiniones">
    <!--Botón para escribir una opinion!-->
    <button id="comentar" onclick="sesioniniciada()">Comentar</button>

    <!-- De no tener la sesion iniciada, botón para login !-->
    <div id="iniciarsesion" class="iniciarsesion" style="display:none;">
        <a href="login.html"><p>Iniciar Sesión</p></a>
    </div>
</section>
     <!-- De tener la sesion iniciada, aparece el form !-->
     <div id="enviaropinion" class="enviaropinion" style="display:none;">
        <section class ="primeralinea">
            <H2>Haz un comentario</H2>
            <button id="cerrar" onclick="cerrarventana()">X</button>
        </section>
            <form action="../back/opinion.php" method="post">
                <input type="text" name="comentario" id="comentario" maxlength="200" minlength="50" required>
                <!-- Estrellas !-->
                <div class="puntajecontenedor">
                    <input value="5" name="puntaje" id="star5" type="radio">
                    <label title="text" for="star5"></label>
                    <input value="4" name="puntaje" id="star4" type="radio">
                    <label title="text" for="star4"></label>
                    <input value="3" name="puntaje" id="star3" type="radio" checked="">
                    <label title="text" for="star3"></label>
                    <input value="2" name="puntaje" id="star2" type="radio">
                    <label title="text" for="star2"></label>
                    <input value="1" name="puntaje" id="star1" type="radio">
                    <label title="text" for="star1"></label>
                </div>
                <input type="hidden" name="idrestaurante" id="idrestaurante" value="1" required>

                    <input type="submit" id="enviar" >
            </form>
    </div>

<!-- Contenedor de opiniones, lista !-->
<div class="contenedoropiniones">
    <h2>Comentarios</h2>
    <?php
    if($op){
        $num=mysqli_num_rows($op);
        
        for ($n=0;$n<$num;$n++){
            $opinion=mysqli_fetch_assoc($op);
                $nombreusuario= mb_convert_encoding($opinion['nombreUsuario'], 'UTF-8', 'ISO-8859-1');
                $puntaje=$opinion['puntaje'];
                $comentario=mb_convert_encoding($opinion['comentario'], 'UTF-8', 'ISO-8859-1');
                
                echo'
                <section class="opinion">
                    <div class="puntaje">';
                        for($a=0;$a<$puntaje;$a++){
                            echo'<span class="estrellas"></span>';
                        }
                    echo'
                    </div>
                    <p class="nombre"><a href="perfil.php?usuario='.$nombreusuario.'" id="link">'.$nombreusuario.'</a></p>
                    <p class="comentario">'.$comentario.'</p>
                </section>
                ';
            
        }
    }
    ?>
</div>

<script>

    /* Mostrar para comentar o iniciar sesión según $_SESSION */
    function sesioniniciada(){
        var sesion="<?php echo $sesion;?>";
        if(sesion!=''){
            document.getElementById('enviaropinion').style.display = 'block';
            document.getElementById('iniciarsesion').style.display = 'none';
        }else{
            document.getElementById('enviaropinion').style.display = 'none';
            document.getElementById('iniciarsesion').style.display = 'block';
        }
    }

    function cerrarventana(){
        document.getElementById('enviaropinion').style.display = 'none';
    }
    /* Cerrar la ventana de comentario si se clickea afuera */

    
</script>
