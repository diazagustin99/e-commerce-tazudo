const btnmodal = document.getElementById('btn-agregarnot');
const btncerrar = document.getElementById('btn-cerrar');
const modal = document.getElementById('contenedormodal-crearNoticia');
const FormModal = document.getElementById('formModal');
const listBtnEditar = document.querySelectorAll('.btn-editar');
const idCatInput = document.getElementById('idcat');
const nombInput = document.getElementById('nomb');

btnmodal.addEventListener('click', () => {
    FormModal.reset();
    modal.classList.toggle('show');
    FormModal.action = "../../controlador/nueva_noticia.php";
});

btncerrar.addEventListener('click', () => {
    modal.classList.toggle('show');
});