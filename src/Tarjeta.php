<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

    protected $saldo=0;
	protected $plus=2;
	protected $valorPasaje = 14.8;
	
	public function recPlus() {
		if($this->plus == 1)
		{
			if($this->saldo >= $this->valorPasaje)
			{
				$this->saldo -= $this->valorPasaje;
				$this->plus = 2;
			}
		}
		
		if($this->plus == 0)
		{
			if($this->saldo >= 2*$this->valorPasaje)
			{
				$this->saldo -= 2*$this->valorPasaje;
				$this->plus = 2;
			}
			else if($this->saldo >= $this->valorPasaje)
			{
				$this->saldo -= $this->valorPasaje;
				$this->plus = 1;
			}
		}
	}
		
    public function recargar($monto) {
      if ($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100 || $monto == 510.15 || $monto == 962.59) {

	if($monto == 510.15) {
		$this->saldo += 81.93;
	}

	if($monto == 962.59) {
		$this->saldo += 221.58;
	}

        $this->saldo += $monto;
	
	$this->recPlus();

	return True;
	}
	else
	{
	return False;
	}
    }

    public function obtenerSaldo() {
		return $this->saldo;
    }

	public function obtenerPlus() {
		return $this->plus;
    }

	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			$this->saldo -= $this->valorPasaje;
			$boleto = new Boleto($tarjeta->valorDelPasaje(), $this, $tarjeta);
			return $boleto;
		}else if($this->plus > 2){
			$this->plus -= 1;
			$boleto = new Boleto($tarjeta->valorDelPasaje(), $this, $tarjeta);
			return $boleto;
		}else{
			return False;
		}
	}

	public function valorDelPasaje(){
		return $this->valorPasaje;
	}
}

class MedioBoleto extends Tarjeta {
	protected $valorPasaje = 7.4; //no solo pasar a archivo propio sino hacerlo en base al valor del boleto original
}

class FranquiciaCompleta extends Tarjeta {
	protected $valorPasaje = 0;
}
