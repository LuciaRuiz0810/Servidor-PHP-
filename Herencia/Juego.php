<?php
class Juego extends Soporte
{
    public $consola;
    private $minNumJugadores;
    private $maxNumJugadores;

    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores)
    {
        parent::__construct($titulo, $numero, $precio);

        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    /*Si el máximo de jugadores es mayor que 1, indicará las cantidades */
    public function muestraJugadoresPosibles() {
        if($this->maxNumJugadores > 1){
            return 'Desde ' . $this->minNumJugadores . ' hasta ' .$this->maxNumJugadores . ' jugadores';
        }else{
            return 'Para un jugador';
        }

    }
    public function muestraResumen() {
         echo '<br>' . $this->titulo .'<br>'. $this -> getPrecio() .
         '€ (IVA no incluido)'.'<br>' . $this->muestraJugadoresPosibles();
    }
}
