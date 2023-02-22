<?php

use Models\Pelicula;

?>

<?php while($pel = $peli->fetch(PDO::FETCH_OBJ)):?>

<h2 style="margin-left:30px"><?=$pel->titulo?></h2>
<div style="margin-top:30px" >

    <img style="width:15rem; margin-left:30px" src="<?=$_ENV['base_url']?>img/<?=$pel->imagen?>">

    <div style="float:right; width:900px; margin:10px">
        <p><?=$pel->sinopsis?></p>
        <b><?=$pel->director?></b>
        <br>
        <a class="btn btn-info" href="<?=$_ENV['base_url']?>carrito/add/<?=$pel->id?>">Comprar</a>
    </div>
  


</div>
    
<?php endwhile?>
        

