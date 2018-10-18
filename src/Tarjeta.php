<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

	protected $saldo = 0;
	protected $plus = 2;
	protected $valorPasaje = 14.8;
	protected $puedeTrasb = false;
	protected $horaViaje = 0;
	protected $tipo = 'Movi';
	protected $ultViajePlus = 0;
	protected $ultimoAbono = 0;
	protected $ultPasaje = 0;
	protected $IDT = 0;
	protected $tiempo;
	protected $lineaAnterior = 'Inicializacion';
	protected $numeroAnterior = 'Inicializacion';

	public function __construct($tiempo, $id = 0)
	{
		$this->tiempo = $tiempo;
		$this->IDT = $id;
	}
	
	public function monto_valido($monto) {
		return in_array( $monto, [10, 20, 30, 50, 100, 510.15, 962.59] );
	}

	public function recargar($monto) {
		if ( !$this->monto_valido($monto) ) {
			return false;
		}
		if ( $monto == 510.15 ) {
			$this->saldo += 81.93;
		}
		if ( $monto == 962.59 ) {
			$this->saldo += 221.58;
		}
		$this->saldo += $monto;
		return true;
	}

	public function obtener_saldo() {
		return $this->saldo;
	}

	public function obtener_plus() {
		return $this->plus;
	}

//comienzo trasbordo y métodos derivados --------
	public function abonar_trasbordo($colectivo) {
		$valor = round(($this->valorPasaje / 3), 3) + abs($this->plus - 2) * $this->valorPasaje;
		$this->saldo -= $valor;
		$this->horaViaje = $this->tiempo->time();
		$this->puedeTrasb = false;
		$this->plus = 2;
		$this->calculo_abono_total( $valor, round(($this->valorPasaje / 3), 3) );
		$this->nuevo_colectivo( $colectivo );
		return true;
	}

	public function evaluar_trasbordo($colectivo) {
		$saldoSuf = ( round(($this->valorPasaje / 3), 3) + abs($this->plus - 2) * $this->valorPasaje ) < $this->saldo;
		return ( $this->comparar_bus($colectivo) && $this->check_hora() && $this->puede_trasb && $saldoSuf );
	}
	
	public function comparar_bus($colectivo) {	
		return (($this->lineaAnterior != $colectivo->linea()) || ($this->numeroAnterior != $colectivo->numero()));
	}
	
	public function intervalo_trasbordo() {
		$sabado = (date("w", $this->tiempo->time()) == 6 && (date("G", $this->tiempo->time()) >= 14 && date("G", $this->tiempo->time()) < 22));
		$domingo = (date("w", $this->tiempo->time()) == 0 && (date("G", $this->tiempo->time()) >= 6 && date("G", $this->tiempo->time()) < 22));
		$noche = (date("G", $this->tiempo->time()) >= 22 && date("G", $this->tiempo->time()) < 6);
		return ($sabado || $domingo || $noche);
	}
	public function check_hora() {
		if ($this->intervalo_trasbordo()) {
			return ($this->tiempo->time() - $this->horaViaje < 5400);
		}
		return ($this->tiempo->time() - $this->horaViaje < 3600);
	}
	
//fin trasbordo y métodos derivados --------- --------- --------- --------- --------- --------- --------- --------- --------- ---------
	public function abonar_pasaje(ColectivoInterface $colectivo) {
		if ( $this->evaluar_trasbordo($colectivo) ) {
			return $this->abonar_trasbordo($colectivo);
		}
		if ( $this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2))) )
		{
			$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2)));
			$this->horaViaje = $this->tiempo->time();
			$this->plus = 2;
			$this->puedeTrasb = True;
			$this->calculo_abono_total( ($this->valorPasaje * (1 + abs($this->plus - 2))), $this->valorPasaje );
			$this->nuevo_colectivo($colectivo);
			return true;
		} elseif ( $this->plus > 0 ) {
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			$this->puedeTrasb = true;
			$this->calculo_abono_total(0, 0);
			$this->nuevo_colectivo($colectivo);
			return true;
		}
		return false;
	}

	public function valor_del_pasaje() {
		return $this->valorPasaje;
	}

	public function tipo_tarjeta() {
		return $this->tipo;
	}
	
	public function calculo_abono_total($total, $valor) {
		if ( $total == 0 ) {
			$this->ultimoAbono = 0;
			$this->ultViajePlus = 1;
			return NULL;
		}
		$this->ultimoAbono = $total;
		$this->ultViajePlus = round(($total - $valor) / $this->valorPasaje);
		$this->ultPasaje = $valor;
	}

	public function ult_abono() {
		return $this->ultimoAbono;
	}

	public function ult_cant_plus() {
		return $this->ultViajePlus;
	}
	
	public function ult_pasaje_abonado() {
		return $this->ultPasaje;
	}

	public function get_id() {
		return $this->IDT;
	}

	public function get_hora() {
		return $this->horaViaje;
	}

	public function nuevo_colectivo($colectivo) {
		$this->lineaAnterior = $colectivo->linea();
		$this->numeroAnterior = $colectivo->numero();
	}
}
