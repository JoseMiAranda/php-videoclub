<?php 

    include_once 'Soporte.php';
    include_once 'Resumible.php';

    class Juego extends Soporte implements Resumible {
        public function __construct(
            string $titulo,
            float $precio,
            public string $consola,
            private int $minNumJugadores,
            private int $maxNumJugadores,
        )
        {
            parent::__construct($titulo, $precio);
        }

        public function muestraJugadoresPosibles() : void {
            echo "Min jugadores: {$this->minNumJugadores} - Máx jugadores: {$this->maxNumJugadores}";
        }

        public function muestraResumen(): void {
            $esPluralMin = $this->minNumJugadores > 1;
            $esPluralMax = $this->maxNumJugadores > 1;
            echo "Juego para: {$this->consola}" . PHP_EOL;
            echo $this->titulo . PHP_EOL;
            echo $this->getPrecio() . " € (IVA no incluido)" . PHP_EOL;
            echo "Mínimo: {$this->minNumJugadores}" . " jugador" . ($esPluralMin ? 'es' : '') . PHP_EOL; 
            echo "Máximo {$this->maxNumJugadores}" . " jugador" . ($esPluralMax ? 'es' : '') .  PHP_EOL;
        }
    }

?>