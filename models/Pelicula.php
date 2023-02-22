<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Pelicula{
    private string $id;
    private string $categoria_id;
    private string $usuario_id;
    private string $titulo;
    private string $sinopsis;
    private string $director;
    private string $precio;
    private string $stock;
    private string $imagen;
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

    public function getCategoria_Id(): int{
        return $this->categoria_id;
    }

    public function setCategoria_Id(int $categoria_id){
        $this->categoria_id = $categoria_id;
    }

    public function getUsuario_Id(): int{
        return $this->usuario_id;
    }

    public function setUsuario_Id(int $usuario_id){
        $this->usuario_id = $usuario_id;
    }

    public function getTitulo(): string{
        return $this->titulo;
    }

    public function setTitulo(string $titulo){
        $this->titulo = $titulo;
    }

    public function getSinopsis(): string{
        return $this->sinopsis;
    }

    public function setSinopsis(string $sinopsis){
        $this->sinopsis = $sinopsis;
    }

    public function setDirector(string $director){
        $this->director = $director;
    }

    public function getDirector(): string{
        return $this->director;
    }

    public function setPrecio(string $precio){
        $this->precio = $precio;
    }

    public function getPrecio(): string{
        return $this->precio;
    }

    public function setStock(string $stock){
        $this->stock = $stock;
    }

    public function getStock(): string{
        return $this->stock;
    }


    public function getImagen(): string{
        return $this->imagen;
    }

    public function setImagen(string $imagen){
        $this->imagen = $imagen;
    }


    public function setCategoriaId(string $categoria_id){
        /**
         * Selecciona los peliculas de una categoria en específico
         * Se utliza en el controlador de categoria para seleccionar los peliculas de la categoria
         */
        $categoria_id = $this->db->query("SELECT * FROM peliculas WHERE categoria_id={$categoria_id} ORDER BY id DESC;");
        return $categoria_id;
    }

    public function setImagenPelicula($id) {
        //Devuelve la imagen de una entrada
        $entradas = $this->db->query("SELECT imagen FROM peliculas 
        WHERE id={$id} ORDER BY id DESC;");
        return $entradas->fetch(PDO::FETCH_OBJ);
    }


    public function getAll() {
        /**
         * Selecciona todos los peliculas
         */
        $peliculas = $this->db->query("SELECT * FROM peliculas ORDER BY id DESC;");
        return $peliculas;
    }

    public static function obtenerPeliculas() {
        /**
         * Se obtienen todos los peliculas que existen
         */
        $pelicula = new Pelicula();
        $peliculas = $pelicula->db->query("SELECT * FROM peliculas ORDER BY id DESC;");
        return $peliculas;
    }

    public function getOne() {
        /**
         * Obtiene los datos de una pelicula según su id
         * Se utilia en el controlador del carrito
         */
        $peliculas = $this->db->query("SELECT * FROM peliculas WHERE id={$this->id}");
        return $peliculas->fetch(PDO::FETCH_OBJ);
    }

    public function getOneFilm() {
        /**
         * Selecciona una pelicula según su id
         * Se utilia en el controlador del carrito
         */
        $peliculas = $this->db->query("SELECT * FROM peliculas WHERE id={$this->id}");
        return $peliculas;
    }


    public function stock($pelicula_id) {
        /**
         * Selecciona el stock según el id del pelicula
         * Se utiliza en el controlador del carrito
         */
        $peliculas = $this->db->query("SELECT stock FROM peliculas WHERE id = '$pelicula_id'");
        return $peliculas->fetch(PDO::FETCH_OBJ);
        
    }

    public function validar($datos) {
        /**
         * Validacion de la pelicula.
         * Valida el si los campos no están vacíos y que el stock y el precio son números
         * y no letras
         **/
        if(!$datos['titulo']) {
            $this->errores[] = "El titulo es obligatorio";
        }

        if(!$datos['sinopsis']) {
            $this->errores[] = "La sinopsis es obligatoria";
        }

        if(!$datos['director']) {
            $this->errores[] = "El director es obligatorio";
        }

        if(!$datos['precio']) {
            $this->errores[] = "El precio es obligatorio";
        }
        if(!is_numeric($datos['precio'])) {
            $this->errores[] = "El precio debe ser un número";
        }

        if(!$datos['stock']) {
            $this->errores[] = "El stock es obligatorio";
        }

        if(!is_numeric($datos['stock'])) {
            $this->errores[] = "El stock debe ser un número";
        }


        return  $this->errores;
    }


    public function save($datos, $img) {
        /**
         * Guarda los datos de la pelicula
         * que se quiere crear pasandole los datos de la pelicula
         * y la imagen
         * Devuelve true si se ha creado y false si no
         */

        $ins = $this->db->prepare("INSERT INTO peliculas(categoria_id, usuario_id, titulo, sinopsis, director, precio, stock, imagen) 
        VALUES (:categoria_id, :usuario_id, :titulo, :sinopsis, :director, :precio, :stock, :imagen)");

        $ins->bindParam( ':categoria_id', $categoria_id, PDO::PARAM_STR);
        $ins->bindParam( ':usuario_id', $usuario_id, PDO::PARAM_STR);
        $ins->bindParam( ':titulo', $titulo, PDO::PARAM_STR);
        $ins->bindParam( ':sinopsis', $sinopsis, PDO::PARAM_STR);
        $ins->bindParam( ':director', $director, PDO::PARAM_STR);
        $ins->bindParam( ':precio', $precio, PDO::PARAM_STR);
        $ins->bindParam( ':stock', $stock, PDO::PARAM_STR);
        $ins->bindParam( ':imagen', $imagen, PDO::PARAM_STR);
    
        
        $categoria_id = $datos['categoria_id'];
        $usuario_id = $_SESSION['identity']->id;
        $titulo = $datos['titulo'];
        $sinopsis = $datos['sinopsis'];
        $director = $datos['director'];
        $precio = $datos['precio'];
        $stock = $datos['stock'];
        $imagen = $img['name'];
        
        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
            
        }

       return $result;
    }

    public function crearCarpeta($imagen) {
        /**
         * Guarda la imagen y crea la carpeta si no existe
         * La imagen debe ser de tipo jpg, jpeg o png
         */
        $nombre = $imagen['name'];
        $tipo = $imagen['type'];
      
        if($tipo == 'image/jpg' || $tipo == 'image/jpeg' || $tipo == 'image/png') {
            if(!is_dir('img')) {
                mkdir('img', 0777);
            }
            move_uploaded_file($imagen['tmp_name'], 'img/'.$nombre);
          
            
        }
    }

    public function editar($datos, $img, $id_pelicula) {
        /**
         * Edita los datos de la pelicula seleccionada.
         * La imagen es predeterminada, por lo que si no selecciona
         * una nueva imagen, se le carga la que ya tenía
         * Si se edita devuelve true y si no devuelve false
         */

        $ins = $this->db->prepare("UPDATE peliculas SET categoria_id = :categoria_id, usuario_id = :usuario_id,  titulo = :titulo, 
        sinopsis = :sinopsis, director = :director, precio = :precio, stock = :stock, imagen = :imagen WHERE id = :id");

        $ins->bindParam( ':categoria_id', $categoria_id, PDO::PARAM_STR);
        $ins->bindParam( ':usuario_id', $usuario_id, PDO::PARAM_STR);
        $ins->bindParam( ':titulo', $titulo, PDO::PARAM_STR);
        $ins->bindParam( ':sinopsis', $sinopsis, PDO::PARAM_STR);
        $ins->bindParam( ':director', $director, PDO::PARAM_STR);
        $ins->bindParam( ':precio', $precio, PDO::PARAM_STR);
        $ins->bindParam( ':stock', $stock, PDO::PARAM_STR);
        $ins->bindParam( ':imagen', $imagen, PDO::PARAM_STR);
        $ins->bindParam( ':id', $id, PDO::PARAM_STR);

        $categoria_id = $datos['categoria_id'];
        $usuario_id = $_SESSION['identity']->id;
        $titulo = $datos['titulo'];
        $sinopsis = $datos['sinopsis'];
        $director = $datos['director'];
        $precio = $datos['precio'];
        $stock = $datos['stock'];
        $id = $id_pelicula;

        if($img['name'] == NULL) {
            //Devuelve la imagen de la pelicula según el id de ésta
            $im = $this->setImagenPelicula($id);
            $imagen = $im->imagen;

        }else{
            $imagen = $img['name'];   
        }


        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
            
        }

       return $result;
    }

    
    public function borrar($id_pelicula) {
        /**
         * Borra una pelicula según el id 
         * que se le pasa 
         * Si se ha borrado devuelve true y si no devuelve false
         */
        $sql = "DELETE FROM peliculas WHERE id = :id";
        $resul =  $this->db->prepare($sql);
        $resul->bindParam(':id', $id, PDO::PARAM_STR);

        $id = $id_pelicula;
        try{
            $resul->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
        }

       return $result;
    }
    
}