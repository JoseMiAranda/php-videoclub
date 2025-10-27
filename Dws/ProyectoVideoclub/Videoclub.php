<?php 
    namespace Dws\ProyectoVideoclub;
    
    include_once 'Soporte.php';
    include 'CintaVideo.php';
    include 'Cliente.php';
    include 'Dvd.php';
    include 'Juego.php';

    class Videoclub {
        
        private int $numProductos;
        private int $numSocios;

        private array $productos;
        private array $socios;
        
        public function __construct(
            private string $nombre,
        ) {
            $this->numProductos = 0;
            $this->numSocios = 0;
            $this->productos = [];
            $this->socios = [];
        }

        private function incluirProducto(Soporte $producto): bool {
            if(array_any($this->productos, function($p) use ($producto): bool {
                return $p instanceof Soporte && $p->getNumero() == $producto->getNumero();
            })) return false;
            $this->productos[] = $producto;
            $this->numProductos++;
            echo "Incluido soporte {$producto->getNumero()}" . PHP_EOL;
            return true;
        }

        public function incluirCintaVideo(string $titulo, float $precio, int $duracion): bool {
            return $this->incluirProducto(new CintaVideo($titulo, $precio, $duracion));
        }

        public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): bool {
            return $this->incluirProducto(new Dvd($titulo, $precio, $idiomas, $pantalla));
        }

        public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): bool {
            return $this->incluirProducto(new Juego($titulo, $precio, $consola, $minJ, $maxJ));
        }

        public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes = 3): void {
            $socio = new Cliente($nombre, $maxAlquileresConcurrentes);
            $this->socios[] = $socio;
            $this->numSocios++;
            echo "Incluido socio {$socio->getNumero()}" . PHP_EOL;
        }

        public function listarProductos(): void {
            echo "Listado de los {$this->numProductos} productos disponibles:" . PHP_EOL;
            foreach($this->productos as $clave => $producto) {
                if($producto instanceof Soporte) {
                    echo $clave++ . '-';
                    $producto->muestraResumen();
                }
            }
        }

        public function listarSocios(): void {
           echo "Listado de {$this->numSocios} socios del videoclub:" . PHP_EOL;
           foreach($this->socios as $clave => $cliente){
            echo $clave + 1 . '.- ';
            echo $cliente->muestraResumen();
           }
        }

        public function  alquilarSocioProducto(int $numeroCliente, int $numeroProducto): void {
            $cliente = array_find($this->socios, function($s) use ($numeroCliente) {
                return $s instanceof Cliente && $s->getNumero() === $numeroCliente;
            });

            if(!$cliente || !($cliente instanceof Cliente)) {
                echo "No existe el cliente" . PHP_EOL;
                return;
            }

            $producto = array_find($this->productos, function($s) use ($numeroProducto) {
                return $s instanceof Soporte && $s->getNumero() === $numeroProducto;
            });

            if(!$producto || !($producto instanceof Soporte)) {
                echo "No existe el producto" . PHP_EOL;
                return;
            }

            $estaReservado = array_find(array_merge(array_map(function($s) {
                return $s instanceof Cliente ? $s->getNumSoporteAlquilados() : [];
            }, $this->socios)), function($p) use($numeroCliente) {
                return $p instanceof Soporte && $p->getNumero() == $numeroCliente;
            }); 
            
            if($estaReservado) {
                echo "El producto ya está reservado por otro cliente" . PHP_EOL;
                return;
            }

            if($cliente->alquilar($producto)) {
                echo "Alquilado soporte a: {$cliente->nombre}";
                $producto->muestraResumen();
            } else {
                if($cliente->getMaxAlquilerConcurrente() > $cliente->getNumSoporteAlquilados()) {
                    echo "El cliente ya tiene reservado el soporte {$producto->titulo}" . PHP_EOL;
                    return;
                }
                echo "Este cliente tiene {$cliente->getNumSoporteAlquilados()} elementos alquilados. No puede alquilar más en este videoclub hasta que no devuelva algo" . PHP_EOL;
            }
        }

    }

?>