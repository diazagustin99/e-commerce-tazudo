let listSubMenu = document.querySelectorAll('.padre-submenu');
const btnAbrirMenu = document.getElementById('abrirmenu');
const ctnEnlaces = document.getElementById('contenedor-enlaces');

listSubMenu.forEach(ListElement => {
    ListElement.addEventListener('click', ()=>{
        let submenu = ListElement.nextElementSibling;
        //submenu.classList.toggle('show');
        let height = 0;
        if (submenu.clientHeight=="0") {
            height = submenu.scrollHeight;
        }
        submenu.style.height = height + "px";
    })
});

btnAbrirMenu.addEventListener('change', ()=>{
  ctnEnlaces.classList.toggle('show-menu');
})

console.log("hola si entra");
const nextbtn = document.querySelectorAll('.slider-btn-next');
const prevbtn = document.querySelectorAll('.slider-btn-prev');
const swiper = new Swiper('.swiper', {
    // Optional parameters
    autoplay: {
        delay: 5000,
      },
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

  var container = document.querySelector('.ctn-productos');
  var ctnDestacados = document.querySelector('.ctn-descatados');

// Encuentra la altura máxima entre los elementos hijos
container.addEventListener('change', ()=>{
  var children = container.querySelectorAll('.card-prod');
  igualarCards(children);
})

document.addEventListener('DOMContentLoaded', ()=>{
  equalizeCardHeight('#ctn-destacados', '.card-prod-destacado')
})

function igualarCards(children) {
  var maxHeight = 0;
  for (var i = 0; i < children.length; i++) {
    var height = children[i].offsetHeight;
    if (height > maxHeight) {
      maxHeight = height;
    }
  }
  
  // Establece la altura máxima a todos los elementos hijos
  for (var i = 0; i < children.length; i++) {
    children[i].style.height = maxHeight + 'px';
  }
}


function equalizeCardHeight(containerSelector, cardSelector) {
  const container = document.querySelector(containerSelector);
  const cards = container.querySelectorAll(cardSelector);

  let maxHeight = 0;

  cards.forEach((card) => {
    card.style.height = ''; // Reset card height to auto

    const cardHeight = card.offsetHeight;
    if (cardHeight > maxHeight) {
      maxHeight = cardHeight;
    }
  });

  cards.forEach((card) => {
    card.style.height = `${maxHeight}px`;
  });
}







