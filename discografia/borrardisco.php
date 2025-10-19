<?php
$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');
$album_ref = trim($_GET['codigo']);


try {
    //modo de manejo de errores para la conexión a la base de datos
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Comienzo de transacción
    $conexion->beginTransaction();

    //Eliminamos las canciones del album
    $resultado_canciones = $conexion->prepare('DELETE FROM cancion where album = ?');
    $resultado_canciones->execute([$album_ref]);

    //Eliminamos el albúm 
    $resultado_album = $conexion->prepare('DELETE FROM album where codigo = ?');
    $resultado_album->execute([$album_ref]);

    //Fin de transacción
    $conexion->commit();
    //Redirige al index e indica que se ha borrado el disco
    header('Location: http://discografia.local/index.php?msg=Disco borrado correctamente');
    exit();

} catch (Exception $e) {
    //Si no se ha eliminado, se hará rollback y se informará
    $conexion->rollBack();
    header('Location: http://discografia.local/index.php?msgE=Error al eliminar el disco');
    exit();
}
