<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciasTest extends TestCase {

	public function testPagoValidoMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tarjeta = new MedioBoleto($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 12.6);
	}

	public function testPagoValidoeInvalidoPlusMedioBoleto() {
		$tiempoReal = new Tiempo;
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$colectivo = new Colectivo();
		$tarjeta->abonarPasaje($colectivo);
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$tarjeta->abonarPasaje($colectivo);
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$this->assertFalse($tarjeta->abonarPasaje($colectivo));
		$tarjeta->recargar(100);
		$tiempoFalso -> avanzar(5000);
		$tarjeta->abonarPasaje($colectivo);
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 63);
	}

	public function testValorPasajeMedioBoleto(){
		$tiempoFalso = new TiempoFalso;
		$tiempoReal = new Tiempo;
		$colectivo = new Colectivo();
		$tarjeta = new MedioBoleto($tiempoFalso);
		$tarjeta2 = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$tarjeta2->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$tiempoFalso -> avanzar(5000);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertTrue($tarjeta2->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), $tarjeta2->obtenerSaldo());
	}

	public function testPasajeSiempreFranComp(){
		$tiempoReal = new Tiempo;
		$tarjeta = new FranquiciaCompleta($tiempoReal);
		$colectivo = new Colectivo();
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertNotFalse($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerPlus(),2); //Pasaje abonado correctamente y cant. plus sigue siendo 2
	}

	public function testTiempoEntreMedios(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$colectivo = new Colectivo("Semtur","Azul",102);
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
		$tiempoFalso -> avanzar(400);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
	}
	
	public function testTiempoEntreUniv(){
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoletoUni($tiempoFalso);
		$colectivo = new Colectivo();
		$tarjeta->recargar(50);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
		$tiempoFalso -> avanzar(500);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.6);
	}

	public function testInteraccionPlusHorarios(){
		$tiempoFalso = new TiempoFalso;
		$tarjetaF = new MedioBoletoUni($tiempoFalso);
		$tarjetaM = new MedioBoleto($tiempoFalso);
		$colectivo = new Colectivo();
		//creo ambas tarjetas
		$tarjetaF->abonarPasaje($colectivo);
		$tarjetaM->abonarPasaje($colectivo);
		$tarjetaF->abonarPasaje($colectivo);
		$this->assertFalse($tarjetaF->abonarPasaje($colectivo));
		$tarjetaM->abonarPasaje($colectivo);
		$this->assertEquals($tarjetaF->obtenerPlus(), 0);
		$this->assertEquals($tarjetaM->obtenerPlus(), 0);
		//gasto plus
		$tarjetaF->recargar(100);
		$tarjetaM->recargar(100);
		$tarjetaF->abonarPasaje($colectivo);
		$tarjetaM->abonarPasaje($colectivo);
		$this->assertEquals($tarjetaF->obtenerSaldo(), 63);
		$this->assertEquals($tarjetaM->obtenerSaldo(), 63);
		$tiempoFalso->avanzar(500);
		$tarjetaF->abonarPasaje($colectivo);
		$tiempoFalso->avanzar(90000);
		$this->assertTrue($tarjetaF->abonarPasaje($colectivo));
		//chequeo que la hora en que se uso el plus no afecte al medio pero si a la f.completa
	}

	public function testTrasbordoMedio() {
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoleto($tiempoFalso);
		$tarjeta->recargar(50);
		$colectivo1 = new Colectivo("Semtur","Azul",102);
		$this->assertTrue($colectivo1->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$tiempoFalso -> avanzar(600);
		$colectivo2 = new Colectivo("Semtur","Amarillo",145);
		$this->assertTrue($colectivo2->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 40.133);
		$tiempoFalso -> avanzar(600);
		$this->assertTrue($colectivo1->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 32.733);
		$tiempoFalso -> avanzar(100); //avanzo lo suficiente para trasbordo pero no medio boleto.
		$this->assertTrue($colectivo2->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 27.8);
	}

	public function testTrasbordoMedioUni() {
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new MedioBoletoUni($tiempoFalso);
		$tarjeta->recargar(50);
		$colectivo1 = new Colectivo("Semtur","Azul",102);
		$this->assertTrue($colectivo1->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 42.6);
		$tiempoFalso -> avanzar(600);
		$colectivo2 = new Colectivo("Semtur","Amarillo",145);
		$this->assertTrue($colectivo2->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 40.133); //pago medio + trasbordo
		$tiempoFalso -> avanzar(600);
		$this->assertTrue($colectivo1->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 25.333); //ya no tengo plus
		$tiempoFalso -> avanzar(100); //avanzo lo suficiente para trasbordo pero no medio boleto.
		$this->assertTrue($colectivo2->pagarCon($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtenerSaldo(), 20.4);
	}
}
