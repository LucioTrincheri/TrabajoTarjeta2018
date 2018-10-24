<?php

namespace TrabajoTarjeta;

class Colectivo implements ColectivoInterface {

	protected $linea;
	protected $empresa;
	protected $numero;

	public function __construct($empresa = null, $linea = null, $numero = null) {
		$this->empresa	= $empresa;
		$this->linea	= $linea;
		$this->numero	= $numero;
	}

	public function linea() {
		return $this->linea;
	}

	public function empresa() {
		return $this->empresa;
	}

	public function numero() {
		return $this->numero;
	}

	public function pagar_con(TarjetaInterface $tarjeta) {
		if ( $tarjeta->abonar_pasaje( $this ) ) {
			$boleto = new Boleto( $this, $tarjeta );
			return $boleto;
		} else {
			return false;
		}
	}
}
