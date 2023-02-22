<?php
session_start();

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Lib\Router;
use Controllers\UsuarioController;
use Controllers\CategoriaController;
use Controllers\PedidoController;
use Controllers\PeliculaController;
use Controllers\CarritoController;
use Lib\Pages;

$pages = new Pages();
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$pages->render('index');

// INDEX

Router::add('GET', '/', function(){
    return (new PeliculaController())->index();
    
});


//USUARIOS
Router::add('GET', 'usuario/registro', function(){
    return (new UsuarioController())->registro();
    
});
Router::add('POST', 'usuario/registro', function(){
    return (new UsuarioController())->registro();
    
});

Router::add('GET', 'usuario/login', function(){
    return (new UsuarioController())->login();
    
});
Router::add('POST', 'usuario/login', function(){
    return (new UsuarioController())->login();
    
});
Router::add('GET', 'usuario/logout', function(){
    return (new UsuarioController())->logout();
    
});

Router::add('GET', 'usuario/editar/:id', function(){
    return (new UsuarioController())->editar();
    
});

//PELICULAS
Router::add('GET', 'pelicula/gestion', function(){
    return (new PeliculaController())->gestion();
    
});

Router::add('POST', 'pelicula/crear', function(){
    return (new PeliculaController())->save();
    
});

Router::add('GET', 'pelicula/crear', function(){
    return (new PeliculaController())->save();
    
});

Router::add('GET', 'pelicula/delete/:id', function($id){
    return (new PeliculaController())->delete($id);
    
});

Router::add('GET', 'pelicula/ver/:id', function($id){
    return (new PeliculaController())->ver($id);
    
});

Router::add('GET', 'pelicula/editar/:id', function($id){
    return (new PeliculaController())->editar($id);
    
});

Router::add('POST', 'pelicula/editar/:id', function($id){
    return (new PeliculaController())->saveEdit($id);
    
});

//CATEGORIAS

Router::add('GET', 'categoria/gestion', function(){
    return (new CategoriaController())->gestion();
    
});

Router::add('GET', 'categoria/save', function(){
    return (new CategoriaController())->save();
    
});

Router::add('POST', 'categoria/save', function(){
    return (new CategoriaController())->save();
    
});

Router::add('GET', "categoria/borrar/:id", function($id){
    return (new CategoriaController())->borrar($id);
    
});


Router::add('GET', "categoria/ver/:id", function($id){
    return (new CategoriaController())->ver($id);
    
});

Router::add('GET', "categoria/editar/:id", function($id){
    return (new CategoriaController())->editar($id);
    
});

Router::add('POST', "categoria/editar/:id", function($id){
    return (new CategoriaController())->saveEdit($id);
    
});

//CARRITO
Router::add('GET', 'carrito/add/:id', function($id){
    return (new CarritoController())->add($id);
    
});

Router::add('GET', 'carrito/index', function(){
    return (new CarritoController())->index();
    
});

Router::add('GET', 'carrito/down/:id', function($id){
    return (new CarritoController())->down($id);
    
});
Router::add('GET', 'carrito/up/:id', function($id){
    return (new CarritoController())->up($id);
    
});

Router::add('GET', 'carrito/delete_all', function(){
    return (new CarritoController())->delete_all();
    
});

Router::add('GET', 'carrito/delete/:id', function($id){
    return (new CarritoController())->delete($id);
    
});

//PEDIDOS
Router::add('GET', 'pedido/hacer', function(){
    return (new PedidoController())->hacer();
    
});

Router::add('POST', 'pedido/save', function(){
    return (new PedidoController())->save();
    
});

Router::add('GET', 'pedido/mispedidos', function(){
    return (new PedidoController())->mis_pedidos();
    
});

Router::dispatch();
