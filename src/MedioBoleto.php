<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $nueva = true;
	protected $tipo = 'Medio';

	public function evaluar_trasbordo($colectivo) {
		if ( $this->tiempo->time() - $this->horaViaje >= 300 || true === $this->nueva) {
			$saldoSuf = (round( ($this->valorPasaje / 3), 3 ) + abs( $this->plus - 2 ) * $this->valorPasaje * 2) < $this->saldo;
		} else {
			$saldoSuf = (round( ($this->valorPasaje * 2 / 3), 3 ) + abs( $this->plus - 2 ) * $this->valorPasaje * 2) < $this->saldo;
		}
		return ( $this->comparar_bus( $colectivo ) && $this->check_hora() && $this->puedeTrasb && $saldoSuf );
	}

	public function abonar_trasbordo($colectivo) {
		if ( $this->tiempo->time() - $this->horaViaje >= 300 || true === $this->nueva) {
			$valor = (round( ($this->valorPasaje / 3), 3 ) + abs( $this->plus - 2 ) * $this->valorPasaje * 2);
		} else {
			$valor = (round( ($this->valorPasaje * 2 / 3), 3 ) + abs( $this->plus - 2 ) * $this->valorPasaje * 2);
		}

		$this->saldo -= $valor;
		$this->horaViaje = $this->tiempo->time();
		$this->puedeTrasb = false;
		$this->plus = 2;
		$this->nueva = false;
		$this->calculo_abono_total( $valor, round( ($this->valorPasaje / 3), 3 ) );
		$this->nuevo_colectivo( $colectivo );
		return true;
	}


// fin trasbordo


	public function abonar_pasaje(ColectivoInterface $colectivo) {
		if ( $this->evaluarTrasbordo( $colectivo ) ) {
			return $this->abonar_trasbordo( $colectivo );
		}
		if ( $this->saldo >= ($this->valorPasaje * (1 + abs( $this->plus - 2 ) * 2)) )
		{
			if ( $this->tiempo->time() - $this->horaViaje >= 300 || true == $this->nueva )
			{
				$this->saldo -= ($this->valorPasaje * (1 + abs( $this->plus - 2 ) * 2));
				$this->horaViaje = $this->tiempo->time();
				$this->nueva = false;
				$this->puedeTrasb = true;
				$this->plus = 2;
				$this->nuevo_colectivo( $colectivo );
				return true;
			}
			
			if ( $this->saldo >= ($this->valorPasaje * (2 + abs( $this->plus - 2 ) * 2)) ) {
				$this->saldo -= ($this->valorPasaje * (2 + abs( $this->plus - 2 ) * 2));
				$this->plus = 2;
				$this->horaViaje = $this->tiempo->time();
				$this->puedeTrasb = true;
				$this->plus = 2;
				$this->nuevo_colectivo( $colectivo );
				return true;
			}
			
		}
		if ($this->plus > 0) {
			return $this->abonar_plus( $colectivo );
		}
		return false;
	}
}
