<?php 

    include_once 'Soporte.php';
    include_once 'Resumible.php';

    class CintaVideo extends Soporte implements Resumible {
        public function __construct(
            string $titulo,
            float $precio,
            private int $duracion,
        )
        {
            parent::__construct($titulo, $precio);
        }

        public function muestraResumen(): void
        {
            echo "Película en VHS:" . PHP_EOL;
            echo $this->titulo .  PHP_EOL;
            echo "{$this->getPrecio()} € (IVA no incluido)" .  PHP_EOL; 
            echo "Duración: {$this->duracion} minutos" .  PHP_EOL;
        }
    }

?>