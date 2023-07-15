<?php
session_start();
$cantCarrito = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $value) {
        $cantCarrito = $cantCarrito + $value->cantidad;
    }
}

$conexion = conectar();
$resultado = mysqli_query($conexion, 'SELECT id_categoria, nombre_categoria FROM categorias');
desconectar($conexion);
?>
<section id="contenedor-menu">
    <section class="top-menu-btns">
        <input type="checkbox" id="abrirmenu">

        <section class="btn-carrito-index" id="btn-abrir-carrito">
        <p class="contador-carrito-menu" id="contador-carrito-menu"><?php echo $cantCarrito; ?></p>
        <svg xmlns="http://www.w3.org/2000/svg" height="100%" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
        </svg>
        </section>
    </section>
    <nav id="contenedor-enlaces">
        <ul class="enlaces">
            <li><a href="">Inicio</a></li>
            <li >
                <a id="padre-submenu1" class="padre-submenu">Productos <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
                </a>
                <ul id="submenu1" class="sub-menu">
                    <?php
                            while ($rowCat = mysqli_fetch_array($resultado)) {
                                echo '<li><a idcat="',$rowCat['id_categoria'],'" class="li-filtro-cat">',$rowCat['nombre_categoria'], '</a></li>';
                            }
                    ?>
                    <li><a  class="li-filtro-cat" idcat="">TODOS LOS PRODUCTOS</a></li>
                    <li><a  class="li-filtro-cat">OFERTAS</a></li>

                </ul>
            </li>
            <li><a href="#">¿Quien es el tazudo?</a></li>
            <li><a href="#footer">Contacto</a></li>
        </ul>
    </nav>
</section>
