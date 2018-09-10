<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

    protected $colectivo;
	protected $tarjeta;

	protected $fecha;
	protected $tipoT;
	protected $saldoT;
	protected $IDT;
	protected $lineaC;
	protected $abono;
	protected $plusA;

    public function __construct($colectivo, $tarjeta) {
		$this->colectivo = $colectivo;
		$this->tarjeta = $tarjeta;

		$this->fecha = date("d/m/Y H:i:s", $tarjeta->getHora());
		$this->tipoT = $tarjeta->tipoTarjeta();
		$this->saldoT = $tarjeta->obtenerSaldo();
		$this->IDT = $tarjeta->getID();
		$this->lineaC = $colectivo->linea();
		$this->abono = $tarjeta->ultAbono();
		$this->plusA = $tarjeta->ultCantPlus();
    }

    public function obtenerValor() {
        return $this->abono;
    }

    public function obtenerColectivo() {
	return $this->colectivo;
    }

}
