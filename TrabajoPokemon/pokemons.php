<?php
//REGIONES
$json_data_region = file_get_contents('https://pokeapi.co/api/v2/region/');
$json_decod = json_decode($json_data_region, true); //true lo convierte en array
//var_dump($json_decod);

$region_seleccionada = $_GET['nombre'];

switch ($region_seleccionada) {
	case 'kanto':
		$resultado = listado_pokemons('kanto');
		break;
	case 'johto':
		$resultado = listado_pokemons('updated-johto');
		break;
	case 'hoenn':
		$resultado = listado_pokemons('updated-hoenn');
		break;
	case 'sinnoh':
		$resultado = listado_pokemons('extended-sinnoh');
		break;
	case 'unova':
		$resultado = listado_pokemons('updated-unova');
		break;
	case 'alola':
		$resultado = listado_pokemons('updated-alola');
		break;
	//FALTA KALOS
	case 'kalos':
		//Se recorre el array y se sacan los pokemos de cada uno
		$pokedexes = ['kalos-central', 'kalos-coastal', 'kalos-mountain'];
		break;
	case 'galar':
		$resultado = listado_pokemons('galar');
		break;
	case 'hisui':
		$resultado = listado_pokemons('hisui');
		break;
	case 'paldea':
		$resultado = listado_pokemons('paldea');
		break;
	default:
		break;
}

function listado_pokemons($busqueda)
{
	//POKEMONS
	$json_data_pok = file_get_contents('https://pokeapi.co/api/v2/pokedex/' . $busqueda . '/');
	$json_decod_pok = json_decode($json_data_pok, true); //true lo convierte en array
	return $json_decod_pok;
	//var_dump($json_decod);
}


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

	<div id="iniciales" class="grid-pokemon">

		<h3>Pokemons en <?php echo $_GET['nombre'] ?></h3>
		<?php
		$contador_pokemons = 0;

		//Si el usuario quiere ver 'kalos', $pokedexes contendrá valores, si pulsa otra región hará el else
		if (isset($pokedexes)) {
			foreach ($pokedexes as $pokemons_kalos) {
				$resultado = listado_pokemons($pokemons_kalos);

				//Imprime los pokemons de esa región (enumerados)
				foreach ($resultado['pokemon_entries'] as $pokemon) {
					$contador_pokemons++;
					echo '<div><strong>' . $contador_pokemons . '</strong>.<a href=infoPokemon.php?pokemon=' . $pokemon['pokemon_species']['name'] . '>' . $pokemon['pokemon_species']['name'] . '</a></div>';
				
				}
			}
		} else {
			//Imprime los pokemons de esa región (enumerados)
			foreach ($resultado['pokemon_entries'] as $pokemon) {
				$contador_pokemons++;
				echo '<div><strong>' . $contador_pokemons . '</strong>.<a href=infoPokemon.php?pokemon=' . $pokemon['pokemon_species']['name'] . '>' . $pokemon['pokemon_species']['name'] . '</a></div>';
			
			}
		}
		?>
	</div>

	<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>

</html>