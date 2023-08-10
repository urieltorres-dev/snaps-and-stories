const formularioSubirFoto = document.getElementById("formulario-subir-foto");
const foto = document.getElementById("foto");
const descripcion = document.getElementById("descripcion");

// Handling del evento submit del formulario de registro.
formularioSubirFoto.addEventListener("submit", async function(event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();

    // Validamos que los campos no estén vacíos.
    if(foto.value == ""){
        alert("Debe de llenar todos los campos son obligatorios")
        return;
    }

    // Validamos que la descripción tenga una longitud máxima de 1024 caracteres.
    if(descripcion.value.length > 1024){
        alert("La descripción no debe de ser mayor a 1024 caracteres")
        return;
    }

    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y
    const datos = new FormData();
    datos.append("foto", foto.files[0]);
    datos.append("descripcion", descripcion.value);

    // Hacemos la petición AJAX por POST.
    const respuesta = await fetch("app/subir-foto.php", {
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
    location.assign("home.php#close");
    location.reload();

});
