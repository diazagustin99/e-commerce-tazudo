let listBtnEliminar = document.querySelectorAll('.btn-eliminar');
const modalElim = document.getElementById('modal-eliminarNoticia');
const btnConfirmarElim = document.getElementById('btn-eliminar-conf');
const btnCancelarElim = document.getElementById('btn-eliminar-cancelar');
const nombreh3 = document.getElementById('nomb-prod-card-eliminar');
const idP = document.getElementById('precio-prod-card-eliminar');
const imgP = document.getElementById('img-prod-card-eliminar');



listBtnEliminar.forEach(ListElement => {
    ListElement.addEventListener('click', () => {
        let id = ListElement.id;

        $.ajax({
            url: '../../controlador/obtenerNoticia.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function (response) {
                console.log(response.datos);
                console.log(response.datos[0]['nombre']);
                btnConfirmarElim.href = '../../controlador/eliminarNoticia.php?id=' + id;
                imgP.src = "../../img/noticias/" + response.datos[0]['img_noticia'];
                nombreh3.innerHTML = response.datos[0]['nombre_noticia'];
                idP.innerHTML = "ID: " + response.datos[0]['id_noticia'];
                modalElim.classList.toggle('show');
            },
            error: function (response) {
                console.log(response);
            }
        });
    })
});


btnCancelarElim.addEventListener('click', () => {
    modalElim.classList.toggle('show');
});