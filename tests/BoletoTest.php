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
        $this->assertEquals($boleto->Abono(), 0);
    }

	public function testViajeSimple() {
		$colectivo = new Colectivo(NULL, NULL, NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$valor = 14.80;
        $boleto = new Boleto($colectivo, $tarjeta);
		$this->assertEquals($boleto->obtenerColectivo(), $colectivo);
	}

	public function testNuevosAtributos(){
		$colectivo = new Colectivo(NULL, "142 Verde", NULL);
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$boleto = $colectivo->pagarCon($tarjeta);
		$this->assertEquals($boleto->Fecha(), $tiempoReal->time());
		$this->assertEquals($boleto->TipoTarjeta(), "Movi");
		$this->assertEquals($boleto->SaldoTarjeta(), 5.2);
		$this->assertEquals($boleto->IDTarjeta(), 0);
		$this->assertEquals($boleto->LineaColectivo(), "142 Verde");
		$this->assertEquals($boleto->Abono(), 14.8);
		$this->assertEquals($boleto->PasajeAbonado(), 14.8);
		$this->assertEquals($boleto->PlusAbonados(), 0);
	}
}
