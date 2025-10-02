<?php

class Soporte
{

    public $titulo;
    protected $numero;
    private $precio;
    const VAT = 21;

    /*Construtor clase padre */
    public function __construct($titulo, $numero, $precio)
    {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    /*Método mágico set */
    public function __set($propiedad, $valor)
    {
        $this->$propiedad  = $valor;
    }
    /*Método mágico get */
    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    /*self::propiedad para llamar a una constante  */
    public function getPrecioConIva()
    {
        return $this->precio + ($this->precio * self::VAT / 100);
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    /*$this->propiedad dentro de la clase / $objeto=>propiedad fuera de la clase */
    public function muestraResumen()
    {
        echo '<br>' .  $this->titulo . '<br>' . $this->getPrecio() . "€ (IVA no incluido)";
    }
}

