<?php
//incluir mantener sesion
include '../back/sesion.php';

//incluir conexion a bdd
include '../../BDD/conexion.php';

//obtener las opiniones de un restaurante
$query="SELECT `nombreUsuario`, `puntaje`, `comentario` 
FROM `puntaje` 
inner join usuario on puntaje.usuarioID=usuario.usuarioID 
inner join restaurante on puntaje.restauranteID=restaurante.restauranteID 
WHERE puntaje.restauranteID=1";
$op=mysqli_query($conexion,$query);
?>
<head>
    <link rel="stylesheet" href="css/opiniones.css">
</head>
<?php
    
?>
<!--Botón para escribir una opinion!-->
    <button id="comentar" onclick="sesioniniciada()">Comentar</button>

    <!-- De tener la sesion iniciada, aparece el form !-->
    <div id="enviaropinion" class="enviaropinion" style="display:none;">
        <H2>Haz un comentario</H2>
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
                    <input type="submit" id="enviar" >
            </form>
    </div>

    <!-- De no tener la sesion iniciada, botón para login !-->
    <div id="iniciarsesion" class="iniciarsesion" style="display:none;">
        INICIE SESION
    </div>

<!-- Contenedor de opiniones, lista !-->
<div class="contenedoropiniones">
    <h2>Comentarios</h2>
    <?php
    if($op){
        while($opinion=mysqli_fetch_assoc($op)){
            
            $nombreusuario= $opinion['nombreUsuario'];
            $puntaje=$opinion['puntaje'];
            $comentario=utf8_encode($opinion['comentario']);
            
            echo'
            <section class="opinion">
                <div class="puntaje">';
                    for($a=0;$a<$puntaje;$a++){
                        echo'<span class="estrellas"></span>';
                    }
                echo'
                </div>
                <p class="nombre"><a href="perfil.php?us='.$nombreusuario.'" id="link">'.$nombreusuario.'</a></p>
                <p class="comentario">'.$comentario.'</p>
            </section>
            ';
        }
    }
    ?>
</div>

<script>
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
</script>