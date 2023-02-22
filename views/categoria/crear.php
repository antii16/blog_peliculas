<h1>Crear nueva categoría</h1>
<?php 

use Utils\Utils;

?>

<?php if(isset($_SESSION['crear_categoria']) && $_SESSION['crear_categoria']=='complete'):?>
    <strong class="alert_green">Categoría creada</strong>

<?php elseif(isset($_SESSION['crear_categoria']) && $_SESSION['crear_categoria']=='failed'):?>
    <strong class="alert_red">La categoría no se ha creado</strong>
<?php endif; ?>

<?php Utils::deleteSession('crear_categoria'); ?>


<form action="<?=$_ENV['base_url']?>categoria/save" method="POST">
  <div class="col-md-3">
    <label for="nombre" class="form-label">Nombre: </label>
    <input type="nombre" class="form-control" name="nombre">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Crear</button>
  </div>
</form>

