<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta
{
	protected $valorPasaje = 7.4;
	protected $nueva = True;
	protected $tipo = "Medio";
	protected $hora = 0;



	public function evaluarTrasbordo($colectivo){
		if($this->hora - $this->horaViaje >= 300 || $this->nueva == True){
			$saldoSuf = (round(($this->valorPasaje / 3),3) + abs($this->plus - 2) * $this->valorPasaje * 2) < $this->saldo;
		}
		else{
			$saldoSuf = (round(($this->valorPasaje * 2 / 3),3) + abs($this->plus - 2) * $this->valorPasaje * 2) < $this->saldo;
		}
		return ($this->compararBus($colectivo) && $this->checkHora() && $this->puedeTrasb && $saldoSuf);
	}


	public function abonarTrasbordo($colectivo){
		if($this->hora - $this->horaViaje >= 300 || $this->nueva == True){
			$valor = (round(($this->valorPasaje / 3),3) + abs($this->plus - 2) * $this->valorPasaje * 2);
		}
		else{
			$valor = (round(($this->valorPasaje * 2 / 3),3) + abs($this->plus - 2) * $this->valorPasaje * 2);
		}

		$this->saldo -= $valor;
		$this->horaViaje = $this->tiempo->time();
		$this->puedeTrasb = False;
		$this->plus = 2;
		$this->nueva = False;
		$this->CalculoAbonoTotal($valor , round(($this->valorPasaje / 3),3));
		$this->NuevoColectivo($colectivo);
		return True;
	}


// fin trasbordo


	public function abonarPasaje(ColectivoInterface $colectivo){
		$this->hora = $this->tiempo->time();
		if($this->evaluarTrasbordo($colectivo)){return $this->abonarTrasbordo($colectivo);}
		if($this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2) * 2)))
		{
			if($this->hora - $this->horaViaje >= 300 || $this->nueva == True)
			{
				$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2) * 2));
				$this->horaViaje = $this->tiempo->time();
				$this->nueva = False;
				$this->puedeTrasb = True;
				$this->plus = 2;
				$this->NuevoColectivo($colectivo);
				return True;
			}
			
			if($this->saldo >= ($this->valorPasaje * (2 + abs($this->plus - 2) * 2))){
				$this->saldo -= ($this->valorPasaje * (2 + abs($this->plus - 2) * 2));
				$this->plus = 2;
				$this->horaViaje = $this->tiempo->time();
				$this->puedeTrasb = True;
				$this->plus = 2;
				$this->NuevoColectivo($colectivo);
				return True;
			}
			
		}
		if($this->plus > 0)
		{
			$this->plus -= 1;
			$this->puedeTrasb = True;
			$this->horaViaje = $this->tiempo->time();
			$this->NuevoColectivo($colectivo);
			return True;
		}
		return False;
	}
}
