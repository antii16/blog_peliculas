<?php

namespace Lib;
use PDO;

class BaseDatos extends PDO {

    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;
    private string $tipo_de_base = 'mysql';

    function __construct(){
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];
    
    
    try{
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
        parent::__construct("{$this->tipo_de_base}:dbname={$this->base_datos};host={$this->servidor}", $this->usuario, $this->pass, $opciones);
        
        
    }catch(PDOException $e){
        echo "Ha surgido un error y no ser puede conectar a la base de datos. DETALLE: ". $e->getMessage();
        exit;
    }

    }
}

?>