let listBtnEliminar = document.querySelectorAll('.btn-eliminar');
const modalElim = document.getElementById('modal-eliminarProducto');
const btnConfirmarElim = document.getElementById('btn-eliminar-conf');
const btnCancelarElim = document.getElementById('btn-eliminar-cancelar');
const nombreh3 = document.getElementById('nomb-prod-card-eliminar');
const precioP = document.getElementById('precio-prod-card-eliminar');
const imgP = document.getElementById('img-prod-card-eliminar');



listBtnEliminar.forEach(ListElement => {
    ListElement.addEventListener('click', () => {
        let idprod = ListElement.id;

        $.ajax({
            url: '../../controlador/obtenerProducto.php',
            type: 'POST',
            data: {
                id: idprod
            },
            success: function (response) {
                console.log(response.datos);
                console.log(response.datos[0]['nombre']);
                btnConfirmarElim.href = '../../controlador/eliminarProducto.php?id=' + idprod;
                imgP.src = "../../img/productos/" + response.datos[0]['imagenes'][0];
                modalElim.classList.toggle('show');
                nombreh3.innerHTML = response.datos[0]['nombre'];
                precioP.innerHTML = "$" + response.datos[0]['precio_menor'];
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


