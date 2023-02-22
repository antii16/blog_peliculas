<?php

namespace Controllers;
use Models\Usuario;
use Lib\Pages;
use Lib\Router;


class UsuarioController{
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        
    }


    public function registro() {
        /**
         * Se guardan los datos de un nuevo usuario o de un usuario
         * que quiera editar sus datos.
         * La contraseña se encripta y se validan los datos. 
         * Si los datos están validados se crea o se edita el usuario
         * Si name es registrar, se crea un nuevo usuario
         * Si la $_SESSION['identity'] existe se edita el usuario
         */
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['data'])) {

                $registrado = $_POST['data'];
                $registrado['password'] = password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost'=>4]);
                $usuario = Usuario::fromArray($registrado);
                $usuario_validado = $usuario->validar_y_sanitizarRegistro($_POST['data']['password']);
                
                

                if(count($usuario_validado) == 0) {
                    /******************REGISTRAR******************** */
                    if(isset($_POST['registrar'])){
                        $save = $usuario->save();
                        if($save) {
                            $_SESSION['register'] = 'complete';
                        }else{
                            $_SESSION['register'] = 'failed';
                        }
                    }

                    /****************EDITAR************* */

                    elseif(isset($_SESSION['identity'])) {
                        $edit = $usuario->edit($_SESSION['identity']->id, $registrado['password'], $registrado['email']);
                    
                        if($edit){
                            $_SESSION['editar'] = 'complete';   
                        }else{
                            $_SESSION['editar'] = 'failed';
                        }   
                    }
                    else{
                        $_SESSION['editar'] = 'failed';
                    }   
                }else{
                    $_SESSION['register'] = 'failed';
                } 
            }
        }
        
        $this->pages->render('usuario/registro');
    }

    public function login() {
        /**
         * Se realiza el login del usuario
         * Se valida que el correo y la contraseña estén correctamente escritas
         * Si se loguea correctamente se crea la sesion  $_SESSION['identity']
         * y si el rol es admin se crea  $_SESSION['admin']
         */

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['data'])) {

                $auth = $_POST['data'];
                $usuario = Usuario::fromArray($auth);
                $usuario_validado = $usuario->validar_y_sanitizarLogin();

                if(count($usuario_validado) == 0) {
                    $identity = $usuario->login();
                    if($identity && is_object($identity)) {
                        $_SESSION['identity'] = $identity;
                        
                        if($identity->rol == 'admin') {
                            $_SESSION['admin'] = true;
                          
                        }
                        header('Location: http://localhost/PROYECTO_FIN/public/');
                    }else{
                        $_SESSION['login'] = 'failed';
                    }


                }else{
                    $_SESSION['login'] = 'failed';

                }
                
        }
       
    }
    $this->pages->render('usuario/login');
}


    public function logout(){
        /**
         * Se cierra la sesión del usuario, del admin y del carrito
         * y devuelve a la pagina principal
         */
        if(isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }

        if(isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }

        if(isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }
       

        header('Location: http://localhost/PROYECTO_FIN/public/');
    }

}
