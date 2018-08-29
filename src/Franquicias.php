<?php

namespace TrabajoTarjeta;

class MedioBoleto extends Tarjeta {
	protected $valorPasaje = 7.4;
}

class FranquiciaCompleta extends Tarjeta {
	protected $valorPasaje = 0;
}
