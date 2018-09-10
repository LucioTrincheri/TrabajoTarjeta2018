<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta{
	protected $valorPasaje = 0;
	
	public function abonarPasaje(){
		$hora = $this->tiempo->time();
		$this->horaViaje = $this->tiempo->time();
		return True;
	}
}
