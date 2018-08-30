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
		$tarjeta = new MedioBoleto($tiempoReal); //uso tiempo real porque no afecta esta prueba, pero tener en cuenta que al usar tiempo real no se puede simular el paso del tiempo lo que activa la resticcion del medio boleto
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$tarjeta->recargar(20);
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}

	public function testValorPasajeMedioBoleto(){
		$tiempoFalso = new TiempoFalso;
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$tarjeta2 = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$tarjeta2->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$tiempoFalso -> avanzar(400);
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

	public function testTiempoEntreMedios(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$tiempoFalso -> avanzar(1); //hago pasar un segundo para evitar la condicion del tiempo 0, todavia no tengo otra manera de resolver ese problema
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
		$tiempoFalso -> avanzar(400);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
	}
	
	public function testTiempoEntreUniv(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta= new FranquiciaCompleta($tiempoFalso);
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$tiempoFalso -> avanzar(1);
		$this->assertEquals($tarjeta->obtenerSaldo(), 50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$tiempoFalso -> avanzar(1);
		$this->assertEquals($tarjeta->obtenerSaldo(), 50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$tiempoFalso -> avanzar(1);
		$this->assertEquals($tarjeta->obtenerSaldo(), 35.2);
		$tiempoFalso -> avanzar(100000);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 35.2);
	}

}
