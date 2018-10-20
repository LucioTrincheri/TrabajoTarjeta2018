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
		$this->fecha = $tarjeta->get_hora();
		$this->tipoT = $tarjeta->tipo_tarjeta();
		$this->saldoT = $tarjeta->obtener_saldo();
		$this->IDT = $tarjeta->get_id();
		$this->lineaC = $colectivo->linea();
		$this->abono = $tarjeta->ult_abono();
		$this->plusA = $tarjeta->ult_cant_plus();
		$this->PasjAbonado = $tarjeta->ult_pasaje_abonado();
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
