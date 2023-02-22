<h1>Gestionar Peliculas</h1>

<?php if(isset($_SESSION['pelicula_editada']) && $_SESSION['pelicula_editada']=='complete'):?>
    <strong class="alert_green">Película editada</strong>

<?php elseif(isset($_SESSION['pelicula_editada']) && $_SESSION['pelicula_editada']=='failed'):?>
    <strong class="alert_red">La película no se ha editado</strong>
<?php endif; ?>

<?php unset($_SESSION['pelicula_editada']); ?>

<p>
    <a href="<?=$_ENV['base_url']?>pelicula/crear" class="btn btn-primary">Crear Pelicula</a>
</p>

<table  class="table">
    <tr>
        <th style="text-align: center;" scope="col">Identificador</th>
        <th style="text-align: center;" scope="col">Titulo</th>
        <th style="text-align: center;" scope="col">Sinopsis</th>
        <th style="text-align: center;" scope="col">Director</th>
        <th style="text-align: center;" scope="col">Precio</th>
        <th style="text-align: center;" scope="col">Opción</th>
    </tr>
    <?php while($pel = $peliculas->fetch(PDO::FETCH_OBJ)):?>
        <tr>
            <td style="text-align: center;"><?=$pel->id?></td>
            <td style="text-align: center;"><?=$pel->titulo?></td>
            <td style="text-align: center;"><?=$pel->sinopsis?></td>
            <td style="text-align: center;"><?=$pel->director?></td>
            <td style="text-align: center;" ><?=$pel->precio?></td>
            
            <td style="text-align: center;" ><a class="btn btn-danger" href="<?=$_ENV['base_url']?>pelicula/delete/<?=$pel->id?>">Borrar</a></td>
            <td style="text-align: center;"><a class="btn btn-success" href="<?=$_ENV['base_url']?>pelicula/editar/<?=$pel->id?>">Editar</a></td>

        </tr>
     <?php endwhile?>
</table>