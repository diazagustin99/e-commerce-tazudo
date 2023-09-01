const btnAgregar = document.getElementById('btn-agregar-detalleProd');
const ModalDetalleProd = document.getElementById('modal-detalleProd');
var CTNnotification = document.querySelector('.ctn-notification');
var notification = document.querySelector('.notification');
const h3not = document.getElementById('h3-not');
const bodyNot = document.getElementById('text-not');
const btnVolverCarrito = document.getElementById('btn-volver-carrito');
const ModalCarrito = document.getElementById('modal-carrito');
const btnAbrirCarrito = document.getElementById('btn-abrir-carrito');
const ctnProdCarrito = document.getElementById('ctn-prod-carrito');
const totalestimadocarrito = document.getElementById('totalestimado-carrito');
const contadorcarritomenu = document.getElementById('contador-carrito-menu');
const InputCantidadProdDetalle = document.getElementById('cantidad-detalleProd');
const envioDomRadio = document.getElementById('envioDom');
const ctninputdireccion = document.getElementById('ctn-input-direccion');
const ctnmetEntrega = document.getElementById('ctn-metEntrega');
const btnPrincipalCarrito = document.getElementById('btn-principal-carrito');
const ctnformpedido = document.getElementById('ctn-form-pedido');
const titulocarrito = document.getElementById('titulo-carrito');
const formPedido = document.getElementById('form-pedido');
const ctnTotalCarrito = document.querySelector('.total-carrito');
const ctnCarritoVacio = document.querySelector('.ctn-carrito-vacio');
const InputDireccionElement = document.getElementById('dire');
const recargoCarrito = document.getElementById('recargo-carrito');
const ctnRecargo = document.getElementById('ctn-recargo');
const pagoTarjetaRadio = document.getElementById('tarjetas');
const ctnMedioPagoInput = document.getElementById('ctn-input-mediopago');
const btnSeguirComprando = document.getElementById('seguir-comprando-carrito');
var tsc = 0;




btnPrincipalCarrito.addEventListener('click', async (event) => {
    var btn = event.target;
    var loader = CrearLoader();
    if (btnPrincipalCarrito.textContent == 'Iniciar compra') {
        ctnProdCarrito.style.display = 'none';
        ctnformpedido.style.display = 'flex';
        titulocarrito.textContent = 'Ultimo paso Tazudo, completa tu pedido';
        btnPrincipalCarrito.textContent = 'Realizar compra';
    } else {
        if (btnPrincipalCarrito.textContent == 'Volver a la tienda') {
            ModalCarrito.classList.toggle('show');
        } else {
            if (btnPrincipalCarrito.textContent == 'Realizar compra') {
                var medioPago = $('input[name=medioPago]:checked').val();
                var metentrega = $('input[name=metentrega]:checked').val();
                if (medioPago!= null && metentrega!=null) {                    
                    btn.appendChild(loader);
                     await realizarPedido();
                    loader.remove();
                }
            }
        }
    }
})

ctnMedioPagoInput.addEventListener('change', () => {
    if (pagoTarjetaRadio.checked) {
        stringTotal = totalestimadocarrito.textContent;
        stringTotal = stringTotal.replace('$', '');
        calcularRecargo(parseInt(stringTotal.trim()));
    } else {
        totalestimadocarrito.innerHTML = '$' + tsc;
        ctnRecargo.style.display = 'none';
    }


})

ctnmetEntrega.addEventListener('change', () => {
    InputDireccion();
})

btnAbrirCarrito.addEventListener('click', () => {
    AbrirCarrito();
});

btnVolverCarrito.addEventListener('click', () => {
    if (ctnformpedido.style.display == 'flex') {
        ctnProdCarrito.style.display = 'flex';
        ctnformpedido.style.display = 'none';
        titulocarrito.textContent = 'Tu carrito';
        btnPrincipalCarrito.textContent = 'Iniciar compra';
        formPedido.reset();
        InputDireccion();
        calcularRecargo(0);
        totalestimadocarrito.innerHTML = '$' + tsc;
    } else {
        ModalCarrito.classList.toggle('show');
        console.log('entra cuando no hay nada')
    }
});

btnSeguirComprando.addEventListener('click', () => {
    if (ctnformpedido.style.display == 'flex') {
        ctnProdCarrito.style.display = 'flex';
        ctnformpedido.style.display = 'none';
        titulocarrito.textContent = 'Tu carrito';
        btnPrincipalCarrito.textContent = 'Iniciar compra';
        formPedido.reset();
        InputDireccion();
        calcularRecargo(0);
        totalestimadocarrito.innerHTML = '$' + tsc;
        ModalCarrito.classList.toggle('show');
    } else {
        ModalCarrito.classList.toggle('show');
    }
});

btnAgregar.addEventListener('click', (event) => {
    var btn = event.target;
    var loader = CrearLoader();
    btn.appendChild(loader);
    let idprod = btnAgregar.id;
    $("button").prop("disabled", true);
    $.ajax({
        url: 'controlador/agregar_carrito.php',
        type: 'POST',
        data: {
            idprod: idprod,
            cant: parseInt(InputCantidadProdDetalle.textContent)
        },
        success: function (response) {
            console.log(response);
            console.log(response.countCarrito);
            ModalDetalleProd.classList.toggle('show');
            if (response.estado.codigo == 200) {
                contadorcarritomenu.innerHTML = response.countCarrito;
                const noti =  crearPushAgregado(response.prodAgregado);
                document.body.appendChild(noti);
                noti.classList.add('show-notiAgregado');
                setTimeout(function () {
                  noti.remove();
              }, 5000);
                //AbrirCarrito();
                /*h3not.innerHTML = 'Producto agregado';
                notification.style.backgroundColor = 'green';
                bodyNot.innerHTML = 'El producto fue agregado a su carrito';
                CTNnotification.classList.toggle('show-notificacion');
                setTimeout(function () {
                    closeNotification();
                }, 5000);*/
            } else {
                AbrirCarrito();
                h3not.innerHTML = 'Producto NO agregado';
                notification.style.backgroundColor = 'red';
                bodyNot.innerHTML = response.estado.mensaje;
                CTNnotification.classList.toggle('show-notificacion');
                setTimeout(function () {
                    closeNotification();
                }, 5000);
            }
            $("button").prop("disabled", false);
            loader.remove();
        },
        error: function (response) {
            console.log(response);
            loader.remove();
            $("button").prop("disabled", false);
        }
    });


})

function InputDireccion() {
    if (envioDomRadio.checked) {
        ctninputdireccion.style.display = 'flex';
        InputDireccionElement.required = true;

    } else {
        ctninputdireccion.style.display = 'none';
        InputDireccionElement.required = false;
    }
}

function calcularRecargo(subtotal) {
    if (pagoTarjetaRadio.checked) {
        var recargo = subtotal * 0.18;
        recargoCarrito.textContent = '$' + recargo;
        totalestimadocarrito.textContent = '$' + (subtotal + recargo);
        ctnRecargo.style.display = 'flex';

    } else {

        ctnRecargo.style.display = 'none';
    }
}

function AbrirCarrito() {
    $.ajax({
        url: 'controlador/obtener_carrito.php',
        type: 'POST',
        data: {

        },
        success: function (response) {
            tsc = 0;
            ctnProdCarrito.innerHTML = '';
            console.log(response);
            ctnTotalCarrito.style.display = 'flex';
            ctnProdCarrito.style.display = 'flex';
            btnPrincipalCarrito.textContent = 'Iniciar compra';
            if (response.carrito.length === 0) {
                ctnTotalCarrito.style.display = 'none';
                ctnProdCarrito.style.display = 'none';
                ctnCarritoVacio.style.display = 'flex';
                btnPrincipalCarrito.textContent = 'Volver a la tienda';
                ModalCarrito.classList.toggle('show');
                btnSeguirComprando.style.display='none';
            } else {
                ctnCarritoVacio.style.display = 'none';
                btnSeguirComprando.style.display='block';
                response.carrito.forEach(element => {
                    const prodcarrito = document.createElement('section');
                    prodcarrito.classList.add('prod-carrito');

                    const ctnfnc = document.createElement('section');
                    ctnfnc.classList.add('ctn-fnc');

                    const ctnfn = document.createElement('section');
                    ctnfn.classList.add('ctn-fn');

                    const img = document.createElement('img');
                    img.src = 'img/productos/' + element.producto.imagenes[0];

                    const nombreProd = document.createElement('h4');
                    nombreProd.innerHTML = element.producto.nombre;

                    ctnfn.appendChild(img);
                    ctnfn.appendChild(nombreProd);

                    const ctncantidadcarrito = document.createElement('section');
                    ctncantidadcarrito.classList.add('ctn-cantidad-carrito');


                    const btnCantidadMenor = document.createElement('button');
                    btnCantidadMenor.classList.add('btn-cantidad', 'btn-cantidad-carrito');

                    btnCantidadMenor.innerText = '-';

                    const btnCantidadMayor = document.createElement('button');
                    btnCantidadMayor.classList.add('btn-cantidad', 'btn-cantidad-carrito');
                    btnCantidadMayor.innerText = '+';

                    const cantidadcarritoprod = document.createElement('input');
                    cantidadcarritoprod.type = 'number';
                    cantidadcarritoprod.readOnly = true;
                    cantidadcarritoprod.classList.add('cantidad-carrito-prod');
                    cantidadcarritoprod.value = element.cantidad;
                    cantidadcarritoprod.dataset.idprod = element.producto.id_producto;

                    ctncantidadcarrito.appendChild(btnCantidadMenor);
                    ctncantidadcarrito.appendChild(cantidadcarritoprod);
                    ctncantidadcarrito.appendChild(btnCantidadMayor);

                    ctnfnc.appendChild(ctnfn);
                    ctnfnc.appendChild(ctncantidadcarrito);

                    const ctnsubtotalprod = document.createElement('section');
                    ctnsubtotalprod.classList.add('sub-total-prod');

                    const subtotal = document.createElement('p');
                    if (element.producto.estado_oferta == 1) {
                        subtotal.innerHTML = '$' + (element.cantidad * element.producto.precio_oferta);
                        tsc = tsc + element.cantidad * element.producto.precio_oferta;
                    } else {
                        subtotal.innerHTML = '$' + (element.cantidad * element.producto.precio_menor);
                        tsc = tsc + element.cantidad * element.producto.precio_menor;
                    }

                    ctnsubtotalprod.appendChild(subtotal);

                    prodcarrito.appendChild(ctnfnc);
                    prodcarrito.appendChild(ctnsubtotalprod);

                    ctnProdCarrito.appendChild(prodcarrito);

                });
                totalestimadocarrito.innerHTML = '$' + tsc;
                btnsCantidad();
                ModalCarrito.classList.toggle('show');
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
};

function closeNotification() {
    CTNnotification.classList.remove('show-notificacion');
}

async function realizarPedido() {
  $("button").prop("disabled", true);
  var medioPago = $('input[name=medioPago]:checked').val();
  var metentrega = $('input[name=metentrega]:checked').val();
  var formData = {
      medioPago: medioPago,
      metentrega: metentrega,
      direccionEntrega: InputDireccionElement.value
  };

  try {
      const response = await $.ajax({
          type: 'POST',
          url: 'controlador/generar_pedido.php',
          data: formData,
      });

      // Procesar la respuesta del servidor en caso de éxito
      console.log(response);
      if (medioPago == 'tarjetas') {
          var linkPago = response.pedido.linkPago;
          //Redirecciona automáticamente a MercadoPago
          window.location.href = linkPago;
      } else {
          var urlWP = response.pedido.url;
          //Redirecciona automáticamente a a wsp
          window.location.href = urlWP;
      }

  } catch (error) {
      // Manejar errores de la petición
      console.log(error);
  } finally {
      // Asegurarse de que el botón se habilite nuevamente, independientemente de si hay éxito o error.
      $("button").prop("disabled", false);
  }
}

function btnsCantidad() {
    var btnsCtnCarrito = document.querySelectorAll('.btn-cantidad-carrito');
    btnsCtnCarrito.forEach(ListElement => {
        ListElement.addEventListener('click', () => {
            let CtnPadre = ListElement.parentNode;
            let ctnNombreCant = CtnPadre.parentElement;
            let ctnProd = ctnNombreCant.parentNode;
            let pCantidad = CtnPadre.querySelector('.cantidad-carrito-prod');
            if (ListElement.textContent == '+' && parseInt(pCantidad.value) >= 0) {
                pCantidad.value = parseInt(pCantidad.value) + 1;
                ActualizarCantidadCarrito(pCantidad.getAttribute('data-idprod'), pCantidad.value, ctnProd);
            }
            if (ListElement.textContent == '-' && parseInt(pCantidad.value) > 0) {
                pCantidad.value = parseInt(pCantidad.value) - 1;
                ActualizarCantidadCarrito(pCantidad.getAttribute('data-idprod'), pCantidad.value, ctnProd);
            }
        })
    })

}

function ActualizarCantidadCarrito(id, cantidad, ctnProd) {
    var loader = CrearLoader()
    ctnProd.appendChild(loader);
    $(ctnProd).find('button.btn-cantidad-carrito').prop("disabled", true);
    let ctnPrecioProd = ctnProd.querySelector('.sub-total-prod');
    let SubTotalProdP = ctnPrecioProd.querySelector('p');
    $.ajax({
        url: 'controlador/modificar_carrito.php',
        type: 'POST',
        data: {
            idprod: id,
            cantidad: cantidad,
        },
        success: function (response) {
            if (response.carrito.length === 0) {
                ctnTotalCarrito.style.display = 'none';
                ctnProdCarrito.style.display = 'none';
                ctnCarritoVacio.style.display = 'flex';
                btnPrincipalCarrito.textContent = 'Volver a la tienda';
                contadorcarritomenu.textContent = 0;
                btnSeguirComprando.style.display='none';
                loader.remove();
                $(ctnProd).find('button.btn-cantidad-carrito').prop("disabled", false);
            } else {
                if (cantidad > 0) {
                    SubTotalProdP.textContent = '$' + CalcularSubTotalProd(response.carrito, id);
                    calcularTotalCarrito(response.carrito);
                    totalestimadocarrito.textContent = '$' + tsc;
                    console.log(response.carrito);
                    loader.remove();
                    $(ctnProd).find('button.btn-cantidad-carrito').prop("disabled", false);
                } else {
                    ctnProd.remove();
                    calcularTotalCarrito(response.carrito);
                    totalestimadocarrito.textContent = '$' + tsc;
                    console.log(response.carrito);
                    loader.remove();
                    $(ctnProd).find('button.btn-cantidad-carrito').prop("disabled", false);
                }
                contadorcarritomenu.textContent = response.estado.countCarrito;
            }
        },
        error: function (response) {
            console.log(response);
            loader.remove();
            ctnProd.find('button.btn-cantidad-carrito').prop("disabled", false);
        }
    });

}


function calcularTotalCarrito(carrito) {
    tsc = 0;
    carrito.forEach(element => {
        if (element.producto.estado_oferta == 1) {
            tsc = tsc + element.cantidad * element.producto.precio_oferta;
        } else {
            tsc = tsc + element.cantidad * element.producto.precio_menor;
        }

    })
}

function CalcularSubTotalProd(carrito, id) {
    let st = 0;
    carrito.forEach(element => {
        if (element.producto.id_producto == id) {

            if (element.producto.estado_oferta == 1) {
                st = element.cantidad * element.producto.precio_oferta;
            } else {
                st = element.cantidad * element.producto.precio_menor;
            }
        }
    })
    return st;
}

function CrearLoader() {
    var ctnsvg = document.createElement('section');
    ctnsvg.classList.add('ctn-loader');
    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("viewBox", "0 0 50 50");

    var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    circle.setAttribute("cx", "25");
    circle.setAttribute("cy", "25");
    circle.setAttribute("r", "20");
    circle.setAttribute("fill", "none");
    circle.setAttribute("stroke-width", "4");
    svg.classList.add('loader-svg');
    circle.classList.add('loader-circle');

    svg.appendChild(circle);
    ctnsvg.appendChild(svg);
    return ctnsvg;
}


//CUANDO REDUCIR EL TIEMPO DE CARGA DEBERIA CREAR EL MODAL CARRITO RECIEN CUANDO DE CLICK EN EL BOTON DEL CARRITO
function crearModalCarrito() {
    var modalCarrito = $('<section>', {
      class: 'modal-carrito',
      id: 'modal-carrito'
    });
  
    var ctnNavegacion = $('<section>', {
      class: 'ctn-navegacion'
    });
  
    var btnVolverCarrito = $('<button>', {
      class: 'btn-volver-carrito',
      id: 'btn-volver-carrito'
    });
  
    var svg = $('<svg>', {
      xmlns: 'http://www.w3.org/2000/svg',
      width: '16',
      height: '16',
      fill: 'currentColor',
      class: 'bi bi-arrow-left',
      viewBox: '0 0 16 16'
    });
  
    var path = $('<path>', {
      'fill-rule': 'evenodd',
      d: 'M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z'
    });
  
    var ctnNotification = $('<div>', {
      class: 'ctn-notification'
    });
  
    var notification = $('<div>', {
      class: 'notification',
      id: 'body-not'
    });
  
    var h3Not = $('<h3>', {
      id: 'h3-not',
      text: 'Notificación'
    });
  
    var textNot = $('<p>', {
      id: 'text-not',
      text: 'Esta es una notificación flotante.'
    });
  
    var tituloCarrito = $('<h2>', {
      id: 'titulo-carrito',
      text: 'Tu carrito'
    });
  
    var ctnCarritoVacio = $('<section>', {
      class: 'ctn-carrito-vacio'
    });
  
    var imgCarritoVacio = $('<img>', {
      src: 'img/botones/tazudologo-final-vector.svg',
      alt: '',
      class: 'img-carrito-vacio'
    });
  
    var textCarritoVacio = $('<p>', {
      class: 'text-carrito-vacio',
      text: 'Adivina que... exacto, no agregaste ningun producto a tu carrito tazudo'
    });
  
    var ctnFormPedido = $('<section>', {
      class: 'ctn-form-pedido',
      id: 'ctn-form-pedido'
    });
  
    var formPedido = $('<form>', {
      class: 'form-pedido',
      id: 'form-pedido'
    });
  
    var ctnInputMedioPago = $('<section>', {
      class: 'ctn-input',
      id: 'ctn-input-mediopago'
    });
  
    var lblInputPedido1 = $('<label>', {
      for: 'tarjetas',
      class: 'lbl-input-pedido',
      text: 'Formas de pago'
    });
  
    var inputRadioList1 = $('<label>', {
      for: 'tarjetas',
      class: 'input-radiolist'
    }).append(
      $('<input>', {
        type: 'radio',
        name: 'medioPago',
        id: 'tarjetas',
        class: 'input-radio',
        value: 'tarjetas',
        required: true
      }),
      $('<section>', {
        class: 'ctn-nombreradio-descp'
      }).append(
        $('<p>', {
          class: 'titulo-radio',
          text: 'Tarjetas Credito/Debito'
        }),
        $('<p>', {
          class: 'descp-radio',
          text: 'Pagá con cualquier tarjeta!'
        })
      )
    );
  
    var inputRadioList2 = $('<label>', {
      for: 'efectivo',
      class: 'input-radiolist'
    }).append(
      $('<input>', {
        type: 'radio',
        name: 'medioPago',
        id: 'efectivo',
        class: 'input-radio',
        value: 'efectivo',
        required: true
      }),
      $('<section>', {
        class: 'ctn-nombreradio-descp'
      }).append(
        $('<p>', {
          class: 'titulo-radio',
          text: 'Efectivo'
        }),
        $('<p>', {
          class: 'descp-radio',
          text: 'Lo pagas en puerta :D'
        })
      )
    );
  
    var inputRadioList3 = $('<label>', {
      for: 'transferencia',
      class: 'input-radiolist'
    }).append(
      $('<input>', {
        type: 'radio',
        name: 'medioPago',
        id: 'transferencia',
        class: 'input-radio',
        value: 'transferencia',
        required: true
      }),
      $('<section>', {
        class: 'ctn-nombreradio-descp'
      }).append(
        $('<p>', {
          class: 'titulo-radio',
          text: 'Transferencia'
        }),
        $('<p>', {
          class: 'descp-radio',
          text: 'Luego te pasamos los datos :P'
        })
      )
    );
  
    var ctnInputMetEntrega = $('<section>', {
      class: 'ctn-input',
      id: 'ctn-metEntrega'
    });
  
    var lblInputPedido2 = $('<label>', {
      for: 'envioDom',
      class: 'lbl-input-pedido',
      text: 'Metodos de entrega'
    });
  
    var inputRadioList4 = $('<label>', {
      for: 'envioDom',
      class: 'input-radiolist'
    }).append(
      $('<input>', {
        type: 'radio',
        name: 'metentrega',
        id: 'envioDom',
        class: 'input-radio',
        value: 'envio-domicilio',
        required: true
      }),
      $('<section>', {
        class: 'ctn-nombreradio-descp'
      }).append(
        $('<p>', {
          class: 'titulo-radio',
          text: 'Envio a domicilio'
        }),
        $('<p>', {
          class: 'descp-radio',
          text: 'Hacemos envios todos los dias! (Entre $250 a $500)'
        })
      )
    );
  
    var inputRadioList5 = $('<label>', {
      for: 'retirar',
      class: 'input-radiolist'
    }).append(
      $('<input>', {
        type: 'radio',
        name: 'metentrega',
        id: 'retirar',
        class: 'input-radio',
        value: 'retiro',
        required: true
      }),
      $('<section>', {
        class: 'ctn-nombreradio-descp'
      }).append(
        $('<p>', {
          class: 'titulo-radio',
          text: 'Retiro de punto de entrega'
        }),
        $('<p>', {
          class: 'descp-radio',
          text: 'Nuestro unico punto de retiro es en heras 2200'
        })
      )
    );
  
    var ctnInputDireccion = $('<section>', {
      class: 'ctn-input',
      id: 'ctn-input-direccion'
    });
  
    var lblInputPedido3 = $('<label>', {
      for: 'dire',
      class: 'lbl-input-pedido',
      text: 'Direccion de entrega'
    });
  
    var inputDireccion = $('<input>', {
      type: 'text',
      name: 'direccionEntrega',
      id: 'dire',
      maxlength: '70',
      class: 'input-text-pedido',
      placeholder: 'Escribe aqui tazud@...'
    });
  
    var walletContainer = $('<div>', {
      id: 'wallet_container'
    });
  
    var ctnProdCarrito = $('<section>', {
      class: 'ctn-prod-carrito',
      id: 'ctn-prod-carrito'
    });
  
    var ctnTotalBtn = $('<section>', {
      class: 'ctn-total-btn'
    });
  
    var ctnRecargo = $('<section>', {
      class: 'ctn-recargo',
      id: 'ctn-recargo'
    }).append(
      $('<p>', {
        text: 'Recargo'
      }),
      $('<p>', {
        id: 'recargo-carrito',
        text: '$100'
      })
    );
  
    var totalCarrito = $('<section>', {
      class: 'total-carrito'
    }).append(
      $('<p>', {
        text: 'Total estimado'
      }),
      $('<p>', {
        id: 'totalestimado-carrito',
        text: '$2350'
      })
    );
  
    var btnPrincipalCarrito = $('<button>', {
      class: 'btn-carrito-principal',
      id: 'btn-principal-carrito',
      text: 'Iniciar compra'
    });
  
    var seguirComprandoCarrito = $('<a>', {
      class: 'seguir-comprando-carrito',
      id: 'seguir-comprando-carrito',
      html: 'o <br> Seguir comprando.'
    });
  
    modalCarrito.append(
      ctnNavegacion.append(
        btnVolverCarrito.append(
          svg.append(path)
        )
      ),
      ctnNotification.append(
        notification.append(
          h3Not,
          textNot
        )
      ),
      tituloCarrito,
      ctnCarritoVacio.append(
        imgCarritoVacio,
        textCarritoVacio
      ),
      ctnFormPedido.append(
        formPedido.append(
          ctnInputMedioPago.append(
            lblInputPedido1,
            inputRadioList1,
            inputRadioList2,
            inputRadioList3
          ),
          ctnInputMetEntrega.append(
            lblInputPedido2,
            inputRadioList4,
            inputRadioList5
          ),
          ctnInputDireccion.append(
            lblInputPedido3,
            inputDireccion
          ),
          walletContainer
        )
      ),
      ctnProdCarrito,
      ctnTotalBtn.append(
        ctnRecargo,
        totalCarrito,
        btnPrincipalCarrito,
        seguirComprandoCarrito
      )
    );
  
    $('body').append(modalCarrito);
  }

  //FUNCION QUE CREA LA NOTIPUSH DE CUANDO SE AGREGA UN PRODUCTO AL CARRITO

  function crearPushAgregado(prodCarrito) {
    const section = document.createElement('section');
    section.classList.add('ctn-noti-agregarCarrito');
  
    const closeButton = document.createElement('button');
    closeButton.classList.add('btn-cerrar-notiAgregarCarrito');
  
    const closeIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    closeIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    closeIcon.setAttribute('width', '16');
    closeIcon.setAttribute('height', '16');
    closeIcon.setAttribute('fill', 'currentColor');
    closeIcon.classList.add('bi', 'bi-x-lg');
    closeIcon.setAttribute('viewBox', '0 0 16 16');
  
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('d', 'M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z');
  
    closeIcon.appendChild(path);
    closeButton.appendChild(closeIcon);
    section.appendChild(closeButton);
  
    const titleSection = document.createElement('section');
    titleSection.classList.add('ctn-titulo-notiAgregarCarrito');
  
    const bagIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    bagIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    bagIcon.setAttribute('fill', 'currentColor');
    bagIcon.classList.add('bi', 'bi-bag-check');
    bagIcon.setAttribute('viewBox', '0 0 16 16');
  
    const bagPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    bagPath.setAttribute('fill-rule', 'evenodd');
    bagPath.setAttribute('d', 'M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z');
  
    const bagCheckPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    bagCheckPath.setAttribute('d', 'M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z');
  
    bagIcon.appendChild(bagPath);
    bagIcon.appendChild(bagCheckPath);
    titleSection.appendChild(bagIcon);
  
    const title = document.createElement('h4');
    title.classList.add('titulo-noti-agregarCarrito');
    title.textContent = '¡PRODUCTO AGREGADO AL CARRITO!';
    titleSection.appendChild(title);
    section.appendChild(titleSection);
  
    const productSection = document.createElement('section');
    productSection.classList.add('ctn-prodRec-agregarCarrito');
  
    const image = document.createElement('img');
    image.setAttribute('src', 'img/productos/' + prodCarrito.producto.imagenes[0]);
    image.setAttribute('alt', 'foto del producto ' + prodCarrito.producto.nombre);
  
    const nameQtySection = document.createElement('section');
    nameQtySection.classList.add('ctn-nombrecant-notiAgregarCarrito');
  
    const productName = document.createElement('p');
    productName.classList.add('titulo-prod-notiAgregarCarrito');
    productName.textContent = prodCarrito.producto.nombre;
  
    const productQty = document.createElement('p');
    productQty.textContent = prodCarrito.cantidad + ' Unidades';
  
    nameQtySection.appendChild(productName);
    nameQtySection.appendChild(productQty);
  
    productSection.appendChild(image);
    productSection.appendChild(nameQtySection);
  
    section.appendChild(productSection);
  
    const viewCartButton = document.createElement('button');
    viewCartButton.classList.add('btn-vercarrito-noti-agregarCarrito');
    viewCartButton.textContent = 'Ver Carrito';
    section.appendChild(viewCartButton);
    closeButton.addEventListener('click', ()=>{
      section.remove();
    });
    viewCartButton.addEventListener('click', ()=>{
      AbrirCarrito();
      section.remove();
    });
  
    return section;
  }


