<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciaTest extends TestCase {

	public function testPagoValidoMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal);
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 12.6);
	}

	public function testPagoValidoPlusMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$tarjeta->recargar(20); //para arreglar a futuro: en este punto se va a creer que hace poco se hizo un viaje medio boleto, por lo tanto no se cobrara el siguiente, cuando en realidad fue un viaje plus
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}

	public function testValorPasajeMedioBoleto(){
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal);
		$tarjeta2 = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$tarjeta2->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertTrue($tarjeta2->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), $tarjeta2->obtenerSaldo());
	}

	public function PasajeSiempreFranComp(){
		$tiempoReal = new Tiempo;
		$tarjeta = new FranquiciaCompleta($tiempoReal);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(),2); //Pasaje abonado correctamente y cant. plus sigue siendo 2
	}

}
