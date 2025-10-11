<?php
//Crea la conexión con la base de datos
$conexion = new mysqli('localhost', 'root', '', 'tienda');

//Obtenemos el codigo de index.php
$codigo = trim($_GET['cod']);

//Preparamos la consulta (sirve para evitar que los valores se interpreten como SQL malicioso)
//Creamos la consulta que según el producto clicado, coja su id y saque su stock correspondiente.
$consulta = $conexion->prepare("SELECT tienda, producto, unidades from stock where producto= '$codigo'");
//Ejecutamos la consulta
$consulta->execute();
//Obtenemos el resultado
$resultado = $consulta->get_result();

echo '<ul>';

echo '<strong>Lista stock</strong>';

//Guardamos los resultados en un array para poder recorrerlo varias veces.
$stocks = $resultado->fetch_all(MYSQLI_ASSOC);

//Recorremos cada resultado y mostramos las tiendas y las unidades por tienda
foreach ($stocks as $stock) {
    echo '<li>Tienda ' . $stock['tienda'] . ': ' . $stock['unidades'] . ' unidades</li>';
}
echo '</ul>';

echo '<strong>Stock del producto en las tiendas:</strong>';

//Creamos el form para poder enviar el nuevo stock
echo '<form action="#" method="post">';

//Recorremos el array stocks para mostrar la tienda y las unidades en cada tienda dentro del input
foreach ($stocks as $stock) {

    //name="unidades['tienda']" --> crea la clave
    //value="'.$stock['unidades'] --> crea el valor
    //Juntos crean un array con clave-valor que posteriormente se puede recorrer

    /*Ej
    $_POST['unidades'] = [
    'tienda1' => '10',
    'tienda2' => '5',
    'tienda3' => '3'
];
    */
    echo '<li>
    <label for="' . $stock['producto'] . '">Tienda ' . $stock['tienda'] . '</label>:
    <input type="number" id="' . $stock['producto'] . '" name="unidades[' . $stock['tienda'] . ']" value="' . $stock['unidades'] . '"> unidades
</li>';
}

//Creamos el boton que actualice el stocks
echo '<br>';
echo "<input type='submit' value='Actualizar' name='actualizar'>";

//Cuando pulsemos 'actualizar': 
if(isset($_POST['actualizar'])){
     //Inicia transacción
        $conexion-> autocommit(false);
    //Este fragmento cambia las unidades de ese producto en la tienda que indiquemos
    try {
        //La consulta actualizará las unidades donde el producto y la tienda coincidan
       $actualizar = $conexion -> prepare('UPDATE stock SET unidades = ? WHERE producto = ? AND tienda=?');
    
       if(!$actualizar){
        throw new Exception('Error al preparar la consulta');
       };

       //$_POST['unidades'] es el array creado en el input anterior
       //$tienda es la clave del array (tienda1, tienda2...)
       //$unidadesActualizadas cantidades que el usuario escribió (el valor del array)
       foreach ($_POST['unidades'] as $tienda => $unidadesActualizadas) {

            if(!is_numeric($unidadesActualizadas)){
                throw new Exception('Valor inválido');
            }

            //Asignamos las unidades y el codigo asociado ahora que lo sabemos después del foreach
            $actualizar -> bind_param('iss',$unidadesActualizadas, $codigo,$tienda );

            if(!$actualizar->execute()){
                throw new Exception('Error al ejecutar la consulta');
            }
           
       }

        //Si todo funciona hacemos commit
         $conexion->commit();

         //Volvemos a mostrar el stock pero actualizado e informando de que se ha procesado correctamente
         $consulta_actualizada = $conexion -> prepare("SELECT tienda, producto, unidades FROM stock where producto='$codigo'");
         $consulta_actualizada -> execute();
         $resultado_actualizado = $consulta_actualizada -> get_result();

         //fetch_all(MYSQLI_ASSOC) Devuelve arrays asociativos (['campo' => valor])
         $stock_actualizado = $resultado_actualizado -> fetch_all(MYSQLI_ASSOC);

         //Recorremos el stock actualizado sacando el producto y las unidades de cada uno y la tienda correspondiente
         foreach ($stock_actualizado as $nuevo){
            echo '<ul><li>' . $nuevo['producto'] . ' Tienda ' .$nuevo['tienda'] .': ' . $nuevo['unidades'] . ' unidades</li>';
         }

         echo "<p style='color:green;'>Stock actualizado correctamente.</p>";
         
         //Cerramos la consulta
         $consulta_actualizada -> close();

    } catch (Exception $e) {
        //Si salta la excepción hará rollback en esa consulta
        $conexion -> rollback();
        //Mostramos el mensaje de error
         echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
//cerramos la consulta
$consulta->close();

?>