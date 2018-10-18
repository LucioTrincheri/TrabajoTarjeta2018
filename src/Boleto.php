<?php

namespace TrabajoTarjeta;

class Boleto implements BoletoInterface {

	protected $colectivo;
	protected $tarjeta;
	protected $PasjAbonado;
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
		$this->fecha = $tarjeta->getHora();
		$this->tipoT = $tarjeta->tipoTarjeta();
		$this->saldoT = $tarjeta->obtenerSaldo();
		$this->IDT = $tarjeta->getID();
		$this->lineaC = $colectivo->linea();
		$this->abono = $tarjeta->ultAbono();
		$this->plusA = $tarjeta->ultCantPlus();
		$this->PasjAbonado = $tarjeta->ultPasajeAbonado();
	}

	public function fecha() {
		return $this->fecha;
	}

	public function tipo_tarjeta() {
		return $this->tipoT;
	}

	public function saldo_tarjeta() {
		return $this->saldoT;
	}

	public function id_tarjeta() {
		return $this->IDT;
	}

	public function linea_colectivo() {
		return $this->lineaC;
	}

	public function abono() {
		return $this->abono;
	}

	public function plus_abonados() {
		return $this->plusA;
	}
	
	public function pasaje_abonado() {
		return $this->PasjAbonado;
	}

	public function obtener_colectivo() {
		return $this->colectivo;
	}
}
