const modal = document.getElementById('contenedormodal-crearProducto');
const formNuevoProd = document.getElementById('contenedor-formnuevoproducto');
const btnmodal = document.getElementById('btn-agregarProd');
const btncerrar = document.getElementById('btn-cerrar');
let listBtnEditar = document.querySelectorAll('.btn-editar');

const FormModal = document.getElementById('formModal');
const idprodinput = document.getElementById('idprod');
const nombInput = document.getElementById('nomb');
const desInput = document.getElementById('des');
const CategoriaInput = document.getElementById('categoria');
const precmInput = document.getElementById('precm');
const checkOferta = document.getElementById('checkOferta');
const precoInput = document.getElementById('preco');
const checkDestacado = document.getElementById('checkDestacado');
const foto1Input = document.getElementById('input-file1');
const foto2Input = document.getElementById('input-file2');
const foto3Input = document.getElementById('input-file3');


btnmodal.addEventListener('click', () => {
  FormModal.reset();
  document.getElementById('preview-image1').src = '';
  document.getElementById('preview-image2').src = '';
  document.getElementById('preview-image3').src = '';
  modal.classList.toggle('show');
  formNuevoProd.classList.toggle('mostrar');
  FormModal.action = "../../controlador/nuevo_producto.php";
});

btncerrar.addEventListener('click', () => {
  modal.classList.toggle('show');
  formNuevoProd.classList.toggle('mostrar');
});

listBtnEditar.forEach(ListElement => {
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
        console.log(response.datos[0]['estado_oferta']);
        document.getElementById('preview-image1').src = '';
        document.getElementById('preview-image2').src = '';
        document.getElementById('preview-image3').src = '';
        FormModal.action = "../../controlador/ModificarProducto.php";
        if (response.datos[0]['imagenes'][0] != '') {
          document.getElementById('preview-image1').src = "../../img/productos/" + response.datos[0]['imagenes'][0];
          document.getElementById('foto1-reg').value = response.datos[0]['imagenes'][0];
        }

        if (response.datos[0]['imagenes'][1] != '') {
          document.getElementById('preview-image2').src = "../../img/productos/" + response.datos[0]['imagenes'][1];
          document.getElementById('foto2-reg').value = response.datos[0]['imagenes'][1];
        }

        if (response.datos[0]['imagenes'][2] != '') {
          document.getElementById('preview-image3').src = "../../img/productos/" + response.datos[0]['imagenes'][2];
          document.getElementById('foto3-reg').value = response.datos[0]['imagenes'][2];
        }
        idprodinput.value = response.datos[0]['id_producto'];
        nombInput.value = response.datos[0]['nombre'];
        desInput.value = response.datos[0]['descripcion'];
        CategoriaInput.value = response.datos[0]['categoria'];
        precmInput.value = response.datos[0]['precio_menor'];
        checkOferta.checked = response.datos[0]['estado_oferta'] == '1' ?? "true";
        checkDestacado.checked = response.datos[0]['destacado'] == '1' ?? "true";
        precoInput.value = response.datos[0]['precio_oferta'];
        modal.classList.toggle('show');
        formNuevoProd.classList.toggle('mostrar');
      },
      error: function (response) {
        console.log(response);
      }
    });
  })
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
document.getElementById('input-file2').addEventListener('change', function () {
  mostrarVistaPrevia(this, document.getElementById('preview-image2'));
});
document.getElementById('input-file3').addEventListener('change', function () {
  mostrarVistaPrevia(this, document.getElementById('preview-image3'));
});

document.getElementById('remove-image1').addEventListener('click', function (evento) {
  document.getElementById('input-file1').value = '';
  document.getElementById('preview-image1').src = '';
  document.getElementById('foto1-reg').value = '';
  evento.preventDefault();
});
document.getElementById('remove-image2').addEventListener('click', function (evento) {
  document.getElementById('input-file2').value = '';
  document.getElementById('preview-image2').src = '';
  document.getElementById('foto2-reg').value = '';
  evento.preventDefault();
});
document.getElementById('remove-image3').addEventListener('click', function (evento) {
  document.getElementById('input-file3').value = '';
  document.getElementById('preview-image3').src = '';
  document.getElementById('foto3-reg').value = '';
  evento.preventDefault();
});




