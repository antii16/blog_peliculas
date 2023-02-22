<?php

namespace Controllers;
use Models\Pedido;
use Utils\Utils;
use Lib\Pages;
use Lib\Email;

use PDO;
use PDOException;


class PedidoController{

    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
        
    }

    public function hacer() {
        /**
         * Redirige a la vista donde se hará el pedido 
         */

        $this->pages->render('pedido/hacer');

        
    }

    public function mis_pedidos() {
        /**
         * Muestra todos los pedidos del usuario
         */
        $pedido = new Pedido();
        $pedidos = $pedido->getAllPedidoId();
        $this->pages->render('pedido/mispedidos', ['pedidos' => $pedidos]);
    }

    public function save() {
        /*
        Guarda el pedido y la linea de pedido, si el pedido no se guarda correctamente,
        la linea de pedido tampoco.
        Si el pedido y la linea del pedido se realizan correctamente, se envía el email
        de confimarmación al cliente
        También valida si los campos están completos
         */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['data'])){
                $datos = $_POST['data'];
                $pedido = new Pedido();
                $stats = Utils::statsCarrito();

                $pedido_validado = $pedido->validar($datos);
               
                if(count($pedido_validado) == 0){

                    $pedido_save = $pedido->save($datos, $stats);
                    if($pedido) {
                        $email = new Email();
                        $email->enviarEmail($pedido);
                        $this->pages->render('pedido/confirmado');

                    }else{
                        $_SESSION['pedido_creado'] = 'failed';
                        $this->pages->render('pedido/hacer');
                    }
                }else{
                    $_SESSION['pedido_creado'] = 'failed';
                    $this->pages->render('pedido/hacer');
                }
            
            }
        }
        
    }

}