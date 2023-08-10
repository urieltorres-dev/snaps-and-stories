const subMenu = document.getElementById("subMenu");
const likeBtn = document.querySelector(".btn-like")
const likeIcon = document.querySelector("#icon")

let clicked = true;

function toggleMenu(){
    subMenu.classList.toggle("open-menu")
}

likeBtn.addEventListener("click", () =>{
    if(!clicked){
        clicked = true
        likeIcon.innerHTML = `<i class="fa fa-heart-o"></i>`
    }else{
        clicked = false
        likeIcon.innerHTML = `<i class="fa fa-heart-o color"></i>`
    }
})
