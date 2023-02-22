<?php 
use Utils\Utils;
?>

<?php if(isset($_SESSION['register']) && $_SESSION['register']=='complete'):?>
    <strong class="alert_green">Registro completado correctamente</strong>

<?php elseif(isset($_SESSION['register']) && $_SESSION['register']=='failed'):?>
    <strong class="alert_red">Registro fallido, introduce bien los datos</strong>
<?php endif; ?>

<?php Utils::deleteSession('register'); ?>

<?php if(isset($_SESSION['editar']) && $_SESSION['editar']=='complete'):?>
    <strong class="alert_green">Los datos se han editado correctamente</strong>


<?php elseif(isset($_SESSION['editar']) && $_SESSION['editar']=='failed'):?>
    <strong class="alert_red">Los datos no se han editado correctamente</strong>

<?php endif; ?>

<?php Utils::deleteSession('editar'); ?>

<?php if(isset($_SESSION['identity'])):?>
    <h1>Editar perfil</h1>
<?php else:?>   
    <h1>Crear cuenta</h1>
    <?php endif;?> 


<form  style="margin-left: 30px; margin-top:30px" action="<?=$_ENV['base_url']?>usuario/registro" method="POST" enctype="multipart/form-data">
    <p> 
        <label for="nombre">Nombre: </label>
        <input type="text" name="data[nombre]" value="<?php if(isset($_SESSION['identity'])) echo $_SESSION['identity']->nombre?>">
    </p>
    <p> 
        <label for="apellidos">Apellidos: </label>
        <input type="text" name="data[apellidos]" value="<?php if(isset($_SESSION['identity'])) echo $_SESSION['identity']->apellidos?>">
    </p>

    <p> 
        <label for="email">Email: </label>
        <input type="text" name="data[email]" value="<?php if(isset($_SESSION['identity'])) echo $_SESSION['identity']->email?>">
    </p>

    <p> 
        <label for="password">Contraseña: </label>
        <input type="password" name="data[password]">
    </p>
    
    <?php if(isset($_SESSION['identity'])):?>
        <input type="submit"  name="editar" value="Edita los datos" class="btn btn-success">
        
    <?php else:?>   
        <input type="submit" name="registrar"  value="Registrarse" class="btn btn-primary">
    <?php endif;?>  

   

</form>