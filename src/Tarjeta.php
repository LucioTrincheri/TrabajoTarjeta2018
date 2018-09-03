<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

    	protected $saldo=0;
	protected $plus=2;
	protected $valorPasaje = 14.8;
	protected $horaViaje = 0;
	
	public function __construct(TiempoInterface $tiempo)
	{
		$this->tiempo = $tiempo;
	}
	
	public function recPlus() {
		if($this->plus == 1)
		{
			if($this->saldo >= 14.8)
			{
				$this->saldo -= 14.8; //el valor del plus es siempre el valor total
				$this->plus = 2;
			}
		}
		
		if($this->plus == 0)
		{
			if($this->saldo >= 29.6)
			{
				$this->saldo -= 29.6;
				$this->plus = 2;
			}
			else if($this->saldo >= 14.8)
			{
				$this->saldo -= 14.8;
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
	}else{
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
			$this->horaViaje = $this->tiempo->time();
			return True;
		}else if($this->plus > 0){
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			return True;
		}else{
			return False;
		}
	}

	public function valorDelPasaje(){
		return $this->valorPasaje;
	}
}
