<?php
session_start();
$cantCarrito = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $value) {
        $cantCarrito = $cantCarrito + $value->cantidad;
    }
}

$ruta = 'css';
$rutajs = 'js';
$rutalogo = 'img/botones';
$tituloPagina= 'Tazudo | Tazas y tazones para Quedar bien, bien de verdad';
require 'controlador/conexion.php';
require_once 'vista/modulos/headerTienda.php';
require_once 'vista/modulos/navTienda.php';
?>

<section class="ctn-body">
    <section class="ctn-modal-carrito" id="modal-carrito">
        <section class="modal-carrito">
                <section class="ctn-navegacion">
                    <button class="btn-volver-carrito" id="btn-volver-carrito">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </button>
                </section>
                <div class="ctn-notification">
                    <div class="notification" id="body-not">
                        <h3 id="h3-not">Notificación</h3>
                        <p id="text-not">Esta es una notificación flotante.</p>
                    </div>
                </div>
                <h2 id="titulo-carrito">Tu carrito</h2>
        
                <section class="ctn-carrito-vacio">
                    <img src="img/botones/tazudologo-final-vector.svg" alt="" class="img-carrito-vacio">
                    <p class="text-carrito-vacio">Adivina que... exacto, no agregaste ningun producto a tu carrito tazudo</p>
                </section>
        
        
                <section class="ctn-form-pedido" id="ctn-form-pedido">
                    <form class="form-pedido" id="form-pedido">
                        <section class="ctn-input" id="ctn-input-mediopago">
                            <label for="tarjetas" class="lbl-input-pedido">Formas de pago</label>
        
                            <label for="tarjetas" class="input-radiolist">
                                <input type="radio" name="medioPago" id="tarjetas" class="input-radio" value="tarjetas" required>
                                    <section class="ctn-nombreradio-descp">
                                        <p class="titulo-radio">Tarjetas Credito/Debito</p>
                                        <p class="descp-radio">Pagá con cualquier tarjeta!</p>
                                    </section>
                            </label>
        
                            <label for="efectivo" class="input-radiolist">
                                <input type="radio" name="medioPago" id="efectivo" class="input-radio" value="efectivo" required>
                                    <section class="ctn-nombreradio-descp">
                                        <p class="titulo-radio">Efectivo</p>
                                        <p class="descp-radio">Lo pagas en puerta :D</p>
                                    </section>
                            </label>
        
                            <label for="transferencia" class="input-radiolist">
                                <input type="radio" name="medioPago" id="transferencia" class="input-radio" value="transferencia" required>
                                    <section class="ctn-nombreradio-descp">
                                        <p class="titulo-radio">Transferencia</p>
                                        <p class="descp-radio">Luego te pasamos los datos :P</p>
                                    </section>
                            </label>
                        </section>
        
                        <section class="ctn-input" id="ctn-metEntrega">
                            <label for="envioDom" class="lbl-input-pedido">Metodos de entrega</label>
        
                            <label for="envioDom" class="input-radiolist">
                                <input type="radio" name="metentrega" id="envioDom" class="input-radio" value="envio-domicilio" required>
                                    <section class="ctn-nombreradio-descp">
                                        <p class="titulo-radio">Envio a domicilio</p>
                                        <p class="descp-radio">Hacemos envios todos los dias! (Entre $250 a $500)</p>
                                    </section>
                            </label>
        
                            <label for="retirar" class="input-radiolist">
                                <input type="radio" name="metentrega" id="retirar" class="input-radio" value="retiro" required>
                                    <section class="ctn-nombreradio-descp">
                                        <p class="titulo-radio">Retiro de punto de entrega</p>
                                        <p class="descp-radio">Nuestro unico punto de retiro es en heras 2200</p>
                                    </section>
                            </label>
                        </section>
        
                        <section class="ctn-input" id="ctn-input-direccion">
                            <label for="dire" class="lbl-input-pedido">Direccion de entrega</label>
                            <input type="text" name="direccionEntrega" id="dire" maxlength="70" class="input-text-pedido" placeholder="Escribe aqui tazud@...">
                        </section>
        
                        <div id="wallet_container"></div>
                    </form>
                </section>
        
                <section class="ctn-prod-carrito" id="ctn-prod-carrito">
        
                </section>
        
                <section class="ctn-total-btn">
                    <section class="ctn-recargo" id="ctn-recargo">
                        <p>Recargo</p>
                        <p id="recargo-carrito">$100</p>
                    </section>
        
                    <section class="total-carrito">
                        <p>Total estimado</p>
                        <p id="totalestimado-carrito">$2350</p>
                    </section>
                    <button class="btn-carrito-principal" id="btn-principal-carrito">Iniciar compra</button>
                    <a class="seguir-comprando-carrito" id="seguir-comprando-carrito"> o <br> Seguir comprando.</a>
                </section>
        </section>
    </section>
    
    <section class="modal-detalleProd" id="modal-detalleProd">
        <section class="ctn-prod-detalle">
            <section class="swiper-prod">
                <div class="btn-cerrar-detalleProd" id="btn-cerrar-modaldetalle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                </div>
                <div class="swiper-wrapper" id="imagenes-detalleProd">
                </div>
        
                <div class="swiper-pagination"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="swiper-button-prev btn-slider" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                </svg>
        
        
                <svg xmlns="http://www.w3.org/2000/svg" class="swiper-button-next btn-slider" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                </svg>
                <div class="swiper-scrollbar"></div>
            </section>
            <section class="modal-detalleProd-np">
                <h3 id="nombre-detalleProd">TAZON XXL BOB SPONJA</h3>
                <section class="ctn-precio-no" id="ctn-precio-no">
                    <p class="cartel-oferta-detalle" id="cartel-oferta-detalle">OFERTA</p>
                    <p class="cartel-sinstock-detalle" id="cartel-sinstock-detalle">SIN STOCK</p>
                    <p id="precioP-detalleProd">$2600</p>
                    <p class="precio-sindescuento" id="precioSD-detalleProd"> $2800</p>
                </section>
            </section>
            <p  class="descripcion-prod-modal" id="descripcion-detalleProd">Tazas Duo BOB & PATRICIO, tazas de ceramica premium apta para microondas y lavavajillas con capacidad de 350cc. Aprovecha el precio PROMOCIONAL de ingreso!</p>
            <section class="ctn-cantidad-agregar" id="ctn-cantidad-agregar">
                <section class="ctn-cantidad">
                    <p>cantidad</p>
                    <section class="ctn-input-cant">
                        <button class="btn-cantidad" id="btn-cantidad-restar-detalle">-</button>
                        <p class="text-cantidad" id="cantidad-detalleProd">1</p>
                        <button class="btn-cantidad" id="btn-cantidad-sumar-detalle">+</button>
                    </section>
                </section>
                <button class="btn-agregar-detalleProd" id="btn-agregar-detalleProd">Agregar</button>
            </section>
        </section>
    </section>
    
    <div class="swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT *  FROM noticias WHERE estado_noticia = 1  ORDER BY orden_noticia');
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo '<img class="swiper-slide" src="', 'img/noticias/' . $fila[4], '" alt="foto de la categoria ', $fila[1], '">';
                }
            }
            desconectar($conexion);
            ?>
    
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    
        <section class="cnt-btn-pag">
    
            <!-- If we need navigation buttons -->
            <svg xmlns="http://www.w3.org/2000/svg" class="swiper-button-prev btn-slider" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
            </svg>
    
    
            <svg xmlns="http://www.w3.org/2000/svg" class="swiper-button-next btn-slider" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
            </svg>
        </section>
    
        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div>
    </div>
    
    <section class="contenedor-section-destacados">
        <h2 class="titulo-inicio">Destacados</h2>
        <section class="ctn-descatados" id="ctn-destacados">
        <?php
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT id_producto, nombre, precio_menor, estado_oferta, estado, foto1, precio_oferta  FROM productos WHERE destacado = 1 ORDER BY RAND()');
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo '<article class="card-prod-destacado" idprod="',$fila[0],'">';
                    if ($fila[3] != 0) {
                        echo '<p class="cartel-oferta"> OFERTA </p>';
                    }
                    echo '<img src="', 'img/productos/',$fila[5], '" alt="foto del producto ', $fila[1], '">';
                    echo '<section class="ctn-nomb-precio">';
                    echo '<h4>', $fila[1], '</h4>';
                    echo '<section class="ctn-precio">';
                    if ($fila[3] != 0) {
                        echo '<p class="precio">$', $fila[6], '</p>';
                        echo '<p class="precio-sindescuento">$', $fila[2], '</p>';
                    } else {
                        echo '<p class="precio">$', $fila[2], '</p>';
                    }
                    echo '</section>';
                    echo '</section>';
                    echo '</article>';
                }
            }
            desconectar($conexion);
            ?>
    
        </section>
    </section>
    
    <section class="contenedor-bloque2">
        <section class="section-envio ctn-servicios">
            <svg xmlns="http://www.w3.org/2000/svg" width="2.2rem" height="2.2rem" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
            </svg>
            <h4>Envios todos los dias</h4>
        </section>
        <section class="contenedor-acciones">
            <section class="section-whatsapp ctn-servicios">
                <svg xmlns="http://www.w3.org/2000/svg" width="2.2rem" height="2.2rem" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                </svg>
                <h4>Paga como quieras</h4>
            </section>
            <section class="section-descuentos ctn-servicios">
                <svg xmlns="http://www.w3.org/2000/svg" width="2.2rem" height="2.2rem" fill="currentColor" class="bi bi-shop-window" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z" />
                </svg>
                <h4>Retiro en punto de entrega</h4>
            </section>
        </section>
    
    
    </section>
    
    <section class="contenedor-bloque1">
    
        <h2 class="titulo-inicio">Categorias</h2>
        <section class="contenedor-categorias">
            <?php
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT *  FROM categorias');
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo '<article class="categoria-top" idcat="',$fila[0],'">';
                    echo '<img src="', 'img/categorias/' . $fila[2], '" alt="foto de la categoria ', $fila[1], '">';
                    echo '<div  class="top-categoria"><a>', $fila[1], '</a></div>';
                    echo '</article>';
                }
            }
            desconectar($conexion);
            ?>
            <article class="categoria-top" idcat="">
                <img src="img/categorias/foto-pokemon-2.jpg" alt="">
                <div class="top-categoria">
                    <a>
                        <h3>TODOS LOS PRODUCTOS</h3>
                    </a>
                </div>
            </article>
        </section>
    </section>
    
    <main id="main-prod">
        <h2 class="titulo-inicio">Productos</h2>
        <section class="ctn-productos" id="ctn-productos">
            <?php
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT id_producto, nombre, precio_menor, estado_oferta, estado, foto1, precio_oferta  FROM productos WHERE estado <>  "Oculto" ORDER BY RAND()');
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
                    echo '<article class="card-prod" id="',$fila[0],'">';
                    if ($fila[3] != 0 && $fila[4]=='Activo') {
                        echo '<p class="cartel-oferta"> OFERTA </p>';
                    }
                    if ($fila[4]=='Sin Stock') {
                        echo '<p class="cartel-sinstock"> SIN STOCK </p>';
                    }
                    echo '<img loading="lazy" src="', 'img/productos/',$fila[5], '" alt="foto del producto ', $fila[1], '">';
                    echo '<section class="ctn-nomb-precio">';
                    echo '<h4>', $fila[1], '</h4>';
                    echo '<section class="ctn-precio">';
                    if ($fila[4]=='Sin Stock') {
                        echo '<p class="precio-sindescuento">', 'SIN STOCK :(', '</p>';
                    }else {
                        if ($fila[3] != 0) {
                            echo '<p class="precio">$', $fila[6], '</p>';
                            echo '<p class="precio-sindescuento">$', $fila[2], '</p>';
                        } else {
                            echo '<p class="precio">$', $fila[2], '</p>';
                        }
                    }
                    echo '</section>';
                    echo '</section>';
                    echo '</article>';
                }
            }
            desconectar($conexion);
            ?>
    
        </section>
    </main>
</section>


<?php
require_once 'vista/modulos/footerTienda.php';
?>