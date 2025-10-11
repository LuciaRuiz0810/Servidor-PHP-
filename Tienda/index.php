<?php

//Crea la conexión con la base de datos
$conexion = new mysqli('localhost', 'root', '', 'tienda');
echo '<h3>Lista Productos</h3>';

//Recogemos la información indicada de la tabla productos 
$consulta = $conexion -> query('SELECT cod, nombre_corto from producto');
echo '<ul>';

echo '<form action="stock.php" method="post">';

//La información de productos la dividimos en filas con fetch_assoc() y las metemos dentro de una lista
while($fila = $consulta->fetch_assoc()){
    //Guardamos el codigo de los productos
    $cod = $fila['cod'];
    //Creamos un enlace en cada producto que nos llevará a stock.php
    //Usamos {$fila['nombre_corto']} entre llaves para que PHP lo interprete bien dentro de la cadena
    echo "<li><a href='stock.php?cod=$cod'>{$fila['nombre_corto']}</a></li>";
  
}
 echo '</ul>';
?>