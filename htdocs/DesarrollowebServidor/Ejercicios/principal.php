<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
</head>

<body>
    <?php include('cabecera.inc.php'); ?>

    <p>Actualmente estoy estudiando el segundo año de <span>DAW</span> en IES Serra Perenxisa, tengo 19 años y me
        gustaría seguir estudiando desarrollo
        web. Es un ámbito que siempre me ha parecido interesante y quiero seguir formandome en él.</p>
    <br>
    <!--Imagen-->
    <img src="Foto.jpg" alt="Foto_gato" height="240px" width="180px">
    <br>
    <!--Formulario-->
    <form action="consulta.php" method="get"> 
        <fieldset>
            <legend>Formulario usuarios</legend>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha">
            <br><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <br><br>

            <label for="Apellidos">Apellidos:</label>
            <input type="text" id="Apellidos" name="Apellidos" required>
            <br><br>

            <label for="tlf">Teléfono:</label>
            <input type="text" id="tlf" name="tlf" required>
            <br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <br><br>

            <input type="checkbox" name="actualizaciones" id="actualizaciones" value="sí">
            <label for="actualizaciones">Me gustaría recibir actualizaciones por email</label>
            <br><br>

            <label for="Consulta">Consulta:</label><br>
            <textarea name="Consulta" id="Consulta" rows="7"></textarea>
            <br><br>

            <input type="submit" value="Enviar">
        </fieldset>
    </form>
    <p>Ir a <a href="rrss.php">rrss</a></p>
    <p>Ir a <a href="tecnologias.php">tecnologias</a></p>
    <p>Ir a <a href="count.php">Count</a></p>
    <p>Ir a <a href="server.php">Server</a></p>
    <p>Ir a <a href="consulta.php">Consulta</a></p>
     <p>Ir a <a href="registro.php">Registro</a></p>

</body>


<?php include('footer.inc.php'); ?>


</html>