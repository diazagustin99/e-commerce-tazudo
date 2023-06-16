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




btnPrincipalCarrito.addEventListener('click', (event) => {
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
                    realizarPedido();
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
                AbrirCarrito();
                h3not.innerHTML = 'Producto agregado';
                notification.style.backgroundColor = 'green';
                bodyNot.innerHTML = 'El producto fue agregado a su carrito';
                CTNnotification.classList.toggle('show-notificacion');
                setTimeout(function () {
                    closeNotification();
                }, 5000);
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

function realizarPedido() {
    $("button").prop("disabled", true);
    var medioPago = $('input[name=medioPago]:checked').val();
    var metentrega = $('input[name=metentrega]:checked').val();
    var formData = {
        medioPago: medioPago,
        metentrega: metentrega,
        direccionEntrega: InputDireccionElement.value
    }
    $.ajax({
        type: 'POST',
        url: 'controlador/generar_pedido.php',
        data: formData,
        success: function (response) {
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
            $("button").prop("disabled", false);
        },
        error: function (xhr, status, error) {
            // Manejar errores de la petición
            console.log(error);
            $("button").prop("disabled", false);
        }
    });
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


