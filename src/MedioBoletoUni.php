<?php

namespace TrabajoTarjeta;

class MedioBoletoUni extends MedioBoleto
{
	protected $mediosRestantes = 2;
	protected $tipo = 'Medio U.';
	protected $diaAbo;

	public function abonar_pasaje(ColectivoInterface $colectivo) {
		if ( $this->saldo >= ($this->valorPasaje * (1 + abs( $this->plus - 2 ) * 2)) ) {
			if ( $this->tiempo->time() - $this->horaViaje >= 300 || true === $this->nueva ) {
				if ( $this->mediosRestantes > 0 ) {
					$this->mediosRestantes -= 1;
					if ( $this->evaluar_trasbordo( $colectivo ) ) {
						return $this->abonar_trasbordo( $colectivo );
					}
					$this->saldo -= ($this->valorPasaje * (1 + abs( $this->plus - 2 ) * 2));
					$this->horaViaje = $this->tiempo->time();
					$this->nueva = false;
					$this->puedeTrasb = true;
					$this->plus = 2;
					$this->diaAbo = date( 'z', $this->tiempo->time() );
					$this->nuevo_colectivo( $colectivo );
					return true;
				}
				if ( date( 'z', $this->tiempo->time() ) > $this->diaAbo ) {
					$this->mediosRestantes = 1;
					if ( $this->evaluar_trasbordo( $colectivo ) ) {
						return $this->abonar_trasbordo( $colectivo );
					}
					$this->saldo -= ($this->valorPasaje * (1 + abs( $this->plus - 2 ) * 2));
					$this->horaViaje = $this->tiempo->time();
					$this->nueva = false;
					$this->puedeTrasb = true;
					$this->plus = 2;
					$this->diaAbo = date( 'z', $this->tiempo->time() );
					$this->nuevo_colectivo( $colectivo );
					return true;
				}
			}
			if ( $this->saldo >= ($this->valorPasaje * (2 + abs( $this->plus - 2 ) * 2)) ) {
				if ( $this->evaluar_trasbordo( $colectivo ) ) {
					return $this->abonar_trasbordo( $colectivo );
				}
				$this->saldo -= ($this->valorPasaje * (2 + abs( $this->plus - 2 ) * 2));
				$this->plus = 2;
				$this->horaViaje = $this->tiempo->time();
				$this->puedeTrasb = true;
				$this->nuevo_colectivo( $colectivo );
				return true;
			}
		}
		if ( $this->plus > 0 ) {
			return $this->abonar_plus( $colectivo );
		}
		return false;
	}
}
