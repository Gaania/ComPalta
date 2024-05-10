document.getElementById("subirImagen").addEventListener("submit", function(event) {
    event.preventDefault();
    var formData = new FormData();
    var file = document.getElementById("imagennueva").files[0];
    formData.append("imagennueva", file);
    
    if(!file){
        location.reload();
    }else{
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "../back/upload.php", true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById("message").innerHTML = xhr.responseText;
            } else {
                document.getElementById("message").innerHTML = "Error al subir la imagen.";
            }
        };

        xhr.send(formData);
        
    }
});

        
            