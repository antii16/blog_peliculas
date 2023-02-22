<?php

use Models\Categoria;

?>
<h1>Editar <?=$peli->titulo?></h1>

<form style="margin-left: 30px; margin-top:30px" action="<?=$_ENV['base_url']?>pelicula/editar/<?=$peli->id?>" method="POST"  enctype="multipart/form-data">
<p>
    <label for="titulo">Titulo: </label>
    <input type="text" name="data[titulo]" value="<?=$peli->titulo?>">
</p>

<?php $categorias = Categoria::obtenerCategorias(); ?>
<p>

    <label for="categoria">Categoria:</label>
    <select name="data[categoria_id]">
        <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)):?>
            <option value="<?=$cat->id?>" selected><?=$cat->nombre?></option>  
        <?php endwhile?>

    </select>

</p>

<p>
    <label for="director">Director: </label>
    <input type="text" name="data[director]" value="<?=$peli->director?>">
</p>

<p>
    <label for="sinopsis">Sinopsis: </label>
    <input type="text" name="data[sinopsis]" value="<?=$peli->sinopsis?>">
</p>
<p>
    <label for="precio">Precio: </label>
    <input type="text" name="data[precio]" value="<?=$peli->precio?>">
</p>

<p>
    <label for="stock">Stock: </label>
    <input type="text" name="data[stock]" value="<?=$peli->stock?>">
</p>

<p>
    <label for="imagen">Imagen  predeterminada: <?=$peli->imagen?></label>
    <br>
    <input type="file" name="imagen">
</p>

<input type="submit"  value="Editar" class="btn btn-primary">

</form>