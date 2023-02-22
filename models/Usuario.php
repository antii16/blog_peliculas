<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
use PDOException;


class Usuario{
    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;

    private BaseDatos $db;

    public function __construct(string $id, string $nombre,string $apellidos,string $email, string $password, string $rol)
    {
        $this->db = new BaseDatos();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
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

    public function getApellidos(): string{
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos){
        $this->apellidos = $apellidos;
    }


    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }


    public function getPassword(): string{
        return $this->password;
    }

    public function setPassword(string $password){
        $this->password = $password;
    }

    public function getRol(): string{
        return $this->rol;
    }

    public function setRol(string $rol){
        $this->rol = $rol;
    }


    public static function fromArray(array $data): Usuario {
        return new Usuario(
            $data['id'] ?? '',
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['rol'] ?? '',

        );
    }

    public function save():bool{
        /**
         * Guarda los datos del nuevo usuario
         * Si es correcto devuelve true y si no devuelve false
         */
        $ins = $this->db->prepare("INSERT INTO usuarios(id, nombre, apellidos, email, password, rol) VALUES (:id, :nombre, :apellidos, :email, :password, :rol)");
        $ins->bindParam( ':id', $id);
        $ins->bindParam( ':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam( ':apellidos', $apellidos, PDO::PARAM_STR);
        $ins->bindParam( ':email', $email, PDO::PARAM_STR);
        $ins->bindParam( ':password', $password, PDO::PARAM_STR);
        $ins->bindParam( ':rol', $rol, PDO::PARAM_STR);
       
        $id= NULL;
        $nombre= $this->getNombre();
        $apellidos= $this->getApellidos();
        $email= $this->getEmail();
        $password= $this->getPassword();
        $rol = 'user';
        
        try{
            $ins->execute();
            $result = true;
        }catch(PDOException $err){
            $result= false;
        }

       return $result;
    }


    public function edit($id_usuario, $pass, $correo):bool{
        /**
         * Edita los datos del usuario. 
         * Para ello debe buscar si el email que cambia no está ya registrado
         * Si lo está no permite cambiarlo, si no si permite
         */

        $ins = $this->db->prepare("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, 
        password = :password WHERE id = :id ");
        
        $ins->bindParam( ':nombre', $nombre, PDO::PARAM_STR);
        $ins->bindParam( ':apellidos', $apellidos, PDO::PARAM_STR);
        $ins->bindParam( ':email', $email, PDO::PARAM_STR);
        $ins->bindParam( ':password', $password, PDO::PARAM_STR);
        $ins->bindParam( ':id', $id, PDO::PARAM_INT);
    

        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $password =  $pass;
        $id = $id_usuario;

        $usuario = $this->buscaMailEdit($correo);
        //Si el id donde está ese correo es el id del usuario logueado, 
        //permite la modificación
        if($usuario->id == $id) { 
            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result= false;
            }

        }else{
            $result = false;
        }
    
       return $result;
    }


    public function login():bool|object{
        /**
         * Realiza el login del usuario, verificando si al contraseña es la 
         * del usuario
         * Devuelve los datos del usuario si se ha verificado, sino devuelve false
         */
        $result = false;
        $email= $this->email;
        $password = $this->password;
        $usuario = $this->buscaMail($email);
     
        if($usuario !== false) { 
            $verify = password_verify($password, $usuario->password);
            if($verify) {
                $result= $usuario;
            }
        }
        return $result;
    }

    public function buscaMail($email):bool|object {
        /**
         * Busca el mail del usuario con el objetivo 
         * de verificar si ese email coincide con la contraseña del usuario
         */
        $result = false;
        $cons = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $cons->bindParam(':email', $email, PDO::PARAM_STR);
        try{
            $cons->execute();
            if($cons && $cons->rowCount() ==1) {
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err) {
            $result = false;
        }
        return $result;
    }
    

    public function buscaMailEdit($email):bool|object {
        /**
         * Devuelve el id del usuario según su email 
         * con el objetivo de editar correctamente 
         * el email del usuario
         */
        $result = false;
        $cons = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email");
        $cons->bindParam(':email', $email, PDO::PARAM_STR);
        try{
            $cons->execute();
            if($cons && $cons->rowCount() ==1) {
                $result = $cons->fetch(PDO::FETCH_OBJ);
            }
        }catch(PDOException $err) {
            $result = false;
        }
        return $result;
    }


    public function validar_y_sanitizarRegistro($password) {
        /**
         * Validacion del registro del nombre, apellido, contraseña y del correo 
         * Nombre y apellido--> empezar por mayuscula y el resto en minuscula
         **/
        if(!$this->nombre) {
            $this->errores[] = "El nombre del usuario es obligatorio";
        }

        if((!preg_match('/^[A-ZÁÉÍÓÚ][a-zñáéíóú]+(?: [A-ZÁÉÍÓÚ][a-zñáéíóú]+)?$/', $this->nombre)) ) {
            $this->errores[] = "Nombre no válido";
        }

        if(!$this->apellidos) {
            $this->errores[] = "El apellido del usuario es obligatorio";
        }

        if((!preg_match('/^[A-ZÁÉÍÓÚ][a-zñáéíóú]+(?: [A-ZÁÉÍÓÚ][a-zñáéíóú]+)?$/', $this->apellidos)) ) {
            $this->errores[] = "Apellido no válido";
        }


        if(!$this->email) {
            $this->errores[] = "El email del usuario es obligatorio";
        }else{
            $correo = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $this->errores[] = 'El campo email no es correcto';
            }
        }

        if(!$password) {
            $this->errores[] = "La contraseña del usuario es obligatoria";
        }

        return  $this->errores;
    }


    public function validar_y_sanitizarLogin() {
        /**
         * Validacion del login, comprobando que los campos estén
         * correctos
         */
        if(!$this->email) {
            $this->errores[] = "El email del usuario es obligatorio";
        }else{
            $correo = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $this->errores[] = 'El campo email no es correcto';
            }
        }

        if(!$this->password) {
            $this->errores[] = "Contraseña incorrecta";
        }

        return  $this->errores;
    }
}