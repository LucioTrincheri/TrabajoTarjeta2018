<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class FranquiciaTest extends TestCase {

	public function testPagoValidoMedioBoleto() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new MedioBoleto();
		$tarjeta->recargar(20);
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertEquals($tarjeta->obtenerSaldo(), 12.6);
	}

	public function testPagoValidoPlusMedioBoleto() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new MedioBoleto();
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$tarjeta->recargar(20);
		$this->assertEquals($tarjeta->obtenerPlus(), 2);
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}

	public function testValorPasajeMedioBoleto(){
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new MedioBoleto();
		$tarjeta2 = new Tarjeta();
		$tarjeta->recargar(20);
		$tarjeta2->recargar(20);
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta2)));
		$this->assertEquals($tarjeta->obtenerSaldo(), $tarjeta2->obtenerSaldo());
	}

	public function PasajeSiempreFranComp(){
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new FranquiciaCompleta();
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertEquals($tarjeta->obtenerPlus(),2); //Pasaje abonado correctamente y cant. plus sigue siendo 2
	}

}
