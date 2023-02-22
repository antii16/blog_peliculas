<?php

namespace Controllers;
use Models\Pelicula;
use Utils\Utils;
use Lib\Pages;


class CarritoController{
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
    }

    public function index() {
        /**
         * Si el carrito existe se redirige a la vista index donde se muestra
        * el carrito de la compra
        */
        $this->pages->render('carrito/index');
        
    }


    public function down($indice) {
        /**
         * Reduce las unidades de la pelicula 
         * seleccionada del carrito 
         * Si las unidades llegan a 0 se borra la $_SESSION['carrito'][$indice]
         * y si se borran todas las peliculas se borra la $_SESSION['carrito']
         * */
       
        $_SESSION['carrito'][$indice]['unidades']--;
        if($_SESSION['carrito'][$indice]['unidades'] == 0) {
            unset($_SESSION['carrito'][$indice]);

            if(empty($_SESSION['carrito'])) {
                unset($_SESSION['carrito']);
            }
        }
            
        
        header('Location:'.$_ENV['base_url']. 'carrito/index');
    }


    public function up($indice) {
        /**
         * Aumenta las unidades del carrito
         * hasta que el stock de la pelicula lo permita
         * Si la pelicula no tiene stock, 
         * se crea la $_SESSION['stock']
         * */
    
        $stockActual = $_SESSION['carrito'][$indice]['peliculas']->stock;
        $unidades = $_SESSION['carrito'][$indice]['unidades'];

        if($stockActual <= $unidades ) {
            $_SESSION['stock'] = "agotado";
            
        }else{
            $_SESSION['carrito'][$indice]['unidades']++; 
        }
             
        header('Location:'.$_ENV['base_url']. 'carrito/index');
        }
           


    public function add($pelicula_id) {
        /**
         * Añade una pelicula al carrito, creando la sesion de carrito
         * Crea el carrito si el usuario se ha logueado
         * */
        if(isset($_SESSION['identity'])) {

            if(isset($_SESSION['carrito'])) {
                //Si el carrito existe se aumenta la unidad
                $counter = 0;
                foreach($_SESSION['carrito'] as $indice => $elemento) {
                    if($elemento['id_pelicula'] == $pelicula_id) {

                        $_SESSION['carrito'][$indice]['unidades']++;
                        $counter++;
                        
                        
                    }
                }
            }
            
            if(!isset($counter) || $counter == 0) { 
                
                //Conseguir pelicula
                $pelicula = new Pelicula();
                $stock = $pelicula->stock($pelicula_id);
                $pelicula->setId($pelicula_id);
                $pelicula = $pelicula->getOne();
            
                
                if($stock->stock <= 0) { 
                    //Cuando el stock de la pelicula está agotado no permite agregarlo al carrito
                    $_SESSION['stock'] = 'agotado';
                    header('Location:'.$_ENV['base_url'].'carrito/index');
                }else {
                    //Añadir al carrito 
                    if(is_object($pelicula)) {
                        $_SESSION['carrito'][] = array(
                            "id_pelicula" => $pelicula->id,
                            "precio" => $pelicula->precio,
                            "unidades" => 1,
                            "peliculas" => $pelicula

                        );
                    }
            
                }
                
            }
            
            header('Location:'.$_ENV['base_url'].'carrito/index');
        }else{
            header('Location:'.$_ENV['base_url'].'pelicula/ver/'.$pelicula_id);
        }
        
            
        }
        
    



    public function delete($indice) {
        /**
         * Borra la pelicula del carrito 
         * Si el carrito está vacío borra la $_SESSION['carrito']
         */
       
        unset($_SESSION['carrito'][$indice]);

        if(empty($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }
    
        
        header('Location:'.$_ENV['base_url']. 'carrito/index');
    }


    public function delete_all() {
        /**
         * Vacía el carrito, borrando la sesión de stock y carrito
         * Redirigue al carrito
         */
        unset($_SESSION['carrito']);
        header('Location:'.$_ENV['base_url']. 'carrito/index'); 
    }

  
}