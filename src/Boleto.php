<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $valor;
    protected $colectivo;
	protected $tarjeta;

    public function __construct($valor, $colectivo, $tarjeta) {
        $this->valor = $valor;
		$this->colectivo = $colectivo;
		$this->tarjeta = $tarjeta;
    }

    public function obtenerValor() {
        return $this->valor;
    }

    public function obtenerColectivo() {
	return $this->colectivo;
    }

}
