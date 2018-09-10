<?php

namespace TrabajoTarjeta;

class MedioBoletoUni extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $mediosRestantes = 2;
	protected $nueva = True;
	protected $tipo = "Medio U.";

	public function abonarPasaje(){
		if($this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2))))
		{
			$hora = $this->tiempo->time();
			if($hora - $this->horaViaje >= 300 || $this->nueva == True)
			{
				if($this->mediosRestantes > 0)
				{
					$this->mediosRestantes -= 1;
					$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2)));
					$this->horaViaje = $this->tiempo->time();
					$this->nueva = False;
					return True;
				}
				else if($hora - $this->horaViaje >= 86400)
				{
					$this->mediosRestantes = 1;
					$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2)));
					$this->horaViaje = $this->tiempo->time();
					$this->nueva = False;
					return True;
				}
			}
			
			$this->saldo -= ($this->valorPasaje * (2 + abs($this->plus - 2)));
			return True;
			
		}
		else if($this->plus > 0)
		{
			$this->plus -= 1;
			return True;
		}
		return False;
	}
}
