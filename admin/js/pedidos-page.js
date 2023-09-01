


document.addEventListener('DOMContentLoaded', async ()=>{
    ctnPedidos = document.getElementById('ctn-pedidos');
    try {
        let pedidos = await fetchPedidos();
        let pedidosHTML = crearListTarjetasPedidos(pedidos);
        pedidosHTML.classList.add('contenedor-pedidos');
        pedidosHTML.id= 'ctn-pedidos';
        reemplazarElemento(ctnPedidos, pedidosHTML);
      } catch (error) {
        console.error('Error al obtener los pedidos:', error);
      }
})

function crearListTarjetasPedidos(pedidos){
    let ctnpedidos = document.createElement('section');
    pedidos.forEach((pedido) =>{
        pedidoHTML= crearTarjetaPedido(pedido);
        ctnpedidos.appendChild(pedidoHTML);
    })

    return ctnpedidos;
}

function crearTarjetaPedido(pedido) {
    const article = document.createElement('article');
    article.classList.add('pedido-row');
  
    const infoPrimaria = document.createElement('section');
    infoPrimaria.classList.add('ctn-infoprim-pedido');
  
    const detallesPedido = [
      { titulo: 'ID pedido:', valor: pedido.id_pedido },
      { titulo: 'Fecha:', valor: pedido.fecha_pedido },
      { titulo: 'Estado:', valor: pedido.estado_pedido },
    ];
  
    detallesPedido.forEach(detalle => {
      const divDetalles = document.createElement('div');
      divDetalles.classList.add('detalles-pedido');
  
      const tituloPedido = document.createElement('p');
      tituloPedido.classList.add('titulo-pedido');
      tituloPedido.textContent = detalle.titulo;
  
      const valorPedido = document.createElement('p');
      valorPedido.textContent = detalle.valor;
  
      divDetalles.appendChild(tituloPedido);
      divDetalles.appendChild(valorPedido);
      infoPrimaria.appendChild(divDetalles);
    });
  
    const infoSecundaria = document.createElement('section');
    infoSecundaria.classList.add('ctn-infosec-pedido');
  
    const infoSecundariaPedido = [
      { titulo: 'Articulos', valor: pedido.cant_articulos , infoter: '' },
      { titulo: 'Total del pedido', valor: '$'+pedido.total , infoter: '' },
      { titulo: 'Medio de pago', valor: pedido.medioPago , infoter: pedido.estado_pago },
      { titulo: 'Met. de entrega', valor: pedido.metEntrega , infoter: pedido.direEntrega },
    ];
  
    infoSecundariaPedido.forEach(info => {
      const divInfo = document.createElement('div');
      divInfo.classList.add('info-pedido');
  
      const tituloInfoSec = document.createElement('p');
      tituloInfoSec.classList.add('titulo-infosec');
      tituloInfoSec.textContent = info.titulo;
  
      const valorInfoSec = document.createElement('p');
      valorInfoSec.classList.add('infosec');
      valorInfoSec.textContent = info.valor;
  
      const infoter = document.createElement('p');
      infoter.classList.add('infoter');
      infoter.textContent = info.infoter;
  
      divInfo.appendChild(tituloInfoSec);
      divInfo.appendChild(valorInfoSec);
      divInfo.appendChild(infoter);
      infoSecundaria.appendChild(divInfo);
    });
  
    article.appendChild(infoPrimaria);
    article.appendChild(infoSecundaria);
  
    return article;
  }

async function fetchPedidos() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: '../../controlador/obtener_pedidos.php',
        type: 'GET',
        success: function (response) {
          console.log(response);
          resolve(response.datos);
        },
        error: function (errorResponse) {
          console.log(errorResponse);
          reject('Error al obtener los pedidos');
        }
      });
    });
  }

function reemplazarElemento(elementoExistente, nuevoElemento) {
    const padre = elementoExistente.parentNode;
    padre.replaceChild(nuevoElemento, elementoExistente);
  }