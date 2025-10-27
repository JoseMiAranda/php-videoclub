<?php 

    include_once 'Resumible.php';

    class Cliente implements Resumible {

        private static int $contador = 0;

        protected int $numero;
        private int $numSoportesAlquilados;
        private array $soportesAlquilados;
    
        public function __construct(
            public string $nombre,
            private int $maxAlquilerConcurrente = 3,
        )
        {
            $this->numSoportesAlquilados = 0;
            $this->numero = self::$contador++;
            $this->soportesAlquilados = [];
        }   
        
        public function getNumero(): int {
            return $this->numero;
        }

        public function setNumero(int $numero): void {
            $this->numero = $numero;
        }

        public function getNumSoporteAlquilados(): int {
            return $this->numSoportesAlquilados;
        }

        public function getMaxAlquilerConcurrente(): int {
            return $this->maxAlquilerConcurrente;
        }

        public function muestraResumen() {
            echo $this->nombre . PHP_EOL;
            echo "Alquileres actuales: {$this->numSoportesAlquilados}" . PHP_EOL;
        }

        public function tieneAlquilado(Soporte $s): bool {
            return array_any($this->soportesAlquilados, function($soporte) use($s): bool {
                if(!($soporte instanceof Soporte)) return false;
                return $soporte->getNumero() === $s->getNumero();
            });
        }

        public function alquilar(Soporte $s): bool {
            if($this->tieneAlquilado($s) 
                || count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) return false;
            $this->soportesAlquilados[] = $s;
            $this->numSoportesAlquilados++;
            return true;
        }

        public function devolver(int $numSoporte): bool {
            
            if(!(array_any($this->soportesAlquilados, function($s) use($numSoporte) : bool{
                if(!($s instanceof Soporte)) return false;
                return $s->getNumero() === $numSoporte;
            }))) return false;
            
            $this->soportesAlquilados = array_filter($this->soportesAlquilados, function($s) use($numSoporte): bool {
                if(!($s instanceof Soporte)) return false;
                return $s->getNumero() !== $numSoporte;
            });
            return true;
        }

        public function listaAlquileres(): void {
            echo "Alquileres: " . count($this->soportesAlquilados);
            foreach($this->soportesAlquilados as $soporte) {
                if($soporte instanceof Soporte) $soporte->muestraResumen();
            }
        }
    }

?>