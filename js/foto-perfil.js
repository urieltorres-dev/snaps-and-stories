const formularioSubirFoto = document.getElementById("formulario-foto-perfil");
const foto = document.getElementById("foto");

// Handling del evento submit del formulario de registro.
formularioSubirFoto.addEventListener("submit", async function(event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();

    // Validamos que los campos no estén vacíos.
    if(foto.value == ""){
        alert("Debe de llenar todos los campos son obligatorios")
        return;
    }

    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y
    const datos = new FormData();
    datos.append("foto", foto.files[0]);

    // Hacemos la petición AJAX por POST.
    const respuesta = await fetch("app/foto-perfil.php", {
        method: "POST",
        body: datos,
    });

    // Obtenemos la respuesta en formato JSON.
    const respuestaJSON = await respuesta.json();

    // Si ocurrio un error, mostramos el mensaje de error.
    if(respuestaJSON.error){
        alert(respuestaJSON.error);
        return;
    }

    // Recargamos la página.
    location.reload();

});
