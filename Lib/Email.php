<?php

namespace Lib;
use PHPMailer\PHPMailer\PHPMailer;
use Utils\Utils;

class Email {

    public function enviarEmail($pedido) {

        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '56ebc0e5495cae';
        $phpmailer->Password = '36393b7524606a';

        $phpmailer->setFrom('yourfilm@peliculas.com');
        $phpmailer->addAddress('yourfilm@peliculas.com', 'YourFilm.com');
        $phpmailer->Subject = 'Tu pedido';
        $phpmailer->isHTML(true);


        $phpmailer->CharSet = 'UTF-8';

        //Cuerpo del correo
        $stats = Utils::statsCarrito();
        $id = $pedido->setPedidoId();
        $pedido_id = $id->id;
        $phpmailer->Body = '';

        $phpmailer->Body .= " <h1>Tu pedido de YourFilm </h1> 
            <ul>
                <li>Nombre del cliente: {$_SESSION['identity']->nombre} </li>
                <li>Número de pedido: $pedido_id</li>
                <li>Precio total: {$stats['total']}$</li>
            </ul>
            
            <table>
            <tr>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Unidades</th>
            </tr>";
            foreach($_SESSION['carrito'] as $indice => $elemento) {
                $pelicula = $elemento['peliculas'];

                $phpmailer->Body .="<tr>
                    <td>$pelicula->titulo</td>
                    <td>$pelicula->precio</td>
                    <td>{$elemento['unidades']}</td>
                </tr></table>";

            }

        $phpmailer->send();
    }

   
}