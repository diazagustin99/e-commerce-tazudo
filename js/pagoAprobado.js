const btnCompletar = document.getElementById('btn-completar-pago');

document.addEventListener('DOMContentLoaded', ()=>{
    const btnCompletar = document.getElementById('btn-completar-pago');
    console.log(btnCompletar.getAttribute('WSPurl'));
    btnCompletar.addEventListener('click', ()=>{
        window.location.href = btnCompletar.getAttribute('WSPurl');
    })
    setTimeout(function() {
        window.location.href = btnCompletar.getAttribute('WSPurl');
    }, 2000); 
})