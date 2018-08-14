<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

    protected $saldo;
	protected $plus;
	
	$plus = 2;

    public function recargar($monto) {
      if ($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100 || $monto == 510.15 || $monto == 962.59) {

	if($monto == 510.15) {
		$this->saldo += 81.93;
	}

	if($monto == 962.59) {
		$this->saldo += 221.58;
	}

        $this->saldo += $monto;
	
	if($this->plus == 1){
		if($this->saldo >= 14.80){
			$this->saldo -= 14.80;
			$this->plus = 2;
		}
	}
	if($this->plus == 0){
		if($this->saldo >= 2*14.80){
			$this->saldo -= 2*14.80;
			$this->plus = 2;
		}
	}

	return True;
	} else {
	return False;
	}
    }

    /**
     * Devuelve el saldo que le queda a la tarjeta.
     *
     * @return float
     */
    public function obtenerSaldo() {
		return $this->saldo;
    }

	public function obtenerPlus() {
		return $this->plus;
    }

	public function abonarPlus() {
		$this->plus -= 1;
    }

	public function abonarPasaje(){
		$this->saldo -= 14.80;
	}
}
