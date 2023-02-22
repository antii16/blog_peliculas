<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;

class Categoria{
    private string $id;
    private string $nombre;
    private BaseDatos $db;

    public function __construct()
    {
        $this->db = new BaseDatos();
        $this->errores = [];
    
    }


    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getNombre(): string{
        return $this->nombre;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public static function obtenerCategorias() {
        /**
         * Se obtienen todas las categorias creadas. 
         * Se utiliza en la vista header para mostrar las categorías
         */
        $categoria = new Categoria();
        $categorias = $categoria->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }

    public function getOne() {
        /**
         * Selecciona la categoria
         * Se utiliza para seleccionar los productos según esta categoría
         */
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->id}");
        return $categoria->fetch(PDO::FETCH_OBJ);
    }



    public function getAll() {
        /**
         * Selecciona todas la categorias
         */
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC; ");
        return $categorias;
    }


    public function save($name) {
        /**
         * Guarda la categoría
         * Si se ha guardado devuelve true, sino devuelve false
         */
        $ins = $this->db->prepare("INSERT INTO categorias(nombre) VALUES (:nombre)");
        $ins->bindParam( ':nombre', $nombre, PDO::PARAM_STR);
    
        $nombre= $name;
        
        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
        }

       return $result;
    }

    public function borrar($id_categoria) {
        /**
         * Borra la categoría gracias a su id
         * Si se ha borrado devuelve true, sino devuelve false
         */

        $sql = "DELETE FROM categorias WHERE id = :id";
        $resul =  $this->db->prepare($sql);
        $resul->bindParam(':id', $id, PDO::PARAM_STR);

        $id = $id_categoria;
        try{
            $resul->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
        }

       return $result;
    }

    public function editar($nombre_categoria, $id_categoria) {
        /**
         * Edita la categoría 
         * Si se ha editado devuelve true, sino devuelve false
         */


        $ins = $this->db->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");

        $ins->bindParam( ':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam( ':id', $id, PDO::PARAM_STR);

        $nombre = $nombre_categoria;
        $id = $id_categoria;

        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
            
        }

       return $result;
    }

    
}