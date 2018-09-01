<?php

namespace TrabajoTarjeta;

class MedioBoletoUni extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $mediosRestantes = 2;
	protected $new = True;

	public function abonarPasaje(){
		if($this->saldo >= $this->valorPasaje)
		{
			$hora = $this->tiempo->time();
			if($hora - $this->horaViaje >= 300 || $new == True)
			{
				if($this->mediosRestantes > 0)
				{
					$this->mediosRestantes -= 1;
					$this->saldo -= $this->valorPasaje;
					$this->horaViaje = $this->tiempo->time();
					$this->new = False;
					return True;
				}
				else if($hora - $this->horaViaje >= 86400)
				{
					$this->mediosRestantes = 1;
					$this->saldo -= $this->valorPasaje;
					$this->horaViaje = $this->tiempo->time();
					$this->new = False;
					return True;
				}
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
