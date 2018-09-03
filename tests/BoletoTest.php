<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase {

	/**
	* Comprueba que obtenerValor no cambia el saldo de la tarjeta, sino que solo lo consulta.
	*/

    public function testSaldoCero() {
        $valor = 14.80;
        $boleto = new Boleto($valor, NULL, NULL);

        $this->assertEquals($boleto->obtenerValor(), $valor);
    }

	public function testViajeSimple() {
		$colectivo = new Colectivo(NULL, NULL, NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);

		$valor = 14.80;
        	$boleto = new Boleto($valor, $colectivo, $tarjeta);

		$this->assertEquals($boleto->obtenerColectivo(), $colectivo);
	}
}
