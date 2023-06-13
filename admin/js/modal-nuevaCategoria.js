const btnmodal = document.getElementById('btn-agregarcat');
const btncerrar = document.getElementById('btn-cerrar');
const modal = document.getElementById('contenedormodal-crearcat');
const FormModal = document.getElementById('formModal');
const listBtnEditar = document.querySelectorAll('.btn-editar');
const idCatInput = document.getElementById('idcat');
const nombInput = document.getElementById('nomb');

btnmodal.addEventListener('click', () => {
    FormModal.reset();
    document.getElementById('preview-image1').src = '';
    modal.classList.toggle('show');
    FormModal.action = "../../controlador/nueva_categoria.php";
});

btncerrar.addEventListener('click', () => {
    modal.classList.toggle('show');
});

function mostrarVistaPrevia(input, preview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('input-file1').addEventListener('change', function () {
    mostrarVistaPrevia(this, document.getElementById('preview-image1'));
});

document.getElementById('remove-image1').addEventListener('click', function (evento) {
    document.getElementById('input-file1').value = '';
    document.getElementById('preview-image1').src = '';
    document.getElementById('foto1-reg').value = '';
    evento.preventDefault();
});


listBtnEditar.forEach(ListElement => {
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
  });