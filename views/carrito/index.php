<?php

use Models\Pelicula;
use Utils\Utils;
?>

<h1>Carrito de la compra</h1>

<?php if(isset($_SESSION['carrito'])):?>
<table  class="table table-dark"> 

    <tr>
        <th style="text-align: center;">Imagen</th>
        <th style="text-align: center;">Nombre</th>
        <th style="text-align: center;">Precio</th>
        <th style="text-align: center;">Unidades</th>
        <th style="text-align: center;">Eliminar</th>
    </tr>


    <?php foreach($_SESSION['carrito'] as $indice => $elemento): ?>
        <?php  $pelicula = $elemento['peliculas'];?>

        <tr>
            <td style="width: 5em;"><img class="img-fluid" src="<?=$_ENV['base_url']?>img/<?=$pelicula->imagen?>"></td>
            <td style="text-align: center;"><?=$pelicula->titulo;?></td>
            <td style="text-align: center;"><?=$pelicula->precio;?> $</td>
            <td style="text-align: center;">

                <?=$elemento['unidades']?>
                <br>
                <a class="btn btn-primary" href="<?=$_ENV['base_url']?>carrito/down/<?=$indice?>">-</a>    
                <a class="btn btn-primary" href="<?=$_ENV['base_url']?>carrito/up/<?=$indice?>">+</a>
            </td>
            <td style="text-align: center;"><a class="btn btn-danger" href="<?=$_ENV['base_url']?>carrito/delete/<?=$indice?>">Borrar</a></td>
        </tr>
        <?php endforeach; ?>   
</table>

<p>
    <?php $stats = Utils::statsCarrito();?>
    Precio total: <?=$stats['total']?> $
</p>



<p>
    <a href="<?=$_ENV['base_url']?>carrito/delete_all" class="btn btn-danger">Vaciar</a>
</p>
<p>
    <a href="<?=$_ENV['base_url']?>pedido/hacer" class="btn btn-success">Hacer pedido</a>
</p>

<?php else: ?>
    <p>El carrito está vacío, añade algún producto</p>

<?php endif; ?>
