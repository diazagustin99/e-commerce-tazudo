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
                <a href="#" id="padre-submenu1" class="padre-submenu">Productos</a>
                <ul id="submenu1" class="sub-menu">
                    <?php
                            while ($rowCat = mysqli_fetch_array($resultado)) {
                                echo '<li><a href="" idcat="',$rowCat['id_categoria'],'">',$rowCat['nombre_categoria'], '</a></li>';
                            }
                    ?>
                    <li><a href="">TODOS LOS PRODUCTOS</a></li>
                    <li><a href="">OFERTAS</a></li>

                </ul>
            </li>
            <li><a href="">¿Quien es el tazudo?</a></li>
            <li><a href="">Contacto</a></li>
        </ul>
    </nav>
</section>
