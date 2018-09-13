<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta{
	protected $valorPasaje = 0;
	protected $tipo = "Franq. C.";
	
	public function abonarPasaje(ColectivoInterface $colectivo){
		$this->horaViaje = $this->tiempo->time();
		return True;
	}
}
