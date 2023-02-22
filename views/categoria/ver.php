<?php

use Models\Pelicula;
use Models\Categoria;

?>

<h1 style="margin-left:30px;"><?=$categoria->nombre?></h1>

<div class="row row-cols-1 row-cols-md-4">
<?php while($pel = $peliculas->fetch(PDO::FETCH_OBJ)):?>
  <div class="col" style="margin-left:30px;">
    <div class="card" style="width: 15rem;">
    <img  class="card-img-top" src="<?=$_ENV['base_url']?>img/<?=$pel->imagen?>">
      <div class="card-body">

        <h5 class="card-title"><a style="text-decoration:none;color:black;" href="<?=$_ENV['base_url']?>pelicula/ver/<?=$pel->id?>"><?=$pel->titulo?></a></h5>
      </div>
    </div>
  </div>
 
  <?php endwhile?>
</div>

        

