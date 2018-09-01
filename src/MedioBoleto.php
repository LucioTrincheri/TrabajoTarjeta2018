<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;

	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			$hora = $this->tiempo->time();
			if($hora - $this->horaViaje >= 300 || $this->horaViaje == 0)
			{
				$this->saldo -= $this->valorPasaje;
				$this->horaViaje = $this->tiempo->time();
				return True;
			}
			
			$this->saldo -= ($this->valorPasaje*2);
			return True;
			
		}
		else if($this->plus > 0)
		{
			$this->plus -= 1;
			return True;
		}
		else
		{
			return False;
		}
	}
}
