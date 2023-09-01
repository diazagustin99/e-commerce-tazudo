<?php
$ruta = '../css';
$rutajs = '../js';
$rutalogo = '../img/botones';
$tituloPagina= 'Tazudo | Pago Aprobado';
require('../vista/modulos/headerTienda.php');
require('../controlador/conexion.php');
session_start();
$id_pedido= $_GET['external_reference'];
$estado_pago = $_GET['status'];
$pedido = $_SESSION['pedido'];
if (isset($estado_pago) && $estado_pago == 'approved') {
    $conexion = conectar();
    $resultado = mysqli_query($conexion, 'UPDATE pedidos SET estado_pago = \''. 'Pagado' .'\' WHERE id_pedido =  \''. $pedido->id_pedido .'\'');
    $textEstadoPago = '*estado de pago:* ' . 'APROBADO';
    $textEstadoPago= '%0A' . urlencode($textEstadoPago);
    $urlWSP = $pedido->url . $textEstadoPago;
    unset($_SESSION['carrito']);
    unset($_SESSION['pedido']);
}else {
    header("refresh:0;url=../index.php");
    exit();
}

?>
<header class="header-pagoAprobado">
    <h1>PAGO APROBADO</h1>
    <h2>ID PEDIDO: <br> <?php echo $id_pedido; ?></h2>
</header>
<section class="ctn-centro-pagoAprobado">
    <p>¡Casi todo listo tazudo!</p>
    <ol>
        <li>Espera que abra WhatsApp y completa tu pedido por alla</li>
        <li>Si esperaste demasiado toca el boton que dice "Completar pedido en WhatsApp"</li>
        <li>Muchas gracias por elegirnos a disfrutar tu pedido</li>
    </ol>
</section>
<!-- -->
<section class="ctn-btn-completar">
    <button WSPurl="<?php echo $urlWSP; ?>" id="btn-completar-pago">Completar pedido en WhatsApp</button>
</section>
<script src="../js/pagoAprobado.js"></script>
</body>
</html>
<?php
?>