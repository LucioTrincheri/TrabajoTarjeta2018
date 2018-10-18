<?php

namespace TrabajoTarjeta;

class FranquiciaCompleta extends Tarjeta {
	protected $valorPasaje = 0;
	protected $tipo = 'Franq. C.';
	
	public function abonar_pasaje(ColectivoInterface $colectivo) {
		$this->horaViaje = $this->tiempo->time();
		return true;
	}
}
