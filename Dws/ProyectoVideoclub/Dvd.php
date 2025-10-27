<?php 
    namespace Dws\ProyectoVideoclub;

    include_once 'Soporte.php';
    include_once 'Resumible.php';

    class Dvd extends Soporte implements Resumible {
        public function __construct(
            string $titulo,
            float $precio,
            public string $idiomas,
            private string $formato,
        )
        {
            parent::__construct($titulo, $precio);
        }

        public function muestraResumen(): void
        {
            echo "Película en DVD:" . PHP_EOL;
            echo $this->titulo . PHP_EOL;
            echo "{$this->getPrecio()} € (IVA no incluido)" . PHP_EOL;
            echo "Idiomas:{$this->idiomas}" . PHP_EOL;
            echo "Formato Pantalla:{$this->formato}" .  PHP_EOL;
        }
    }

?>