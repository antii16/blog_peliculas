<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Utils\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class Pedido{
    private string $id;
    private string $usuario_id;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private string $coste;
    private string $estado;
    private string $fecha;
    private string $hora;
    private BaseDatos $db;

    public function __construct(){
        $this->db = new BaseDatos();
        $this->errores = [];
    }


    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }


    public function getUsuario_id(): string{
        return $this->usuario_id;
    }

    public function setUsuario_id(string $usuario_id){
        $this->usuario_id = $usuario_id;
    }

    public function getProvincia(): string{
        return $this->provincia;
    }

    public function setProvincia(string $provincia){
        $this->provincia = $provincia;
    }

    public function getLocalidad(): string{
        return $this->localidad;
    }

    public function setLocalidad(string $localidad){
        $this->localidad = $localidad;
    }

    public function getDireccion(): string{
        return $this->direccion;
    }

    public function setDireccion(string $direccion){
        $this->direccion = $direccion;
    }

    public function getCoste(): string{
        return $this->coste;
    }

    public function setCoste(string $coste){
        $this->coste = $coste;
    }

    public function getEstado(): string{
        return $this->estado;
    }

    public function setEstado(string $estado){
        $this->estado = $estado;
    }
 


    public function setPedidoId(){
        /**
         * Selecciona el id pedido 
         * Se utliza para guardar el id en la linea de pedido
         * y para obtener el numero de pedido en la vista confirmado
         */
        $id_pedido = $this->db->query("SELECT id FROM pedidos ORDER BY id DESC;");
        return $id_pedido->fetch(PDO::FETCH_OBJ);
    }

    public function getAllPedidoId() {
        /**
         * Selecciona los datos de todos los pedidos de un determinado usuario
         * Se utiliza en la vista de mispedidos
         */
        $pedidos = $this->db->query("SELECT * FROM pedidos WHERE usuario_id={$_SESSION['identity']->id} ORDER BY id DESC;");
        return $pedidos;
    }

    public function validar($datos) {
        /**
         * Valida que los campos no estén vacíos
         */
        if(!$datos['provincia']) {
            $this->errores[] = "La provincia es obligatoria";
        }
        if(!$datos['localidad']) {
            $this->errores[] = "La localidad es obligatoria";
        }
        if(!$datos['direccion']) {
            $this->errores[] = "La direccion es obligatoria";
        }

        return $this->errores;
    }

    public function save($datos, $stats) {
         /**
         * Guarda los datos del pedido y de linea de pedido 
         * en una transferencia.
         * Por cada pelicula pedida, se realiza una linea de pedido
         */
        $this->db->beginTransaction();
        try{
            $ins = $this->db->prepare("INSERT INTO pedidos(usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, CURDATE(), CURTIME())");
        
            $ins->bindParam( ':usuario_id', $usuario_id, PDO::PARAM_STR);
            $ins->bindParam( ':provincia', $provincia, PDO::PARAM_STR);
            $ins->bindParam( ':localidad', $localidad, PDO::PARAM_STR);
            $ins->bindParam( ':direccion', $direccion, PDO::PARAM_STR);
            $ins->bindParam( ':coste', $coste, PDO::PARAM_STR);
            $ins->bindParam( ':estado', $estado, PDO::PARAM_STR);
            
    
            if(isset($_SESSION['identity'])) {
                $usuario_id= $_SESSION['identity']->id;
            }else{
                $usuario_id= NULL;
            }

            $provincia = $datos['provincia'];
            $localidad = $datos['localidad'];
            $direccion = $datos['direccion'];
            $coste = $stats['total']; 
            $estado = 'pendiente'; 

            $ins->execute();

            $ins = $this->db->prepare("INSERT INTO lineas_pedidos(pedido_id, pelicula_id, unidades) VALUES (:pedido_id, :pelicula_id, :unidades)");
            
            $ins->bindParam( ':pedido_id', $pedido_id, PDO::PARAM_STR);
            $ins->bindParam( ':pelicula_id', $pelicula_id, PDO::PARAM_STR);
            $ins->bindParam( ':unidades', $unidades, PDO::PARAM_STR);
            

            foreach($_SESSION['carrito'] as $pelicula) {
                $id = $this->setPedidoId();
                $pedido_id = $id->id;
                $pelicula_id = $pelicula['id_pelicula'];
                $unidades = $pelicula['unidades'];
                $this->modificarStock($pelicula_id, $unidades); 
                
                $ins->execute();
               
            }

            $this->db->commit();
            $result = true;
            return $result;

        }catch(PDOException $err){
            $this->db->rollback();
            $result= false;
            return $result;
        }
    }

    public function modificarStock($pelicula_id, $unidades) {
        /**
         * Modifica el stock una vez que se ha realizado el pedido y la linea del pedido
         * 
         */

        //Se realiza una consulta para obtener el stock de ese producto
        $sql = "SELECT stock FROM peliculas WHERE id = '$pelicula_id'";
        $resultado = $this->db->query($sql);
        $stockActual = $resultado->fetch(PDO::FETCH_ASSOC);
        //El stock final es el stock actual menos las unidades que han hecho en el pedido.
        //El control del stock si llega a cero se ha hecho en el controlador 
        $stockFinal = $stockActual['stock'] - $unidades;
       
        $ins = $this->db->prepare("UPDATE peliculas SET stock = :stock WHERE id = :id");

        $ins->bindParam( ':stock', $stock, PDO::PARAM_STR);
        $ins->bindParam( ':id', $id, PDO::PARAM_STR);

    
        $stock = $stockFinal;
        $id = $pelicula_id;

        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;

        }
        
  
    }


    
}