<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excepción 2</title>
</head>
<body>
    <?php

// Clase que extiende Exception
class Excepcion_dos extends Exception {
    public function mostrarMensaje() {
        return "Error: " . $this->getMessage();
    }
}

//Función que comprueba si los valores son númericos y lanzará la excepción si alguno de ellos no lo es
// o se intenta dividir por 0, si todo es correcto, devolverá el resultado de la división
function dividir($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new Excepcion_dos("Los valores deben ser números!");
    }
    if ($b == 0) {
        throw new Excepcion_dos("No se puede dividir entre cero!");
    }
    return $a / $b;
}

//Comprobar que los valores han sido introducido, si lo están, llama a la función dividir()
if (isset($_POST['numero_uno']) && isset($_POST['numero_dos'])) {
    try {
        echo dividir($_POST['numero_uno'], $_POST['numero_dos']);
    } catch (Excepcion_dos $e) {
        echo $e->mostrarMensaje();
    }
}

?>
<!--Formulario-->
<form method="POST">
    <label>Primer número:</label>
    <input type="text" name="numero_uno">
    <label>Segundo número:</label>
    <input type="text" name="numero_dos">
    <input type="submit" value="Comprobar">
</form>

</body>
</html>