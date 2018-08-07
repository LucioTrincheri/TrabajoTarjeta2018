<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {


	/**
	* Comprueba que al crear una instancia de colectivo, el campo empresa es correcto.
	*
	*/
    public function testEmpresaValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->empresa() , $empresa);
    }
	/**
	* Comprueba que al crear una instancia de colectivo, el campo linea es correcto.
	*
	*/
    public function testLineaValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->linea() , $linea);
    }
	/**
	* Comprueba que al crear una instancia de colectivo, el campo numero es correcto.
	*
	*/
    public function testNumeroValida() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
        $this->assertEquals($colectivo->numero() , $unidad);
    }
	/**
	* Comprueba que el resultado de pagarCon sea un boleto al tener el saldo suficiente, retirando
	* el valor del pasaje.
	*/
	public function testPagoValido() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new Tarjeta();
		$tarjeta->recargar(20);
		$this->assertInstanceOf(Boleto::class, ($colectivo->pagarCon($tarjeta)));
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}
	/**
	* Comprueba que el resultado de pagarCon sea False al no tener el saldo suficiente, sin
	* retirar el valor del pasaje.
	*/
	public function testPagoInvalido() {
		$empresa = "AmericanAirlines";
		$linea = "666 RapalaProFishing";
		$unidad = 420;
		$colectivo = new Colectivo($empresa, $linea, $unidad);
		$tarjeta = new Tarjeta();
		$this->assertFalse($colectivo->pagarCon($tarjeta));
	}
}
