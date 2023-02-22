<?php

namespace Controllers;
use Models\Pelicula;
use Utils\Utils;
use Lib\Pages;


class PeliculaController{
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
    }

    public function gestion(){
        /**
         * Muestra todos los peliculas que existen. 
         * Esto solo está disponible para el admin
         * Redirigue al Gestionar películas
         */
        Utils::isAdmin();
        $pelicula = new Pelicula();
        $peliculas = $pelicula->getAll();
        $this->pages->render('pelicula/gestion', ['peliculas' => $peliculas]);
    }

    public function index() {
        /**
         * Muestra todas las peliculas en de la base de datos 
         * en el main 
         */
        $pelicula = new Pelicula();
        $peliculas = $pelicula->getAll();
        $this->pages->render('layout/main', ['peliculas' => $peliculas]);
        
    }

    public function ver($id) {
        /**
         * Redirige a la vista ver
         * Obtiene los datos de la pelicula que se ha seleccionado
         * y los muestra, para luego comprarla 
         */
        $pelicula = new Pelicula();
        $pelicula->setId($id);
        $peli = $pelicula->getOneFilm();
        $this->pages->render('pelicula/ver', ['peli' => $peli]);
        
    }


    public function save() {
        /**
         * Guarda el pelicula que se ha creado.
         * La imagen se guarda en una carpeta. Si la carpeta no se ha creado, se crea
         */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['data']) && isset($_FILES['imagen']) ){

                $datos_pelicula = $_POST['data'];
                $img = $_FILES['imagen'];
                $pelicula = new Pelicula();
                $pelicula_validada = $pelicula->validar($datos_pelicula, $img);

                if(count($pelicula_validada) == 0){
                    //Si el $errores[] está vacío significa que no hay error

                    $save = $pelicula->save($datos_pelicula, $img);
                    $pelicula->crearCarpeta($img);
                
                    if($save) {
                        $_SESSION['crear_pelicula'] = 'complete';
                    }else{
                        $_SESSION['crear_pelicula'] = 'failed';
                    }
                }else{
                        $_SESSION['crear_pelicula'] = 'failed';
                }
                
            }
        }
        
        $this->pages->render('pelicula/crear');
    }


    public function editar($id) {
        /**
         * Redirige a la vista editar para autocompletar el formulario
         */
        $pelicula = new Pelicula();
        $pelicula->setId($id);
        $peli = $pelicula->getOne();
        $this->pages->render('pelicula/editar', ['peli' => $peli]);
        
        
    }

    public function saveEdit($id) {
        /**
         * Edita la pelicula seleccionada
         * Validando los campos correspondientes
         * Se crea una sesión para mostrar un mensaje de si se 
         * ha logrado editar o no
         */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['data'])){
                $datos = $_POST['data'];
                $pelicula = new Pelicula();
                $pelicula_validada = $pelicula->validar($datos);
                $img = $_FILES['imagen'];
                
                if(count($pelicula_validada) == 0) { 
                    //si $errores[] está vacío, edita la pelicula
                    $edit = $pelicula->editar($datos, $img, $id);
                    
                    if($edit) {
                        $_SESSION['pelicula_editada'] = 'complete';
                    }else{
                        $_SESSION['pelicula_editada'] = 'failed';
                    }

                }else{
                    $_SESSION['pelicula_editada'] = 'failed';
                }
            }else{
                $_SESSION['pelicula_editada'] = 'failed';
            }
        }

        $peliculas = $pelicula->getAll();
        $this->pages->render('pelicula/gestion', ['peliculas' => $peliculas]);
    }


    public function delete($id){
        /**
         * Borra la pelicula seleccionada
         * con el id que se le pasa
         */
        
        $pelicula = new Pelicula();
        $delete = $pelicula->borrar($id);
            
        $peliculas = $pelicula->getAll();
        $this->pages->render('pelicula/gestion', ['peliculas' => $peliculas]);
    }

}