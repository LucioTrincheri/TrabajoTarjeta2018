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
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 5.2);
	}

	public function testPagoValidoPlus() {
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->recargar(10);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 10);
		$this->assertEquals($tarjeta->obtenerPlus(), 1);
		$this->assertTrue($tarjeta->abonarPasaje($colectivo));
		$this->assertEquals($tarjeta->obtenerSaldo(), 10);
		$this->assertEquals($tarjeta->obtenerPlus(), 0);
		$this->assertFalse($tarjeta->abonarPasaje($colectivo));
	}

	/**
	* Comprueba que el resultado de pagarCon sea False al no tener el saldo suficiente, sin
	* retirar el valor del pasaje.
	*/
	public function testPagoInvalido() {
		$tiempoReal = new Tiempo;
		$colectivo = new Colectivo(NULL,NULL,NULL);
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->abonarPasaje($colectivo); //Elimino los plus iniciales
		$tarjeta->abonarPasaje($colectivo);
		$this->assertFalse($tarjeta->abonarPasaje($colectivo));
		$this->assertFalse($colectivo->pagarCon($tarjeta));
	}
}
