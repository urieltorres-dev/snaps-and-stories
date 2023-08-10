const formularioCambiarContraseña = document.getElementById('formulario-cambiar-contraseña');
const contraseñaActual = document.getElementById('contraseña-actual');
const contraseñaNueva = document.getElementById('contraseña-nueva');
const repetirContraseñaNueva = document.getElementById('repetir-contraseña-nueva');

// Handling del evento submit del formulario de inicio de sesión.
formularioCambiarContraseña.addEventListener('submit', async function (event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();
    
    // Validamos que los campos no estén vacíos.
    if (contraseñaActual.value == '' || contraseñaNueva.value == '' || repetirContraseñaNueva.value == '') {
        alert('Debe de llenar todos los campos son obligatorios');
        return;
    }
    
    // Validamos que las contraseñas coincidan.
    if (contraseñaNueva.value != repetirContraseñaNueva.value) {
        alert('Las contraseñas no coinciden');
        return;
    }

    // Validamos que la password tenga una longitud mínima de 6 caracteres.
    if (contraseñaNueva.value.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y
    // se va poniendo los datos que queremos enviar por la petición AJAX por POST.
    const datos = new FormData();
    datos.append('contraseña-actual', contraseñaActual.value);
    datos.append('contraseña-nueva', contraseñaNueva.value);
    
    // Hacemos la petición AJAX por POST.
    const respuesta = await fetch('app/cambiar-contrasena.php', {
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

    // Redireccionamos al usuario a iniciar sesion.
    location.assign('helpers/logout.php') 

});
