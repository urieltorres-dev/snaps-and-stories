const elementosBorrar = document.querySelectorAll('.btn-borrar')  // Todos los elementos que tienen la class a-borrar

// Definición de la función que será el event handler del click de los elementos button que tiene la
// funcionalidad de borrar una foto.
async function elementoBorrar_click(e) {   // <- le ponemos async porque usaremos el await en las funciones relacionadas con AJAX de fetch()

    // Prevenimos el comportamiento por default, como son elementos <a>, evitamos el redirect.
    e.preventDefault()

    // Obtenemos la referencia del elemento <a> el cual disparó el evento click
    const btnBorrar = e.target

    // Del elemento button obtenemos el dataset, que es un objeto que nos permitirá obtener
    // los datos que hemos definido en el buttn con los atributos data-*
    const btnData = btnBorrar.dataset

    // Los atributos data que están en <a> los asignamos a constantes locales.
    const secureId = btnData.fotoSecureId  // data-foto-secure-id
    const usuarioId = btnData.fotoUsuarioSubioId  // data-foto-usuario-subio-id
    
    // Confirmamos la operación de borrar.
    const borrar = confirm(
            `¿Está seguro que desea borrar la foto?`)
    if (!borrar) {   // Si no se confirma la acción, terminamos con la ejecución de esta función.
        return   // Fin de la ejecución de esta función.
    }

    // Creamos un objeto FormData en cual va a contener los datos que enviaremos por POST en 
    // la petición AJAX.
    const data = new FormData()   // Instancia del objeto FormData.
    data.append("secureId", secureId)   // Agregamos el parémtro secureId.
    data.append("usuarioId", usuarioId)   // Agregamos el parémtro usuarioId.

    // Ejecución de la llamada AJAX (HTTP POST).
    const response = await fetch("app/borrar-foto.php", {method: "POST", body: data})  // Obtenemos el objeto Response de la petición.
    const resObj = await response.json()  // Del objeto Response, obtenemos el objeto JSON que nos envió el servidor.

    // Si en los datos que nos envió el servidor, se nos dice que ocurrió un error.
    if (resObj.error) {   
        alert(resObj.error)  // Mostramos el error.
        return   // Fin de la ejecución de esta función.
    }

    // De la tabla HTML donde se muestran los registros de los archibos, obtenemos el elemento
    // <div> que representa el registro que acabamos de borrar. Este elemento div lo podemos
    // borrar para que ya no se muestre en la página, así podemos crear una mejor experiencia
    // para el usuario, puesto que ya no se tiene que recargar la página para poder ver
    // información actualizada.
    const imgArchivo = document.getElementById(`btn-foto-${secureId}`)  // Obtenemos el <tr>
    imgArchivo.remove()   // Lo eliminamos para que ya no se mueste.

    // Redireccionamos al usuario al perfil.
    location.assign(`perfil.php?username=${resObj.username}`) 
}

// A cada elemento que contiene la clase 'a-borrar', se le asigna el event handler
// que es la función elementoBorrar_click
for (const elemento of elementosBorrar) {
    elemento.addEventListener('click', elementoBorrar_click)
}

// La operación de asignarle el event handler al click de cada elemento, lo podemos también realizar así: 
// elementosBorrar.forEach(elemento => elemento.addEventListener("click", elementoBorrar_click))
