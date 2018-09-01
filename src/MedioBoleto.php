<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $new = True;

	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			$hora = $this->tiempo->time();
			if($hora - $this->horaViaje >= 300 || $new == True;)
			{
				$this->saldo -= $this->valorPasaje;
				$this->horaViaje = $this->tiempo->time();
				$this->new = False;
				return True;
			}
			
			$this->saldo -= ($this->valorPasaje*2);
			$this->new = False;
			return True;
			
		}
		else if($this->plus > 0)
		{
			$this->plus -= 1;
			$this->new = False;
			return True;
		}
		else
		{
			return False;
		}
	}
}
