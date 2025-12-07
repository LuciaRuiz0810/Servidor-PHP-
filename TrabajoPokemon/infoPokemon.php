<?php
//REGIONES
$json_data_region = file_get_contents('https://pokeapi.co/api/v2/region/');
$json_decod = json_decode($json_data_region,true); //true lo convierte en array
//var_dump($json_decod);


//POKEMONS SEGÚN LA REGIÓN
if(isset($_GET['nombre'])){
$region_seleccionada = $_GET['nombre'];

$json_data_pok = file_get_contents('https://pokeapi.co/api/v2/pokedex/' . $region_seleccionada . '/');
$json_decod_pok = json_decode($json_data_pok,true); //true lo convierte en array
//var_dump($json_decod_pok);
}

//INFORMACION POKEMONS
$pokemon_seleccionado = $_GET['pokemon'];
$json_data_infopok = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $pokemon_seleccionado . '/');
$json_decod_infopok = json_decode($json_data_infopok,true); //true lo convierte en array
//var_dump($json_data_infopok);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>

<div></div>

<nav>
<strong>
<?php
$contador_regiones = 0;

//Imprime las regiones
foreach ($json_decod['results'] as $region) {
	$contador_regiones++;
    echo '<a href="pokemons.php?nombre=' . $region['name'] . '" style="text-decoration:none;">G' . $contador_regiones . ' ' . $region['name'] . '</a>';
	echo '&nbsp;&nbsp';
}

echo '<a href="busqueda.php" style="text-decoration:none;">Búsqueda</a>';
?>

</strong>
</nav>

<div id="iniciales" class="info-centro">

<h1>Pokemon <?php echo $pokemon_seleccionado?></h1>
<?php
//Imprime la imagen del pokemon
if (isset($json_decod_infopok['sprites']['front_default'])) {
    echo '<img src="' . $json_decod_infopok['sprites']['front_default'] . '" alt="imagen_pokemon">';

}

//Muestra Habilidades, Tipos y Peso
echo '<h2>Habilidades:</h2>';

foreach ($json_decod_infopok['abilities'] as $pokemon) {
    echo '<p>-'. $pokemon['ability']['name'] .'</p>';
}

echo '<h2>Tipos:</h2>';

foreach ($json_decod_infopok['types'] as $pokemon) {
    echo '<p>-'.$pokemon['type']['name'] .'</p>';
}


echo '<h2>Peso: ' . $json_decod_infopok['weight'] . ' kg</h2>';
?>

</div>


<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>