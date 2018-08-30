<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;

	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			$hora = time();
			if($hora - $this->horaViaje >= 300)
			{
				$this->saldo -= $this->valorPasaje;
				$this->horaViaje = time();
				return True;
			}
			
			$this->saldo -= ($this->valorPasaje*2);
			$this->horaViaje = time();
			return True;
			
		}
		else if($this->plus > 0)
		{
			$this->plus -= 1;
			$this->horaViaje = time();
			return True;
		}
		else
		{
			return False;
		}
	}
}
