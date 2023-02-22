<h1>Editar categoría <?=$cat->nombre?></h1>

<form action="<?=$_ENV['base_url']?>categoria/editar/<?=$cat->id?>" method="POST">
  <div class="col-md-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="nombre" class="form-control" name="nombre" value="<?=$cat->nombre?>">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Editar</button>
  </div>
</form>