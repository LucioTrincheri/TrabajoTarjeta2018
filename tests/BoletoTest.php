<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

	/**
	* Comprueba que obtenerValor no cambia el saldo de la tarjeta, sino que solo lo consulta.
	*/

    public function testSaldoCero() {
		$valor = 14.80;
		$colectivo = new Colectivo(NULL, NULL, NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$boleto = new Boleto($colectivo, $tarjeta);
		$this->assertEquals($boleto->abono(), 0);
    }

	public function testViajeSimple() {
		$colectivo = new Colectivo(NULL, NULL, NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$valor = 14.80;
        $boleto = new Boleto($colectivo, $tarjeta);
		$this->assertEquals($boleto->obtener_Colectivo(), $colectivo);
	}

	public function testNuevosAtributos(){
		$colectivo = new Colectivo(NULL, "142 Verde", NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$boleto = $colectivo->pagar_con($tarjeta);
		$this->assertEquals($boleto->fecha(), $tiempoReal->time());
		$this->assertEquals($boleto->tipo_tarjeta(), "Movi");
		$this->assertEquals($boleto->saldo_tarjeta(), 5.2);
		$this->assertEquals($boleto->id_tarjeta(), 0);
		$this->assertEquals($boleto->linea_colectivo(), "142 Verde");
		$this->assertEquals($boleto->abono(), 14.8);
		$this->assertEquals($boleto->pasaje_Abonado(), 14.8);
		$this->assertEquals($boleto->plus_abonados(), 0);
	}
}
