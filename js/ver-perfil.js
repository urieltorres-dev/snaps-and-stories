const btnVerPerfil = document.querySelectorAll('.btn-ver-perfil');

// Definición de la función que será el event handler del click de los elementos button que tiene la
// funcionalidad de redirigirnos al perfil del usuario.
async function verPerfil(event) {
    // Para no hacer el submit, esto porque vamos a enviar los datos por AJAX.
    event.preventDefault();

    // Obtenemos el username del usuario.
    const username = event.target.dataset.username; // data-username="username"
    const userId = event.target.dataset.usuarioId; // data-usuario-id="id"

    // Redireccionamos al usuario a la perfil.
    location.assign(`perfil.php?username=${username}&id=${userId}`);
}

// Agregamos el event handler al evento click de los elementos button que tiene la funcionalidad de
// redirigirnos al perfil del usuario.
for (const elemento of btnVerPerfil) {
    elemento.addEventListener('click', verPerfil);
}
