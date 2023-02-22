<?php

namespace Controllers;
use Models\Categoria;
use Models\Pelicula;
use Utils\Utils;
use Lib\Pages;


class CategoriaController{
    private Pages $pages;

    function __construct(){
        $this->pages = new Pages();
    }

    public function gestion(){
        /* 
        Si es admin se gestionan las categorías.
        Se buscan todas las categorías que existan y se muestran en la vista index de categoría,
        donde se tendrá la opción de crear una categoría
        */
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        $this->pages->render('categoria/gestion', ['categorias' => $categorias]);
    }

    public function save() {
        /**
         * Se guarda la categoría creada si el usuario es admin y si el campo del formulario está rellenado,
         * sino salta un error
         * Se crea la  $_SESSION['crear_categoria']
         */
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Utils::isAdmin();
            $categoria = new Categoria();

            if($usuario !== false) {
                if($_POST['nombre'] !== ""){
                    $save = $categoria->save($_POST['nombre']);
                    if($save) {
                        $_SESSION['crear_categoria'] = 'complete';
                        
                    }else{
                        $_SESSION['crear_categoria'] = 'failed';
                    }
                }else{
                    $_SESSION['crear_categoria'] = 'failed';
                }
                
            }else{
                $_SESSION['crear_categoria'] = 'failed';
            }
        }
        
        $this->pages->render('categoria/crear');
    }


    public function ver($id) {
        /**
         * Permite mostrar las peliculas que hay en las categorías con el id de la categoría
         * Por ejemplo, para la categoría aventura, se mostrarán solo las peliculas que sean de
         * aventura  
         */
    
        $categoria = new Categoria();
        $categoria->setId($id);
        $categoria = $categoria->getOne();
        $pelicula = new Pelicula();
        $peliculas = $pelicula->setCategoriaId($categoria->id);

        
        $this->pages->render('categoria/ver', ['categoria' => $categoria, 'peliculas' => $peliculas]);
    }


    public function editar($id) {
        /**
         * Selecciona la pelicula a editar con el id
         * Redirige a la vista editar para autocompletar el formulario
         * de categoría 
         */
    
        $categoria = new Categoria();
        //Obtiene los datos de la entrada según su id
        $categoria->setId($id);
        $cat = $categoria->getOne();

        $this->pages->render('categoria/editar', ['cat' => $cat]);
        
        
    }

    public function saveEdit($id) {
        /**
         * Edita la entrada seleccionada
         * El campo no puede estar vacío
         * Se crea la sesión $_SESSION['editar_categoria']
         */
        $categoria = new Categoria();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_POST['nombre'])){
                if($_POST['nombre'] !== "") { //si $errores[] está vacío
                    $edit = $categoria->editar($_POST['nombre'], $id);
                    if($edit) {
                        $_SESSION['editar_categoria'] = 'complete';
                        
                    }else{
                        $_SESSION['editar_categoria'] = 'failed';
                    }

                }else{
                    $_SESSION['editar_categoria'] = 'failed';
                }
            }else{
                $_SESSION['editar_categoria'] = 'failed';
            }
        }
        $categorias = $categoria->getAll();
        $this->pages->render('categoria/gestion', ['categorias' => $categorias]);
    }


    public function borrar($id) {
        /**
         * Se crea borra la categoría seleccionada
         * gracias a su id
         */

        $categoria = new Categoria();
        $delete = $categoria->borrar($id);

        if($delete) {
            $_SESSION['categoria_borrada'] = 'complete';
        }else{
            $_SESSION['categoria_borrada'] = 'failed';
        }
    
        $categorias = $categoria->getAll();
        $this->pages->render('categoria/gestion', ['categorias' => $categorias]);
    }

}