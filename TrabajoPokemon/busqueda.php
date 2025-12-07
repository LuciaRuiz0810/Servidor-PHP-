<?php

// Obtiene la lista de todas las regiones disponibles de Pokémon
$json_data_region = file_get_contents('https://pokeapi.co/api/v2/region/');
$json_decod = json_decode($json_data_region, true);

// Obtiene la lista de todos los tipos de Pokémon (fuego, agua, planta, etc.)
$json_data_tipos = file_get_contents('https://pokeapi.co/api/v2/type/');
$json_decod_tipos = json_decode($json_data_tipos, true);

// Variable para almacenar los resultados de la búsqueda
$resultados = [];
// Variable para almacenar mensajes de error
$error = '';



//Verifica si el usuario envió el formulario de búsqueda
if (isset($_POST['envio'])) {

    //Limpiar y validar los datos recibidos del formulario
    $nombre = trim($_POST['name']); 
    $region = isset($_POST['Region']) ? $_POST['Region'] : '';
    $tipo = isset($_POST['tipos']) ? $_POST['tipos'] : '';

    //Convertir valores vacíos a cadenas vacías
    $nombre = ($nombre !== "") ? $nombre : '';

    //Si solo se busca por nombre
    if ($nombre !== '' && $region === '' && $tipo === '') {
        
        $pokemon_data = obtener_pokemon_por_nombre($nombre);
        if ($pokemon_data !== null) {
            $resultados[] = $pokemon_data;
        } else {
            $error = "No se encontró el Pokémon: $nombre";
        }
    }
    //Si se busca con región (puede incluir tipo y/o nombre)
    elseif ($region !== '') {
        //Primero obtener todos los pokémon de la región
        $resultados = buscar_por_region($region);

        //Si además se especificó un tipo, filtrar por tipo
        if ($tipo !== '') {
            $resultados = filtrar_por_tipo_en_lista($resultados, $tipo);
        }

        //Si además se especificó un nombre, filtrar por nombre
        if ($nombre !== '') {
            $resultados = filtrar_por_nombre($resultados, $nombre);
        }
    }
    //Si se busca por tipo (sin región, puede incluir nombre)
    elseif ($tipo !== '') {
        // Obtener todos los pokémon de ese tipo
        $resultados = buscar_por_tipo($tipo);

        //Si además se especificó un nombre, filtrar por nombre
        if ($nombre !== '') {
            $resultados = filtrar_por_nombre($resultados, $nombre);
        }
    }
    //Si no se especificó ningún filtro se infroma al usuario
    else {
        $error = "Debes especificar al menos un criterio de búsqueda.";
    }
}


//Busca todos los pokémon de una región específica
function buscar_por_region($region) {
   
    $pokedex_map = [
        'kanto' => 'kanto',
        'johto' => 'updated-johto',
        'hoenn' => 'updated-hoenn',
        'sinnoh' => 'extended-sinnoh',
        'unova' => 'updated-unova',
        'kalos' => ['kalos-central', 'kalos-coastal', 'kalos-mountain'], 
        'alola' => 'updated-alola',
        'galar' => 'galar',
        'hisui' => 'hisui',
        'paldea' => 'paldea'
    ];

    //Obtener el nombre del pokédex correspondiente a la región
    $pokedex = $pokedex_map[$region];
    $todos_pokemons = [];

    //Verificar si la región tiene varios pokédex (si es un array o no)
    if (is_array($pokedex)) {
        //Recorrer cada pokédex de la región
        foreach ($pokedex as $nombre_pokedex) {
            //Obtener la lista de pokémon del pokédex
            $json_data = file_get_contents('https://pokeapi.co/api/v2/pokedex/' . $nombre_pokedex . '/');
            $data = json_decode($json_data, true);

            // ecorrer cada pokémon y obtener sus datos completos
            foreach ($data['pokemon_entries'] as $entry) {
                $todos_pokemons[] = obtener_pokemon($entry['pokemon_species']['name']);
            }
        }
    } else {
        //Si solo hay un pokédex, obtener directamente
        $json_data = file_get_contents('https://pokeapi.co/api/v2/pokedex/' . $pokedex . '/');
        $data = json_decode($json_data, true);

        //Recorrer cada pokémon y obtener sus datos completos
        foreach ($data['pokemon_entries'] as $entry) {
            $todos_pokemons[] = obtener_pokemon($entry['pokemon_species']['name']);
        }
    }

    return $todos_pokemons;
}

//Busca todos los pokémon según el tipo
function buscar_por_tipo($tipo) {

    $json_data = file_get_contents('https://pokeapi.co/api/v2/type/' . $tipo . '/');
    $data = json_decode($json_data, true);
    $pokemons = [];

    foreach ($data['pokemon'] as $pok) {
        $pokemons[] = obtener_pokemon($pok['pokemon']['name']);
    }

    return $pokemons;
}

//Obtiene los datos completos según el nombre buscaod
function obtener_pokemon($nombre) {
   
    $json_data = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $nombre . '/');
    return json_decode($json_data, true);
}

// usca un pokémon por nombre 
function obtener_pokemon_por_nombre($nombre) {
    //Convertir a minúsculas 
    $json_data = @file_get_contents('https://pokeapi.co/api/v2/pokemon/' . strtolower($nombre) . '/');

    //Si la petición falló, retornar null
    if ($json_data === false) {
        return null;
    }

    return json_decode($json_data, true);
}


//Busca si el nombre está contenido en el nombre del pokémon
function filtrar_por_nombre($lista, $nombre) {
    $resultado = [];

    //Recorrer cada pokémon de la lista
    foreach ($lista as $pokemon) {

        //Si encuentra el texto, devuelve la posición; si no, devuelve false (ignora mayúsculas/minúsculas)
        if (stripos($pokemon['name'], strtolower($nombre)) !== false) {
            $resultado[] = $pokemon;
        }
    }

    return $resultado;
}

//Filtra una lista de pokémon para quedarse solo con los de un tipo específico
function filtrar_por_tipo_en_lista($lista, $tipo) {
    $resultado = [];

    //Recorrer cada pokémon de la lista
    foreach ($lista as $pokemon) {
        //Recorrer los tipos del pokémon 
        foreach ($pokemon['types'] as $tipo_pokemon) {
            //Si el pokémon tiene el tipo buscado, agregarlo al resultado
            if ($tipo_pokemon['type']['name'] === $tipo) {
                $resultado[] = $pokemon;
                break; 
            }
        }
    }

    return $resultado;
}


function mostrar_resultados($resultados) {
    //Si no hay resultados, mostrar mensaje
    if (empty($resultados)) {
        echo "<p class='mensaje-no-resultados'>No se encontraron Pokémon con esos criterios.</p>";
        return;
    }

    //Mostrar título con cantidad de resultados encontrados
    echo "<h2 class='resultados-titulo'>Resultados: " . count($resultados) . " Pokémon encontrado";
    //Agregar 's' si hay más de 1
    if (count($resultados) > 1) {
        echo "s";
    }
    echo "</h2>";

    //Contenedor de resultados
    echo "<div class='resultados-grid'>";

    //Recorrer cada pokémon y crear una tarjeta
    foreach ($resultados as $pokemon) {
        echo "<div class='pokemon-card'>";

        //Imagen del pokémon
        echo "<img src='" . $pokemon['sprites']['front_default'] . "' alt='" . $pokemon['name'] . "'>";

        //Nombre del pokémon (primera letra en mayúscula)
        echo "<h3>" . ucfirst($pokemon['name']) . "</h3>";

        //Mostrar los tipos del pokémon
        echo "<p><strong>Tipos:</strong> ";
        $tipos = [];
        foreach ($pokemon['types'] as $tipo) {
            $tipos[] = ucfirst($tipo['type']['name']);
        }
        echo implode(", ", $tipos); //implode une los tipos con comas
        echo "</p>";

        //Enlace para ver más detalles
        echo "<a href='infoPokemon.php?pokemon=" . $pokemon['name'] . "'>Ver detalles</a>";

        echo "</div>";
    }

    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon - Búsqueda</title>
    <link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>


<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>


<nav>
    <strong>
        <?php

        $contador_regiones = 0;

        foreach ($json_decod['results'] as $region) {
            $contador_regiones++;

            echo '<a href="pokemons.php?nombre=' . $region['name'] . '">G' . $contador_regiones . ' ' . $region['name'] . '</a>';
            echo '&nbsp;&nbsp;';
        }
        echo '<a href="busqueda.php">Búsqueda</a>';
        ?>
    </strong>
</nav>

<div id="iniciales" class="busqueda-layout">

    <div class="contenedor-formulario">
        <form action="#" method="post">
            <h1 class="busqueda-titulo">Búsqueda de Pokémon</h1>
            <p class="busqueda-descripcion">Puedes usar 1, 2 o 3 filtros simultáneamente</p>


            <label for="name"><strong>Nombre:</strong></label>
            <input type="text" name="name" id="name" placeholder="Indica el nombre" class="busqueda-input">
            <br><br>

            <label for="Region"><strong>Región:</strong></label>
            <select name="Region" id="Region" class="busqueda-select">
                <option value="">Todas</option>
                <?php

                foreach ($json_decod['results'] as $region) {
                    echo "<option value='" . $region['name'] . "'>" . ucfirst($region['name']) . "</option>";
                }
                ?>
            </select>
            <br><br>

            <label for="tipos"><strong>Tipo:</strong></label>
            <select name="tipos" id="tipos" class="busqueda-select">
                <option value="">Todos</option>
                <?php

                foreach ($json_decod_tipos['results'] as $tipo) {
                    echo "<option value='" . $tipo['name'] . "'>" . ucfirst($tipo['name']) . "</option>";
                }
                ?>
            </select>
            <br><br>

            <div class="busqueda-boton-container">
                <input type="submit" value="Buscar" name="envio" class="busqueda-boton">
            </div>
        </form>
    </div>

    <div class="contenedor-resultados">
        <?php
        //Si se envió el formulario, mostrar resultados
        if (isset($_POST['envio'])) {
            //Si hubo un error, mostrarlo
            if ($error !== '') {
                echo "<p class='mensaje-error'><strong>" . $error . "</strong></p>";
            }
            //Si no hay error, mostrar los resultados
            else {
                mostrar_resultados($resultados);
            }
        }
        ?>
    </div>
</div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>