<h1>Gestionar categorias</h1>
<p>
    <a href="<?=$_ENV['base_url']?>categoria/save" class="btn btn-primary">Crear Categoría</a>
</p>

<?php if(isset($_SESSION['editar_categoria']) && $_SESSION['editar_categoria']=='complete'):?>
    <strong class="alert_green">Categoría editada</strong>

<?php elseif(isset($_SESSION['editar_categoria']) && $_SESSION['editar_categoria']=='failed'):?>
    <strong class="alert_red">La categoría no se ha editada</strong>
<?php endif; ?>

<?php unset($_SESSION['editar_categoria']); ?>

<table class="table">
<thead class="thead-dark">
    <tr>
        <th style="text-align: center;" scope="col">Identificador</th>
        <th style="text-align: center;" scope="col">Nombre</th>
        <th style="text-align: center;" scope="col">Opción</th>
    </tr>

</thead>
<tbody>
    <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)):?>
        <tr>
            <td style="text-align: center;"><?=$cat->id;?></td>
            <td style="text-align: center;"><?=$cat->nombre;?></td>
            <td style="text-align: center;">
                <a class="btn btn-danger" href="<?=$_ENV['base_url']?>categoria/borrar/<?=$cat->id?>">Borrar</a>
                <a class="btn btn-success" href="<?=$_ENV['base_url']?>categoria/editar/<?=$cat->id?>">Editar</a>
            </td>
        </tr>
     <?php endwhile?>

    </tbody>
</table>