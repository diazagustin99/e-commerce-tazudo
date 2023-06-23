const btnmodal = document.getElementById('btn-agregarnot');
const btncerrar = document.getElementById('btn-cerrar');
const modal = document.getElementById('contenedormodal-crearNoticia');
const FormModal = document.getElementById('formModal');
const listBtnEditar = document.querySelectorAll('.btn-editar');
const idNoticiaInput = document.getElementById('idnot');
const nombInput = document.getElementById('des');
const ordenInput = document.getElementById('orden');
const activoInput = document.getElementById('checkActivo');

btnmodal.addEventListener('click', () => {
    FormModal.reset();
    document.getElementById('preview-image1').src = '';
    modal.classList.toggle('show');
    FormModal.action = "../../controlador/nueva_noticia.php";
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
        url: '../../controlador/obtenerNoticia.php',
        type: 'POST',
        data: {
          id: idcat
        },
        success: function (response) {
          console.log(response.datos);
          console.log(response.datos[0]['nombre']);
          document.getElementById('preview-image1').src = '';
          FormModal.action = "../../controlador/modificarNoticia.php";
          if (response.datos[0]['img_noticia'] != '') {
            document.getElementById('preview-image1').src = "../../img/noticias/" + response.datos[0]['img_noticia'];
            document.getElementById('foto1-reg').value = response.datos[0]['img_noticia'];
          }
          idNoticiaInput.value = response.datos[0]['id_noticia'];
          nombInput.value = response.datos[0]['nombre_noticia'];
          ordenInput.value= response.datos[0]['orden_noticia'];
          activoInput.checked = response.datos[0]['estado'] == '1' ?? "true";
          modal.classList.toggle('show');
        },
        error: function (response) {
          console.log(response);
        }
      });
    })
  });
  