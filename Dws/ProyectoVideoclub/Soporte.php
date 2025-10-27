<?php 
    namespace Dws\ProyectoVideoclub;

    include_once 'Resumible.php';

    abstract class Soporte implements Resumible {

        private const IVA = 21;
        private static int $contador = 0;
        protected int $numero;

        public function __construct(
            public string $titulo,
            private float $precio,
        )
        {
            $this->numero = self::$contador++;
        }

        public function getPrecio(): float {
            return $this->precio;
        }

        public function getPrecioConIva(): float {
            return $this->precio * self::IVA;
        }

        public function getNumero(): int {
            return $this->numero;
        }

        function muestraResumen(): void {
            
        }
    }
?>