<?php

use Models\Categoria;

?>
<h1>Crear una pelicula</h1>

<?php if(isset($_SESSION['crear_pelicula']) && $_SESSION['crear_pelicula']=='complete'):?>
    <strong class="alert_green">Película creada</strong>

<?php elseif(isset($_SESSION['crear_pelicula']) && $_SESSION['crear_pelicula']=='failed'):?>
    <strong class="alert_red">La película no se ha podido crear</strong>
<?php endif; ?>

<?php unset($_SESSION['crear_pelicula']); ?>


<form style="margin-left: 30px; margin-top:30px" action="<?=$_ENV['base_url']?>pelicula/crear" method="POST"  enctype="multipart/form-data">
<p>
    <label for="titulo">Titulo: </label>
    <input type="text" name="data[titulo]">
</p>

<?php $categorias = Categoria::obtenerCategorias(); ?>
<p>

    <label for="categoria">Categoria:</label>
    <select name="data[categoria_id]">
        <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)):?>
            <option value="<?=$cat->id?>"><?=$cat->nombre?></option>  
        <?php endwhile?>

    </select>

</p>

<p>
    <label for="director">Director: </label>
    <input type="text" name="data[director]">
</p>

<p>
    <label for="sinopsis">Sinopsis: </label>
    <input type="text" name="data[sinopsis]">
</p>
<p>
    <label for="precio">Precio: </label>
    <input type="text" name="data[precio]">
</p>

<p>
    <label for="stock">Stock: </label>
    <input type="text" name="data[stock]">
</p>

<p>
    <label for="imagen">Imagen: </label>
    <input type="file" name="imagen">
</p>

<input type="submit" value="Guardar" class="btn btn-primary">

</form>