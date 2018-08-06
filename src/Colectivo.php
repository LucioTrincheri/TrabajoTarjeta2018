<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface {

    protected $linea;
    protected $empresa;
	protected $numero;

    public function __construct($empresa, $linea, $numero) {
        $this->empresa = $empresa;
		$this->linea = $linea;
		$this->numero = $numero;
    }

    public function linea(){
		return $this->linea;
	}

	public function empresa(){
		return $this->empresa;
	}

	public function numero(){
		return $this->numero;
	}

	public function pagarCon(TarjetaInterface $tarjeta){
		if($tarjeta->obtenerSaldo() >= 14.80){
			$tarjeta->abonarPasaje();
			
			$boleto = new Boleto(14.80, $this, $tarjeta);
			return $boleto;
		} else {
			return False;
		}
	}
}
