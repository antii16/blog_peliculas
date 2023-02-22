<?php
use Models\Categoria;
header('Content-Type: text/html; charset=UTF-8'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

   
    <title>YourFilm</title>
    <style>

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;


    }
      html,
      body {
        width: 100%;
        overflow-x: hidden;

      }
    </style>
</head>

<div class="container">

  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">

    <a href="<?=$_ENV['base_url']?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>    
      <span class="fs-4">YourFilm</span>
    </a>

    <ul class="nav nav-pills">       
        <!-- SI ESTAS LOGUEADO COMO ADMIN-->
        <?php if(isset($_SESSION['admin'])): ?>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>categoria/gestion">Gestionar categorías </a></li>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>pelicula/gestion">Gestionar peliculas </a></li>
        <?php endif; ?>

        <!-- SI ESTAS LOGUEADO-->
        <?php if(isset($_SESSION['identity'])):?>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>pedido/mispedidos">Mis pedidos</a></li>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>usuario/logout">Cerrar Sesión</a></li>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>carrito/index">Cesta</a></li>
        <?php endif; ?>

        <!-- SI NO ESTAS LOGUEADO-->
        <?php if(!isset($_SESSION['identity'])):?>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>usuario/registro">Registrarse</a></li>
            <li  class="nav-item"><a class="nav-link" href="<?=$_ENV['base_url']?>usuario/login">Login</a></li>
            <?php else: ?>
                <li  class="nav-item">
                <a class="btn btn-primary" href="<?=$_ENV['base_url']?>usuario/registro">
                  
                  <?=$_SESSION['identity']->nombre?> <?=$_SESSION['identity']->apellidos?> 
                  </a>
                </li>
        <?php endif; ?>

        <div class="dropdown">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            Géneros
          </a>

          <?php $categorias = Categoria::obtenerCategorias(); ?>

          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)):?>
            <li><a class="dropdown-item" href="<?=$_ENV['base_url']?>categoria/ver/<?=$cat->id?>"><?=$cat->nombre?></a></li>
            <?php endwhile?>
          </ul>
        </div>
    </ul>
    
    


    <ul class="nav nav-pills">
       
    </ul>    


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


</header>


</div>
<body>
    
