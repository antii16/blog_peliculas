<?php

namespace Utils;

class Utils{
    
    public static function deleteSession($name) {
        if(isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }


    public static function isAdmin() {
        if(!isset($_SESSION['admin'])) {
            header('Location: '.base_url);

        }else{
            return true;
        }
    }


    public static function isIdentity() {
        if(!isset($_SESSION['identity'])) {
            header('Location: '.base_url);

        }else{
            return true;
        }
    }


    public static function statsCarrito() { 
        
        if(!isset($_SESSION['carrito'])) {
            header('Location: http://localhost/PROYECTO_FIN/public/');

        }else{
            $stats = array(
                "count" => 0,
                "total" => 0
            );

            $stats['count'] = count($_SESSION['carrito']);

           foreach($_SESSION['carrito'] as $producto) {
                $stats['total'] += $producto['precio']*$producto['unidades'];
           }
            
            
        }

        return $stats;
    }




}