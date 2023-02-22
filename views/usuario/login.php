<?php  use Utils\Utils; ?>

<?php if(isset($_SESSION['login']) && $_SESSION['login']=='failed'):?>
    <strong class="alert_red">Login fallido, introduce bien los datos</strong>
<?php endif; ?>
<?php unset($_SESSION['login']);?>


<h1>Login</h1>
<form style="margin-left: 30px; margin-top:30px" action="<?=$_ENV['base_url']?>usuario/login" method="POST" enctype="multipart/form-data">
    <p>
        <label for="email">Email:</label>
        <input type="text" name="data[email]">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="data[password]">
    </p>

    <input type="submit"  value="Login" class="btn btn-primary">

</form>

