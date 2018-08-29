<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciaTest extends TestCase {

	public function testPagoValidoMedioBoleto() {
		$tarjeta = new MedioBoleto();
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 12.6);
	}

	public function testPagoValidoPlusMedioBoleto() {
		$tarjeta = new MedioBoleto();
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$tarjeta->recargar(20);
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}

	public function testValorPasajeMedioBoleto(){
		$tarjeta = new MedioBoleto();
		$tarjeta2 = new Tarjeta();
		$tarjeta->recargar(20);
		$tarjeta2->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertTrue($tarjeta2->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), $tarjeta2->obtenerSaldo());
	}

	public function PasajeSiempreFranComp(){
		$tarjeta = new FranquiciaCompleta();
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(),2); //Pasaje abonado correctamente y cant. plus sigue siendo 2
	}

}
