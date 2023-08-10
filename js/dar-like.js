const btnLike = document.querySelectorAll('.btn-like');
const contador = document.querySelectorAll('.contador');
const Icon = document.querySelectorAll('.icon');

async function like_click(e) {
    e.preventDefault();
    const btn = e.currentTarget;
    const btnData = btn.dataset;
    const fotoId = btnData.fotoId; // fotoId es el nombre del atributo data-foto-id
    const data = new FormData();
    data.append("fotoId", fotoId);
    const response = await fetch("app/dar-like.php", {method: "POST", body: data});
    const resObj = await response.json();
    if (resObj.error) {
        Icon.innerHTML = `<i class="fa fa-heart-o"></i>`;
        alert(resObj.error);
        return;
    }
    Icon.innerHTML = `<i class="fa fa-heart-o color"></i>`;
    contador.innerHTML = resObj.likes;
    location.reload();
}

for (const elemento of btnLike) {
    elemento.addEventListener('click', like_click);
}
