<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

    	protected $saldo=0;
	protected $plus=2;
	protected $valorPasaje = 14.8;
	protected $horaViaje = 0;
	protected $tipo = "Movi";
	protected $ultViajePlus=0;
	protected $ultimoAbono=0;
	protected $ID=0;
	
	public function __construct(TiempoInterface $tiempo, $id=0)
	{
		$this->tiempo = $tiempo;
		$this->ID = $id;
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
		if($this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2))))
		{
			$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2)));
			$this->horaViaje = $this->tiempo->time();
			$this->plus = 2;
			$this->CalculoAbonoTotal(($this->valorPasaje * (1 + abs($this->plus - 2))));
			return True;
		}else if($this->plus > 0){
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			$this->CalculoAbonoTotal(0);
			return True;
		}
		return False;
	}

	public function valorDelPasaje(){
		return $this->valorPasaje;
	}

	public function tipoTarjeta(){
		return $this->tipo;
	}
	
	public function CalculoAbonoTotal($total){
		if($total == 0){
			$this->ultimoAbono=0;
			$this->ultViajePlus=1;
			return NULL;
		}
		$this->ultimoAbono = $total;
		$this->ultViajePlus = ($total - $this->valorPasaje) / $this->valorPasaje;
	}

	public function ultAbono(){
		return $this->ultimoAbono;
	}

	public function ultCantPlus(){
		return $this->ultViajePlus;
	}

	public function getID(){
		return $this->ID;
	}

	public function getHora(){
		return $this->horaViaje;
	}
}
