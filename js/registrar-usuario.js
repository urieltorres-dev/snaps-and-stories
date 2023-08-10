const formularioRegistro = document.getElementById("formulario-registro")
const username = document.getElementById("username")
const email = document.getElementById("email")
const password = document.getElementById("password")
const confirmPassword = document.getElementById("password-confirm")
const nombre = document.getElementById("nombre")
const apellidos = document.getElementById("apellidos")
const genero = document.getElementById("genero")

// Handling del evento submit del formulario de registro.
formularioRegistro.addEventListener("submit", async function(event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault()

    // Validamos que los campos no estén vacíos.
    if(username.value == "" || email.value == "" || password.value == "" || confirmPassword.value == "" || nombre.value == ""){
        alert("Debe de llenar todos los campos son obligatorios")
        return;
    }

    // Validar que el username tenga una longitud mínima de 2 caracteres
    if (username.value.length < 2) {
        alert("El username debe tener al menos 2 caracteres")
        return;
    }

    // Validar que el username empiece con una letra minúscula
    if (!username.value.match(/^[a-z]/)) {
        alert("El username debe empezar con una letra minúscula")
        return;
    }

    // Validar que el username solo contenga letras minúsculas, números y guiones bajos
    if (!username.value.match(/^[a-z0-9_]+$/)) {
        alert("El username solo puede contener letras minúsculas, números y guiones bajos")
        return;
    }

    // Validamos que las contraseñas coincidan.
    if(password.value != confirmPassword.value){
        alert("Las contraseñas no coinciden")
        return;
    }

    // Validamos que la password tenga una longitud mínima de 6 caracteres.
    if(password.value.length < 6){
        alert("La contraseña debe tener al menos 6 caracteres")
        return;
    }

    // Para enviar los datos manualmente, creamos un objeto de tipo FormData y 
    // se va poniendo los datos que queremos enviar por la petición AJAX por POST.
    const datos = new FormData();
    datos.append("username", username.value)
    datos.append("email", email.value)
    datos.append("nombre", nombre.value)
    datos.append("apellidos", apellidos.value)
    datos.append("password", password.value)
    datos.append("genero", genero.value)

    // Realizamos la llamada AJAX con la cual enviamos los datos.
    const response = await fetch("app/registrar-usuario.php", {method: "POST", body: datos})  // Llamada AJAX con la que obtenemos un objeto de tipo Response, que contiene información acerca de la respuesta recibida.
    const resObj = await response.json()   // De objeto Response, obtenemos el JSON recibido, para poderlo usar y obtener los datos que nos regresó el server en su procesamiento de la petición de guardar el archivo.

    // Si en los datos de la respuesta nos regresa un error, mostramos el error.
    if (resObj.error) {
        alert(resObj.error)
        return   // Fin de la ejecución de esta función.
    }

    // Si no hubo error, entonces redireccionamos al usuario a la página de login.
    location.assign('index.php');

})
