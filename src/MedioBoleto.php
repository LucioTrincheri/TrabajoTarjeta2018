<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $nueva = True;
	protected $tipo = "Medio";

	public function abonarPasaje(){
		if($this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2) * 2)))
		{
			$hora = $this->tiempo->time();
			if($hora - $this->horaViaje >= 300 || $this->nueva == True)
			{
				$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2) * 2));
				$this->horaViaje = $this->tiempo->time();
				$this->nueva = False;
				$this->plus = 2;
				return True;
			}
			
			if($this->saldo >= ($this->valorPasaje * (2 + abs($this->plus - 2) * 2))){
				$this->saldo -= ($this->valorPasaje * (2 + abs($this->plus - 2) * 2));
				$this->plus = 2;
				$this->horaViaje = $this->tiempo->time();
				$this->plus = 2;
				return True;
			}
			
		}
		if($this->plus > 0)
		{
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			return True;
		}
		return False;
	}
}
