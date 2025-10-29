<?php
session_start();

$conexion = new PDO('mysql:host=localhost;dbname=discografia', 'root', '');

if ($_SESSION['autenticado'] != true || !isset($_SESSION['autenticado'])) {
    header('Location: login.php');
    exit;
}
//Obtiene la busquedas enviadas, si no existen aún , serán ''
$busqueda_nueva = $_POST['texto_buscar'] ?? '';

//Si la cookie ya existe, 
if (isset($_COOKIE['busquedas_cookie'])) {
    $busquedas_cookie = explode(',', $_COOKIE['busquedas_cookie']);  //Crea un array donde se almacenarán las búsquedas

} else {
    $busquedas_cookie = array(); //Si no hay contenido, se crea el array a vacio
}

//Si la nueva búsqueda no está vacía, se añadirá al array de busquedas dentro de la cookie
//solo añadimos la búsqueda si no está ya en el array (!in_array)
if ($busqueda_nueva != '' && !in_array($busqueda_nueva, $busquedas_cookie)) {
    $busquedas_cookie[] = $busqueda_nueva;
    //Volvemos a convertir el array a una cadena
    //en las COOKIES solo se pueden guardar CADENAS
    setcookie('busquedas_cookie', implode(',', $busquedas_cookie), time() + 60, '/');
}

echo '<form method="post">';

echo '<h1>Búsqueda de canciones</h1>';
echo '<br><br>';

echo '<label>Texto a buscar:</label>';

echo '<input type="text" name="texto_buscar" value="" list="anteriores">';
echo '<br><br>';
echo  '<datalist id="anteriores">';
//Recorre el array para crear las opciones con antiguas búsquedas
foreach ($busquedas_cookie as $busqueda) {
    echo '<option value="' . htmlspecialchars($busqueda) . '">';
}

echo '</datalist>';
echo '<label>Buscar en:</label>';


//Buscar solo en títulos de canciones
//name="buscar_en" selecciona todos los radios
//Por defecto asigna 'cancion'
echo '<input type="radio" id="titulo" name="buscar_en" value="cancion" ' . (($_POST['buscar_en'] ?? 'cancion') == 'cancion' ? 'checked' : '') . '>';
echo '<label for="titulo">Títulos de canción</label>';

//buscar en nombres de álbum
echo '<input type="radio" id="album" name="buscar_en" value="album" ' . (($_POST['buscar_en'] ?? '') == 'album' ? 'checked' : '') . '>';
echo '<label for="album">Nombres de albúm</label>';

//buscar en ambos
echo '<input type="radio" id="ambos" name="buscar_en" value="ambos" ' . (($_POST['buscar_en'] ?? '') == 'ambos' ? 'checked' : '') . '>';
echo '<label for="ambos">Ambos</label>';
echo '<br><br>';

//Lista de géneros
echo '<label>Género musical:</label>';
echo '<select name="genero">'; //lo que elija el user se almacenará en género
echo '<option value="">-- Elige un género --</option>';
echo '<option value="Rock">Rock</option>';
echo '<option value="Pop">Pop</option>';
echo '<option value="Jazz">Jazz</option>';
echo '<option value="Clasica">Música clásica</option>';
echo '<option value="Electrónica">Electrónica</option>';
echo '<option value="Reggaeton">Reggaeton</option>';
echo '<option value="HipHop">Hip Hop</option>';
echo '<option value="Acustica">Acústica</option>';
echo '</select>';
echo '<br><br>';

//Botón para enviar el formulario
echo '<input type="submit" name="buscar" value="Buscar">';
echo '</form>';
$error = false; //Indica si hay error activo o no

//Si el user pulsa el botón buscar:
if (isset($_POST['buscar'])) {
    try {
        //Se obtiene el texto, donde quiere buscarlo y el genero
        $texto = trim($_POST['texto_buscar']);
        $donde = $_POST['buscar_en'] ?? 'cancion'; //Si no elige, se escoje el de por defecto (canciones)
        $genero = $_POST['genero'] ?? ''; //si no eligió género, se deja vacío

        //Si el campo de texto está vacío, salta la excepción
        if ($texto === '') {
            throw new Exception('No puedes buscar una cadena vacía!');
        }

        //buscar solo en títulos de canción
        if ($donde == 'cancion') {
            if ($genero !== '') {
                // Si eligió un género, busco canciones que tengan ese título Y ese género
                $stmt = $conexion->prepare("
                    SELECT c.titulo 
                    FROM cancion c 
                    WHERE c.titulo LIKE ? AND c.genero = ?
                ");
                $stmt->execute(["%$texto%", $genero]);
            } else {
                // Si no eligió género, solo busco por título
                $stmt = $conexion->prepare("SELECT c.titulo FROM cancion c WHERE c.titulo LIKE ?");
                $stmt->execute(["%$texto%"]);
            }

            //buscar en nombres de álbum (y muestra las canciones de esos álbumes)
        } elseif ($donde == 'album') {
            if ($genero !== '') {
                //junto las tablas 'cancion' y 'album' para buscar
                $stmt = $conexion->prepare("
                    SELECT c.titulo 
                    FROM cancion c 
                    JOIN album a ON c.album = a.codigo 
                    WHERE a.titulo LIKE ? AND c.genero = ?
                ");
                $stmt->execute(["%$texto%", $genero]);
            } else {
                $stmt = $conexion->prepare("
                    SELECT c.titulo 
                    FROM cancion c 
                    JOIN album a ON c.album = a.codigo 
                    WHERE a.titulo LIKE ?
                ");
                $stmt->execute(["%$texto%"]);
            }

            //buscar en títulos de canción Y en nombres de álbum
        } else {
            if ($genero !== '') {
                $stmt = $conexion->prepare("
                    SELECT c.titulo 
                    FROM cancion c 
                    JOIN album a ON c.album = a.codigo 
                    WHERE (c.titulo LIKE ? OR a.titulo LIKE ?) AND c.genero = ?
                ");
                $stmt->execute(["%$texto%", "%$texto%", $genero]);
            } else {
                $stmt = $conexion->prepare("
                    SELECT c.titulo 
                    FROM cancion c 
                    JOIN album a ON c.album = a.codigo 
                    WHERE c.titulo LIKE ? OR a.titulo LIKE ?
                ");
                $stmt->execute(["%$texto%", "%$texto%"]);
            }
        }

        //guardo todos los resultados en una variable
        $resultados = $stmt->fetchAll();
    } catch (Exception $e) {
        echo '<p style="color: red;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
        $error = true;
    }

    //Mostrar lista de canciones encontradas si no hay error y resultados contiene valores
    if (!$error) {
        if (!empty($resultados)) {
            echo '<h2>Canciones encontradas:</h2>';
            echo '<ul>';
            //recorre resultados (canciones)
            foreach ($resultados as $fila) {
                echo '<li>' . htmlspecialchars($fila['titulo']) . '</li>';
            }
            echo '</ul>';
        } else {
            //Si resultados está vacío, se informa de que no se ha encontrado ninguna canción
            echo '<p>No se encontraron canciones.</p>';
        }
    }
}
