<?php

use Models\Pelicula;

if(!empty($pedidos)){
?>
<table  class="table table-dark">
    <tr>
        <th style="text-align: center;">Identificador</th>
        <th style="text-align: center;">Provincia</th>
        <th style="text-align: center;">Dirección</th>
        <th style="text-align: center;">Coste</th>
        <th style="text-align: center;">Estado</th>
        <th style="text-align: center;">Fecha</th>
    </tr>

    <?php while($ped = $pedidos->fetch(PDO::FETCH_OBJ)):?>
        <tr>
            <td style="text-align: center;"><?=$ped->id;?></td>
            <td style="text-align: center;"><?=$ped->provincia;?></td>
            <td style="text-align: center;"><?=$ped->direccion;?></td>
            <td style="text-align: center;"><?=$ped->coste;?></td>
            <td style="text-align: center;"><?=$ped->estado;?></td>
            <td style="text-align: center;"><?=$ped->fecha;?></td>
    
        </tr>
     <?php endwhile?>
</table>

<?php

}
elseif(empty($pedidos->fetch(PDO::FETCH_OBJ))){
    echo "No ha hecho ningún pedido";
}
        

