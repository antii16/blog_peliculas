<?php

use Models\Pelicula;
use Models\Pedido;
use Utils\Utils;

?>

<h2>Tu pedido se ha confirmado</h2>

<h3>Datos del pedido</h3>

<?php 

$pedido = new Pedido();
$id_pedido = $pedido->setPedidoId();
$stats = Utils::statsCarrito();
?>

<ul>
    <li>Número de compra: <?=$id_pedido->id?></li>
    <li>Total a pagar: <?=$stats['total']?> $ </li>
</ul>


<h4>Peliculas: </h4>


<table  class="table table-dark">
    <tr>
        <th style="text-align: center;">Imagen</th>
        <th style="text-align: center;">Titulo</th>
        <th style="text-align: center;">Precio</th>
        <th style="text-align: center;">Unidades</th>
    </tr>
    <?php foreach($_SESSION['carrito'] as $indice => $elemento): ?>
        <?php  $pelicula = $elemento['peliculas'];?>
        
        <tr>
    
            <td style="width: 5em;"><img  class="img-fluid" src="<?=$_ENV['base_url']?>img/<?=$pelicula->imagen?>"></td>
            <td style="text-align: center;"><?=$pelicula->titulo;?></td>
            <td style="text-align: center;"><?=$pelicula->precio;?> $</td>
            <td style="text-align: center;"><?=$elemento['unidades']?></td>
        </tr>
        <?php endforeach; ?>   
</table>
<?php unset($_SESSION['carrito']);?>

