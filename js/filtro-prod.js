const listCat = document.querySelectorAll('.categoria-top');



listCat.forEach(ListElement => {
    ListElement.addEventListener('click', ()=>{
        idcat = ListElement.getAttribute('idcat');
        $.ajax({
            url: 'controlador/filtrar_productos.php',
            type: 'POST',
            data: {
              idcat: idcat
            },
            success: function (response) {
                console.log(response);
                var ctnProductos = document.getElementById('ctn-productos');
                const prodActualizado = crearTarjetasProductos(response.datos);
                reemplazarElemento(ctnProductos, prodActualizado);
                document.getElementById('main-prod').scrollIntoView({ behavior: 'smooth' });
            },
            error: function (response) {
              console.log(response);
            }
          });
    })
});


function reemplazarElemento(elementoExistente, nuevoElemento) {
  const padre = elementoExistente.parentNode;
  padre.replaceChild(nuevoElemento, elementoExistente);
}


function crearTarjetasProductos(productos) {
  const contenedor = document.createElement('section'); 
  contenedor.classList.add('ctn-productos');

  productos.forEach((producto) => {
    // Crear elementos de la tarjeta
    const article = document.createElement('article');
    article.classList.add('card-prod');
    article.id = producto.id_producto;
    article.addEventListener('click', ()=>{
        DetalleProd(article.id);
    });

    const img = document.createElement('img');
    img.src = 'img/productos/'+producto.imagenes[0];
    img.alt = `foto del producto ${producto.nombre}`;

    const section1 = document.createElement('section');
    section1.classList.add('ctn-nomb-precio');

    const h4 = document.createElement('h4');
    h4.textContent = producto.nombre;

    const section2 = document.createElement('section');
    section2.classList.add('ctn-precio');

    if (producto.estado_oferta == 1) {
      const cartelOferta = document.createElement('p');
      cartelOferta.classList.add('cartel-oferta');
      cartelOferta.textContent = 'OFERTA';
      article.appendChild(cartelOferta);
      
      const p = document.createElement('p');
      p.classList.add('precio');
      p.textContent = `$${producto.precio_oferta}`;

      const p2 = document.createElement('p');
      p2.classList.add('precio-sindescuento');
      p2.textContent = `$${producto.precio_menor}`;
      section2.appendChild(p);
      section2.appendChild(p2);
    }else{
      const p = document.createElement('p');
      p.classList.add('precio');
      p.textContent = `$${producto.precio_menor}`;
      section2.appendChild(p);
    }

    // Construir la estructura de la tarjeta

    section1.appendChild(h4);
    section1.appendChild(section2);
    article.appendChild(img);
    article.appendChild(section1);

    contenedor.appendChild(article); // Agregar la tarjeta al contenedor
  });
  contenedor.id = 'ctn-productos';
  return contenedor;

}


function DetalleProd(idprod) {
      $.ajax({
        url: 'controlador/obtenerProducto.php',
        type: 'POST',
        data: {
          id: idprod
        },
        success: function (response) {
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
            if (response.datos[0]['estado_oferta'] == 1) {
              CartelDescuento.style.display= 'flex';
              PrecioProd.innerHTML = '$'+response.datos[0]['precio_oferta']; 
              PrecioProdSD.innerHTML = '$'+response.datos[0]['precio_menor']; 
              PrecioProdSD.style.display='block';
            }else{
              CartelDescuento.style.display= 'none';
              PrecioProd.innerHTML = '$'+response.datos[0]['precio_menor']; 
              PrecioProdSD.style.display='none';
            }
            DesProd.innerHTML =response.datos[0]['descripcion'];
            btnAgregarModal.id = response.datos[0]['id_producto'];
            ModalDetalle.classList.toggle('show');
        },
        error: function (response) {
          console.log(response);
        }
      });
}
