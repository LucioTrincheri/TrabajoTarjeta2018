<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta{
	protected $valorPasaje = 0;
	protected $franqRestantes = 2;
	
	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			if($this->franqRestantes > 0)
			{
				$this->franqRestantes -= 1;
				$this->horaViaje = $this->tiempo->time();
				return True;
			}
			else
			{
				$hora = $this->tiempo->time();
				if($hora - $this->horaViaje >= 86400 || $hora == 0)
				{
					$this->franqRestantes = 2;
					$this->franqRestantes -= 1;
					$this->horaViaje = $this->tiempo->time();
					return True;
				}
			}
			
			$this->saldo -= $this->valorPasaje+14.8;
			$this->horaViaje = $this->tiempo->time();
			return True;
			
		}
		else if($this->plus > 0)
		{
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			return True;
		}
		else
		{
			return False;
		}
	}
}
