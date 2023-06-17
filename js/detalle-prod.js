const btnCerrar = document.getElementById('btn-cerrar-modaldetalle');
const ModalDetalle = document.getElementById('modal-detalleProd');
const listProd = document.querySelectorAll('.card-prod');
const ListProdDestacado = document.querySelectorAll('.card-prod-destacado');
const CtnImg = document.getElementById('imagenes-detalleProd');
const nombreProd = document.getElementById('nombre-detalleProd');
const PrecioProd = document.getElementById('precioP-detalleProd');
const PrecioProdSD = document.getElementById('precioSD-detalleProd');
const CartelDescuento = document.getElementById('cartel-oferta-detalle');
const DesProd = document.getElementById('descripcion-detalleProd');
const btnAgregarModal = document.getElementById('btn-agregar-detalleProd');
const btnSumarCantidadProd = document.getElementById('btn-cantidad-sumar-detalle');
const btnRestarCantidadProd = document.getElementById('btn-cantidad-restar-detalle');
const InputCantidadProd = document.getElementById('cantidad-detalleProd');
const ctnProductosIndex = document.getElementById('ctn-productos');
const ctnAccionPrincipalDetalle = document.getElementById('ctn-cantidad-agregar');
const CartelSinStock = document.getElementById('cartel-sinstock-detalle');
const ctnPrecios = document.getElementById('ctn-precio-no');



btnRestarCantidadProd.addEventListener('click', ()=>{
if (parseInt(InputCantidadProd.textContent) > 1) {
  InputCantidadProd.innerText = parseInt(InputCantidadProd.textContent) - 1;
}
});

btnSumarCantidadProd.addEventListener('click', ()=>{
  if (parseInt(InputCantidadProd.textContent) >= 1) {
    InputCantidadProd.innerText = parseInt(InputCantidadProd.textContent) + 1;
  }
  });

  InputCantidadProd.addEventListener('change', ()=>{
    console.log('si entra al evento');
    if (parseInt(InputCantidadProd.textContent) == 1) {
      btnRestarCantidadProd.classList.add('btn-cantidad-off');
      console.log('si entra al if');
    }else{
      btnRestarCantidadProd.classList.remove('btn-cantidad-off');
      console.log('si entra al else');
    }
  })

btnCerrar.addEventListener('click', ()=>{
    ModalDetalle.classList.toggle('show');
});


ListProdDestacado.forEach(ListElement=>{
  ListElement.addEventListener('click', (event)=>{
    var idprod = ListElement.getAttribute('idprod');
    DetalleProd(idprod);
  })
});

listProd.forEach(ListElement => {
    ListElement.addEventListener('click', (e) => {
      e.stopPropagation();
      let idprod = ListElement.id;
      DetalleProd(idprod);
    })
  });


  const swiperProd = new Swiper('.swiper-prod', {
    // Optional parameters

    direction: 'horizontal',
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });

  function DetalleProd(idprod) {
    $.ajax({
      url: 'controlador/obtenerProducto.php',
      type: 'POST',
      data: {
        id: idprod
      },
      success: function (response) {
        console.log(response.datos[0]);
        InputCantidadProd.innerText= '1';
        CtnImg.innerHTML = '';
          for (let index = 0; index < response.datos[0]['imagenes'].length; index++) {
              if (response.datos[0]['imagenes'][index] != '') {
                  var imagen = document.createElement("img");
                  imagen.src = 'img/productos/'+response.datos[0]['imagenes'][index];
                  imagen.classList.add('swiper-slide');
                  CtnImg.appendChild(imagen);
              }   
          }
          swiperProd.update();
          swiperProd.slideTo(0);
          nombreProd.innerHTML= response.datos[0]['nombre'];
          if (response.datos[0]['estado'] === 'Sin Stock') {
            CartelSinStock.style.display='flex';
            CartelDescuento.style.display= 'none';
            PrecioProd.style.display='none';
            PrecioProdSD.style.display='none';
            ctnAccionPrincipalDetalle.style.display='none';
          }else{
            CartelSinStock.style.display='none';
            ctnAccionPrincipalDetalle.style.display='flex';
            ctnPrecios.style.display='flex';
            if (response.datos[0]['estado_oferta'] == 1) {
              CartelDescuento.style.display= 'flex';
              PrecioProd.innerHTML = '$'+response.datos[0]['precio_oferta']; 
              PrecioProdSD.innerHTML = '$'+response.datos[0]['precio_menor']; 
              PrecioProdSD.style.display='block';
              PrecioProd.style.display='block';
            }else{
              PrecioProd.style.display='block';
              CartelDescuento.style.display= 'none';
              PrecioProd.innerHTML = '$'+response.datos[0]['precio_menor']; 
              PrecioProdSD.style.display='none';
            }
            btnAgregarModal.id = response.datos[0]['id_producto'];
          }
          DesProd.innerHTML =response.datos[0]['descripcion'];
          ModalDetalle.classList.toggle('show');
      },
      error: function (response) {
        console.log(response);
      }
    });
}
