<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exepcion 1</title>
</head>
<body>

<?php
/*Función que lanzará la excepción si los valores no son números */
function comprobar_numeros($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new Exception("Los valores deben ser números!");
    }
   
}

/*Al enviar el formulario, comprueba que ambos sean números, si no lo son lanzará la excepción definida en comprobar_numeros() */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        comprobar_numeros($_POST['numero_uno'], $_POST['numero_dos']);
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!--Formulario donde el usuario introduce los valores-->
<form method="POST">
    <label>Primer número:</label>
    <input type="text" name="numero_uno">
    <label>Segundo número:</label>
    <input type="text" name="numero_dos">
    <input type="submit" value="Comprobar">
</form>

</body>
</html>


 