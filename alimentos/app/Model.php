<?php
class Model
{
	protected $conexion;

	public function __construct($dbname, $dbuser, $dbpass, $dbhost)
	{

		$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		try {
			$this->conexion  = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, $opc);
		} catch (PDOException $e) {
			die('No ha sido posible realizar la conexion con la base de datos: ' . $e->getMessage());
		}
	}

	private function dameAlimentosDB($sql)
	{
		$result = $this->conexion->query($sql);

		$alimentos = array();

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$alimentos[] = $row;
		}

		return $alimentos;
	}

	public function dameAlimentos()
	{
		$sql = 'SELECT * FROM alimentos ORDER BY energia DESC;';
		return $this->dameAlimentosDB($sql);
	}

	public function buscarAlimentosPorNombre($nombre)
	{
		$nombre = htmlspecialchars($nombre);
		$sql = 'SELECT * FROM alimentos WHERE nombre LIKE "' . $nombre . '" ORDER BY energia DESC;';

		return $this->dameAlimentosDB($sql);
	}

	public function dameAlimento($id)
	{
		$id = htmlspecialchars($id);
		$sql = 'SELECT * FROM alimentos WHERE id=' . $id . ';';

		return $this->dameAlimentosDB($sql)[0];
	}

	public function insertarAlimento($n, $e, $p, $hc, $f, $g)
	{
		$n = htmlspecialchars($n);
		$e = htmlspecialchars($e);
		$p = htmlspecialchars($p);
		$hc = htmlspecialchars($hc);
		$f = htmlspecialchars($f);
		$g = htmlspecialchars($g);

		$sql = 'INSERT INTO alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal) VALUES ("' . $n . '",' . $e . ',' . $p . ',' . $hc . ',' . $f . ',' . $g . ');';

		$result = $this->conexion->query($sql);
		return $result;
	}

	public function validarDatos($n, $e, $p, $hc, $f, $g)
	{
		return (is_string($n) & is_numeric($e) & is_numeric($p) & is_numeric($hc) & is_numeric($f) & is_numeric($g));
	}


//Función para buscar los alimentos según la energía máxima y mínima
public function buscarAlimentosPorEnergia($min = '', $max = '')
{
    $min = htmlspecialchars($min);
    $max = htmlspecialchars($max);
    
    //Si los campos están vacios, mostrará todos los alimentos
    if (empty($min) && empty($max)) {
        $sql = 'SELECT * FROM alimentos ORDER BY energia DESC';
    }
    //Si solo tiene mínimo
    elseif (!empty($min) && is_numeric($min) && empty($max)) {
        $sql = 'SELECT * FROM alimentos WHERE energia >= ' . (float)$min . ' ORDER BY energia DESC';
    }
    //Si solo tiene máximo
    elseif (empty($min) && !empty($max) && is_numeric($max)) {
        $sql = 'SELECT * FROM alimentos WHERE energia <= ' . (float)$max . ' ORDER BY energia DESC';
    }
    //Si tiene ambos campos rellenados
    elseif (!empty($min) && is_numeric($min) && !empty($max) && is_numeric($max)) {
    $sql = 'SELECT * FROM alimentos WHERE energia BETWEEN ' . (float)$min . ' AND ' . (float)$max . ' ORDER BY energia DESC';
}

    //se ejecuta la sql correspondiente
    return $this->dameAlimentosDB($sql);
}

//Función para buscar los alimentos según los campos rellenados
public function buscarAlimentosCombinados($nombre, $energia_min, $energia_max, $proteina_min)
{
    $nombre = htmlspecialchars($nombre);
    $energia_min = htmlspecialchars($energia_min);
    $energia_max = htmlspecialchars($energia_max);
    $proteina_min = htmlspecialchars($proteina_min);
    
    $sql = 'SELECT * FROM alimentos WHERE 1=1';
    

    if (!empty($nombre)) {
        $sql .= ' AND nombre LIKE "%' . $nombre . '%"';
    }
    
    if (!empty($energia_min) && is_numeric($energia_min)) {
        $sql .= ' AND energia >= ' . (float)$energia_min;
    }
    
    if (!empty($energia_max) && is_numeric($energia_max)) {
        $sql .= ' AND energia <= ' . (float)$energia_max;
    }
    
    if (!empty($proteina_min) && is_numeric($proteina_min)) {
        $sql .= ' AND proteina >= ' . (float)$proteina_min;
    }
    
    $sql .= ' ORDER BY energia DESC';
    
    return $this->dameAlimentosDB($sql);
}
}
