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
	* Comprueba que el resultado de pagar_con sea un boleto al tener el saldo suficiente, retirando
	* el valor del pasaje.
	*/
	public function testPagoValido() {
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->recargar(20);
		$this->assertTrue($tarjeta->abonar_pasaje($colectivo));
		$this->assertEquals($tarjeta->obtener_saldo(), 5.2);
	}

	public function testPagoValidoPlus() {
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->recargar(10);
		$this->assertTrue($tarjeta->abonar_pasaje($colectivo));
		$this->assertEquals($tarjeta->obtener_saldo(), 10);
		$this->assertEquals($tarjeta->obtener_plus(), 1);
		$this->assertTrue($tarjeta->abonar_pasaje($colectivo));
		$this->assertEquals($tarjeta->obtener_saldo(), 10);
		$this->assertEquals($tarjeta->obtener_plus(), 0);
		$this->assertFalse($tarjeta->abonar_pasaje($colectivo));
	}

	/**
	* Comprueba que el resultado de pagar_con sea False al no tener el saldo suficiente, sin
	* retirar el valor del pasaje.
	*/
	public function testPagoInvalido() {
		$tiempoReal = new Tiempo;
		$colectivo = new Colectivo(NULL,NULL,NULL);
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->abonar_pasaje($colectivo); //Elimino los plus iniciales
		$tarjeta->abonar_pasaje($colectivo);
		$this->assertFalse($tarjeta->abonar_pasaje($colectivo));
		$this->assertFalse($colectivo->pagar_con($tarjeta));
	}
}
