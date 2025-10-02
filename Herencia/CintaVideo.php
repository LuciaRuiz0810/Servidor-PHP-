
<?php
class CintaVideo extends soporte
{
    private $duracion;

  public function __construct($titulo, $numero, $precio, $duracion)
    {
        //Inicializamos las variables del padre titulo, numero y precio
        parent::__construct($titulo, $numero, $precio);
        
        //Inicializamos las que son propias de la clase hija
        $this->duracion = $duracion;
    }

    /*No se deben volver a crear __set y __get ni otras funciones que ya estén definidas en
    la clase padre ya que las clases hijas lo heredan */

    /*$this->getPrecio() accede a la clase Padre */
    public function muestraResumen()
    {
        echo '<br>Película en VHS: <br>' .  $this->titulo . '<br>' . $this->getPrecio() . "€ (IVA no incluido) <br> Duración: " . $this->duracion;
    }
}
?>

