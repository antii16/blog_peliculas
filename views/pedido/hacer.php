<h1>Hacer pedido</h1>

<a href="<?=$_ENV['base_url']?>carrito/index" class="btn btn-info">Ver las películas y el precio del pedido</a>

<h3>Dirección para el envío</h3>


<?php if(isset($_SESSION['pedido_creado']) && $_SESSION['pedido_creado']=='failed'):?>
    <strong class="alert_red">El pedido no se ha realizado. Rellene los campos</strong>
<?php endif; ?>

<?php unset($_SESSION['pedido_creado']); ?>

<form style="margin-left: 30px; margin-top:30px" action="<?=$_ENV['base_url']?>pedido/save" method="POST">
    <p>
        <label for="provincia">Provincia:</label>
        <input type="text" name="data[provincia]">
    </p>
    <p>
        <label for="localidad">Ciudad: </label>
        <input type="text" name="data[localidad]">
    </p>
    <p>
        <label for="direccion">Dirección: </label>
        <input type="text" name="data[direccion]">
    </p>
    <input type="submit" value="Confirmar pedido" class="btn btn-success">

</form>