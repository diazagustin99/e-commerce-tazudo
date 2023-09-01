const listCat = document.querySelectorAll('.categoria-top');
const ListMenuCat = document.querySelectorAll('.li-filtro-cat');
ListMenuCat.forEach(ListElement => {
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
              btnAbrirMenu.checked= false;
              ctnEnlaces.classList.toggle('show-menu');
              var ctnProductos = document.getElementById('ctn-productos');
              const prodActualizado = crearTarjetasProductos(response.datos);
              var li = ListElement.parentNode;
              var contenedor = li.parentNode;
              contenedor.style.height = '0px';
              contenedor.style.display = 'none';
              reemplazarElemento(ctnProductos, prodActualizado);
              document.getElementById('main-prod').scrollIntoView({ behavior: 'smooth' });
          },
          error: function (response) {
            console.log(response);
          }
        });
  })
});


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
    if (producto.estado == 'Activo') {      
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
    }else{
      const cartelOferta = document.createElement('p');
      cartelOferta.classList.add('cartel-sinstock');
      cartelOferta.textContent = 'SIN STOCK';
      article.appendChild(cartelOferta);
      const p2 = document.createElement('p');
      p2.classList.add('precio-sindescuento');
      p2.textContent = 'SIN STOCK';
      section2.appendChild(p2);
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


