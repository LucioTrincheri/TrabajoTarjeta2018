<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {

    public function testEmpresaValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->empresa() , $empresa);
    }
    public function testLineaValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->linea() , $linea);
    }
    public function testNumeroValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->numero() , $unidad);
    }
	public function testPagoValido() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new Tarjeta();
		$tarjeta->recargar(20);
		$colectivo->pagarCon($tarjeta);
	}
	public function testPagoInalido() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new Tarjeta();
		$colectivo->pagarCon($tarjeta);
	}
}
