<?php

namespace Lib;

class Pages {
    public function render(string $pageName, array $params = null):void {
       /* $pageName es el nombre de nuestra plantilla, por ejmeplo, mostrar_todos. NO
       la extension $params es el contenedor de ls variables que deseamos pasar a la vista
       $params es un array con un indice asociativo 
       Para crear las variables , recorremos la lista y usamos el indice
       como nombre de variable usanfo la propiedad variables de PHP ($$name = $value;)*/
        if($params != null) {
            foreach($params as $name => $value) {
                $$name = $value;
            }
        }

        require_once '../views/layout/header.php';
        require_once '../views/'.$pageName.'.php';
        require_once '../views/layout/footer.php';
    }
}