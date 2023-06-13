let listBtnEliminar = document.querySelectorAll('.btn-eliminar');
const modalElim = document.getElementById('modal-eliminarcat');
const btnConfirmarElim = document.getElementById('btn-eliminar-conf');
const btnCancelarElim = document.getElementById('btn-eliminar-cancelar');
const nombreh3 = document.getElementById('nomb-prod-card-eliminar');
const idP = document.getElementById('precio-prod-card-eliminar');
const imgP = document.getElementById('img-prod-card-eliminar');



listBtnEliminar.forEach(ListElement => {
    ListElement.addEventListener('click', () => {
        let idcat = ListElement.id;

        $.ajax({
            url: '../../controlador/obtenerCategoria.php',
            type: 'POST',
            data: {
                id: idcat
            },
            success: function (response) {
                console.log(response.datos);
                console.log(response.datos[0]['nombre']);
                btnConfirmarElim.href = '../../controlador/eliminar_categoria.php?id=' + idcat;
                imgP.src = "../../img/categorias/" + response.datos[0]['imagenes'][0];
                modalElim.classList.toggle('show');
                nombreh3.innerHTML = response.datos[0]['nombre'];
                idP.innerHTML = "ID: " + response.datos[0]['id_categoria'];
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