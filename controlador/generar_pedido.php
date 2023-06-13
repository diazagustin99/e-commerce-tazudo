<?php
session_start();
require('conexion.php');
require  '../vendor/autoload.php';
MercadoPago\SDK::setAccessToken('TEST-234774853004041-060801-d4a454a83f348504a1a03098459a3574-207163280');
$respuesta = new stdClass();
$urlWSP = 'https://api.whatsapp.com/send/?phone=%2B543816738223&text=';
$mjWSP = '';
$textListProd = '';
$textDire = '';
$textRecargos='';
$productosMP=[];
if (!empty($_POST['medioPago']) && !empty($_POST['metentrega']) &&!empty($_SESSION['carrito'])) {
    $pedido = new stdClass();
    $pedido->id_pedido= uniqid("TAZ-");
    $pedido->items=$_SESSION['carrito'];
    $pedido->medioPago=$_POST['medioPago'];
    $pedido->metEntrega=$_POST['metentrega'];
    $pedido->recargo= 0;
    $pedido->subtotal=0;
    $pedido->total=0;
    $textCabeceraPedido = '*PEDIDO:'. $pedido->id_pedido.'*';
    $textCabeceraPedido=urlencode($textCabeceraPedido). '%0A';
    foreach ($pedido->items as $value) {
        $item= new MercadoPago\Item();
        $item->title=$value->producto->nombre;
        $item->quantity=$value->cantidad;
        $textItem = '-- ['.$value->cantidad.'] '. $value->producto->nombre.'>';
        $textItem= '%0A' . urlencode($textItem);
       if ($value->producto->estado_oferta == 1) {
        $item->unit_price=$value->producto->precio_oferta;
        $pedido->subtotal += $value->producto->precio_oferta * $value->cantidad;
        $textItem = $textItem . ' $'.$value->producto->precio_oferta * $value->cantidad;
       }else{
        $item->unit_price=$value->producto->precio_menor;
        $pedido->subtotal += $value->producto->precio_menor * $value->cantidad;
        $textItem = $textItem . ' $'.$value->producto->precio_menor * $value->cantidad;
       }
       array_push($productosMP, $item);
       $textListProd= $textListProd . $textItem;
    }
    $textListProd= $textListProd . '%0A';

    if ($pedido->medioPago=='tarjetas') {
        $pedido->recargo=$pedido->subtotal * 0.18;
        $textRecargos = 'Recargos: *$' .$pedido->recargo. '*';
        $textRecargos= '%0A' . urlencode($textRecargos);
    }
    
    if ($_POST['metentrega'] == 'envio-domicilio') { 
      $pedido->direEntrega = $_POST['direccionEntrega'];
      $textDire= 'Direccion de entrega: *' .$pedido->direEntrega. '*';
      $textDire= '%0A' . urlencode($textDire);
    }
    $pedido->total= $pedido->subtotal + $pedido->recargo;
    $textTotal = 'Total: *$' .$pedido->total. '*';
    $textTotal= '%0A' . urlencode($textTotal);
    $estado = array(
        "mensaje" => "Pedido ingresado con exito.",
        "codigo" => 200
        );
        $textMedioPago='Medio de pago: *'.$pedido->medioPago.'*';
        $textMedioPago= '%0A' . urlencode($textMedioPago);
        $textEnvio='Metodo de entrega: *'.$pedido->metEntrega.'*';
        $textEnvio= '%0A' . urlencode($textEnvio);
        $urlFinal= $textCabeceraPedido.$textListProd.$textRecargos.$textTotal.$textMedioPago.$textEnvio.$textDire;
        $urlFinal = $urlWSP . $urlFinal;
        $pedido->url = $urlFinal;

    if ($pedido->medioPago=='tarjetas') {
        $preference = new MercadoPago\Preference();
        $item= new MercadoPago\Item();
        $item->title='Recargo';
        $item->quantity=1;
        $item->unit_price=$pedido->recargo;
        array_push($productosMP, $item);
        $preference->items=$productosMP;
        $preference->back_urls = array(
            "success" =>  "http://localhost/tazudoweb/pages/PagoAprobado.php",
            "failure" => "http://localhost/tazudoweb/#",
            "pending" => "http://localhost/tazudoweb/#"
        );
        $preference->payment_methods=array(
            "excluded_payment_types" => array(
              array(
                "id" => "ticket" // ID del medio de pago en efectivo que deseas excluir (por ejemplo, "ticket" para efectivo)
              )
            )
            );
        $preference->auto_return = "approved";
        $preference->external_reference = $pedido->id_pedido;
        $preference->save();
        $pedido->linkPago = $preference->init_point;
    }
    $respuesta->pedido=$pedido;
    $_SESSION['pedido']=$pedido;
}else{
    $respuesta->pedido=NULL;
    $estado = array(
        "mensaje" => "No completaste todos los datos",
        "codigo" => 400
        );
}
    $respuesta->estado=$estado;
    header('Content-Type: application/json');
    echo json_encode($respuesta);
    
?>