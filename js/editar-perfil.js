const formularioEditarPerfil = document.getElementById('formulario-editar-perfil');
const email = document.getElementById('email');
const nombre = document.getElementById('nombre');
const apellidos = document.getElementById('apellidos');
const genero = document.getElementById('genero');

// Handling del evento submit del formulario de registro.
formularioEditarPerfil.addEventListener('submit', async function (event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();
    
    // Validamos que los campos no estén vacíos.
    if (email.value == '' || nombre.value == '') {
        alert('Debe de llenar todos los campos son obligatorios');
        return;
    }
    
    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y 
    // se va poniendo los datos que queremos enviar por la petición AJAX por POST.
    const datos = new FormData();
    datos.append('email', email.value);
    datos.append('nombre', nombre.value);
    datos.append('apellidos', apellidos.value);
    datos.append('genero', genero.value);
    
    // Hacemos la petición AJAX por POST.
    const respuesta = await fetch('app/editar-perfil.php', {
        method: 'POST',
        body: datos,
    });
    
    // Obtenemos la respuesta del servidor.
    const respuestaJSON = await respuesta.json();
    
    // Si ocurrio un error, mostramos el mensaje de error.
    if (respuestaJSON.error) {
        alert(respuestaJSON.error);
        return;
    }

    // Redireccionamos al usuario al perfil.
    location.assign(`perfil.php?username=${respuestaJSON.username}`) 

});
