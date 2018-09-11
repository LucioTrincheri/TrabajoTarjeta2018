<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciasTest extends TestCase {

	public function testPagoValidoMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal);
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 12.6);
	}

	public function testPagoValidoeInvalidoPlusMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal); //uso tiempo real porque no afecta esta prueba, pero tener en cuenta que al usar tiempo real no se puede simular el paso del tiempo lo que activa la resticcion del medio boleto
		$tarjeta->abonarPasaje();
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$tarjeta->abonarPasaje();
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$this->assertFalse($tarjeta->abonarPasaje());
		$tarjeta->recargar(100);
		$tarjeta->abonarPasaje();
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 63);
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
		$this->assertNotFalse($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerPlus(),2); //Pasaje abonado correctamente y cant. plus sigue siendo 2
	}

	public function testTiempoEntreMedios(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
		$tiempoFalso -> avanzar(400);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
	}
	
	public function testTiempoEntreUniv(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoletoUni($tiempoFalso);
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
		$tiempoFalso -> avanzar(500);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
		$this->assertTrue($tarjeta->abonarPasaje());
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.6);
	}

	public function testInteraccionPlusHorarios(){
		$tiempoFalso = new TiempoFalso;
		$tarjetaF = new MedioBoletoUni($tiempoFalso);
		$tarjetaM = new MedioBoleto($tiempoFalso);
		//creo ambas tarjetas
		$tarjetaF->abonarPasaje();
		$tarjetaM->abonarPasaje();
		$tarjetaF->abonarPasaje();
		$this->assertFalse($tarjetaF->abonarPasaje());
		$tarjetaM->abonarPasaje();
		$this->assertEquals($tarjetaF->obtenerPlus(), 0);
		$this->assertEquals($tarjetaM->obtenerPlus(), 0);
		//gasto plus
		$tarjetaF->recargar(100);
		$tarjetaM->recargar(100);
		$tarjetaF->abonarPasaje();
		$tarjetaM->abonarPasaje();
		$this->assertEquals($tarjetaF->obtenerSaldo(), 63);
		$this->assertEquals($tarjetaM->obtenerSaldo(), 63);
		$tarjetaF->abonarPasaje();
		$tiempoFalso->avanzar(90000);
		$this->assertTrue($tarjetaF->abonarPasaje());
		//chequeo que la hora en que se uso el plus no afecte al medio pero si a la f.completa
	}
}
