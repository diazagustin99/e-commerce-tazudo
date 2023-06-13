const btnmodal = document.getElementById('btn-agregarcat');
const btncerrar = document.getElementById('btn-cerrar');
const modal = document.getElementById('contenedormodal-crearcat');
const FormModal = document.getElementById('formModal');
const listBtnEditar = document.querySelectorAll('.btn-editar');
const idCatInput = document.getElementById('idcat');
const nombInput = document.getElementById('nomb');

btnmodal.addEventListener('click', () => {
    FormModal.reset();
    modal.classList.toggle('show');
    FormModal.action = "../../controlador/nuevo_usuario.php";
});

btncerrar.addEventListener('click', () => {
    modal.classList.toggle('show');
});





/*listBtnEditar.forEach(ListElement => {
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
          document.getElementById('preview-image1').src = '';
          FormModal.action = "../../controlador/modificar_categoria.php";
          if (response.datos[0]['imagenes'][0] != '') {
            document.getElementById('preview-image1').src = "../../img/categorias/" + response.datos[0]['imagenes'][0];
            document.getElementById('foto1-reg').value = response.datos[0]['imagenes'][0];
          }
  
          idCatInput.value = response.datos[0]['id_categoria'];
          nombInput.value = response.datos[0]['nombre'];
          modal.classList.toggle('show');
        },
        error: function (response) {
          console.log(response);
        }
      });
    })
  });*/