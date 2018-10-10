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

		$this->fecha = $tarjeta->getHora();
		$this->tipoT = $tarjeta->tipoTarjeta();
		$this->saldoT = $tarjeta->obtenerSaldo();
		$this->IDT = $tarjeta->getID();
		$this->lineaC = $colectivo->linea();
		$this->abono = $tarjeta->ultAbono();
		$this->plusA = $tarjeta->ultCantPlus();
		$this->PasjAbonado = $tarjeta->ultPasajeAbonado();
	}

	public function Fecha() {
		return $this->fecha;
	}

	public function TipoTarjeta() {
		return $this->tipoT;
	}

	public function SaldoTarjeta() {
		return $this->saldoT;
	}

	public function IDTarjeta() {
		return $this->IDT;
	}

	public function LineaColectivo() {
		return $this->lineaC;
	}

	public function Abono() {
		return $this->abono;
	}

	public function PlusAbonados() {
		return $this->plusA;
	}
	
	public function PasajeAbonado() {
		return $this->PasjAbonado;
	}



	public function obtenerColectivo() {
		return $this->colectivo;
	}
}
