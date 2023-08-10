const btnSeguir = document.getElementById('btn-seguir');
const usuarioVisitado = document.getElementById('usuario-visitado')
const usuarioVisitante = document.getElementById('usuario-visitante')

// Evento para seguir o dejar de seguir a un usuario
btnSeguir.addEventListener('click', async function() {

    if (btnSeguir.innerText === 'Seguir') {
        // Creamos un objeto FormData en cual va a contener los datos que enviaremos por POST en 
        // la petición AJAX.
        const data = new FormData()   // Instancia del objeto FormData.
        data.append("usuarioVisitado", usuarioVisitado.dataset.usuarioId)   // Agregamos el parémtro secureId.
        data.append("usuarioVisitante", usuarioVisitante.dataset.usuarioId)   // Agregamos el parémtro secureId.

        // Ejecución de la llamada AJAX (HTTP POST).
        const response = await fetch("app/seguir.php", {method: "POST", body: data})  // Obtenemos el objeto Response de la petición.
        const resObj = await response.json()  // Del objeto Response, obtenemos el objeto JSON que nos envió el servidor.

        // Si en los datos que nos envió el servidor, se nos dice que ocurrió un error.
        if (resObj.error) {
            alert(resObj.error)  // Mostramos el error.
            return   // Fin de la ejecución de esta función.
        }

        // Recargamos la página.
        location.reload();
        
    } else {
        // Creamos un objeto FormData en cual va a contener los datos que enviaremos por POST en 
        // la petición AJAX.
        const data = new FormData()   // Instancia del objeto FormData.
        data.append("usuarioVisitado", usuarioVisitado.dataset.usuarioId)   // Agregamos el parémtro secureId.
        data.append("usuarioVisitante", usuarioVisitante.dataset.usuarioId)   // Agregamos el parémtro secureId.

        // Ejecución de la llamada AJAX (HTTP POST).
        const response = await fetch("app/seguir.php", {method: "POST", body: data})  // Obtenemos el objeto Response de la petición.
        const resObj = await response.json()  // Del objeto Response, obtenemos el objeto JSON que nos envió el servidor.

        // Si en los datos que nos envió el servidor, se nos dice que ocurrió un error.
        if (resObj.error) {
            alert(resObj.error)  // Mostramos el error.
            return   // Fin de la ejecución de esta función.
        }

        // Recargamos la página.
        location.reload();

    }

});
