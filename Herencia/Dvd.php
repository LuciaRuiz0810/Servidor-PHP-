<?php
class Dvd extends soporte
{
    public $idiomas;
    private $formatPantalla;

    /*Constructor */
    public function __construct($titulo, $numero, $precio, $idiomas, $formatPantalla)
    {
        /*Definimos propiedades de la clase padre */
        parent::__construct($titulo, $numero, $precio);

     /*Definimos propiedades de la clase hija (Dvd) */
        $this -> idiomas = $idiomas;
        $this -> formatPantalla = $formatPantalla;
    }


    public function muestraResumen() {
        echo '<br> Película en DVD: ' .$this->titulo .'<br>'. $this -> getPrecio() .
         '€ (IVA no incluido)'.'<br> Idiomas: '. $this->idiomas .'<br> Formato Pantalla: '. $this->formatPantalla;
    }
}
?>