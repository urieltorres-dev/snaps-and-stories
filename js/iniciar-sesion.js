const formularioInicioSesion = document.getElementById('formulario-inicio-sesion');
const username = document.getElementById('username');
const password = document.getElementById('password');

// Handling del evento submit del formulario de inicio de sesión.
formularioInicioSesion.addEventListener('submit', async function (event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();
    
    // Validamos que los campos no estén vacíos.
    if (username.value == '' || password.value == '') {
        alert('Debe de llenar todos los campos son obligatorios');
        return;
    }

    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y
    // se va poniendo los datos que queremos enviar por la petición AJAX por POST.
    const datos = new FormData();
    datos.append('username', username.value);
    datos.append('password', password.value);
    
    // Hacemos la petición AJAX por POST.
    const respuesta = await fetch('app/iniciar-sesion.php', {
        method: 'POST',
        body: datos,
    });
    
    // Obtenemos la respuesta en formato JSON.
    const respuestaJSON = await respuesta.json();
    
    // Si ocurrio un error, mostramos el mensaje de error.
    if (respuestaJSON.error) {
        alert(respuestaJSON.error);
        return;
    } 

    // Redireccionamos al usuario a la home.
    location.assign('home.php') 

});
