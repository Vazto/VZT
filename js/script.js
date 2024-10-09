let alternar = document.querySelector('.alternar');
let navegar = document.querySelector('.navegar');
let principal = document.querySelector('.principal');

alternar.onclick = function () {
    navegar.classList.toggle('activo');
    principal.classList.toggle('activo');
}
