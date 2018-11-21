<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class TarjetaTest extends TestCase {

    /**
     * Comprueba que la tarjeta aumenta su saldo cuando se carga saldo válido.
     */
    public function testCargaSaldo() {
    	$tiempoReal = new Tiempo;
        $tarjeta = new Tarjeta($tiempoReal);

        $this->assertTrue($tarjeta->recargar(10));
        $this->assertEquals($tarjeta->obtener_saldo(), 10);

        $this->assertTrue($tarjeta->recargar(20));
        $this->assertEquals($tarjeta->obtener_saldo(), 30);
	
	$this->assertTrue($tarjeta->recargar(30));
	$this->assertEquals($tarjeta->obtener_saldo(), 60);

	$this->assertTrue($tarjeta->recargar(50));
	$this->assertEquals($tarjeta->obtener_saldo(), 110);

	$this->assertTrue($tarjeta->recargar(100));
	$this->assertEquals($tarjeta->obtener_saldo(), 210);

	$this->assertTrue($tarjeta->recargar(510.15));
	$this->assertEquals($tarjeta->obtener_saldo(), 802.08);

	$this->assertTrue($tarjeta->recargar(962.59));
	$this->assertEquals($tarjeta->obtener_saldo(), 1986.25);
    }

    /**
     * Comprueba que la tarjeta no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido() {
    	$tiempoReal = new Tiempo;
      $tarjeta = new Tarjeta($tiempoReal);

      $this->assertFalse($tarjeta->recargar(15));
      $this->assertEquals($tarjeta->obtener_saldo(), 0);
  }
	 /**
     * Comprueba que el abono del pasaje es satisfactorio.
     */
	public function testAbonoTarjeta() {
		$tiempoReal = new Tiempo;
		$colectivo = new Colectivo();
		$tarjeta = new Tarjeta($tiempoReal);
		$tarjeta->recargar(20);
		$tarjeta->abonar_pasaje($colectivo);
		$this->assertEquals($tarjeta->valor_del_pasaje(),14.8);
		$this->assertEquals($tarjeta->obtener_saldo(), 5.2);
		$tarjeta->abonar_pasaje($colectivo); //Primer Viaje plus
		$tarjeta->abonar_pasaje($colectivo); //Segundo Viaje plus
		$this->assertFalse($tarjeta->abonar_pasaje($colectivo)); //Compruebo que no se puede viajar sin saldo
	}

	public function testRecargaPlus() {
		$tiempoReal = new Tiempo;
		$tarjeta = new Tarjeta($tiempoReal);
		$colectivo = new Colectivo();
		$tarjeta->abonar_pasaje($colectivo);
		$tarjeta->abonar_pasaje($colectivo);
		$tarjeta->recargar(50);
		$tarjeta->abonar_pasaje($colectivo);
		$this->assertEquals($tarjeta->obtener_saldo(), 5.6); //Abono 2 plus + pasaje = 44.4
	}

	public function testTrasbordo() {
		$tiempoFalso = new TiempoFalso;
		$tarjeta = new Tarjeta($tiempoFalso);
		$tarjeta->recargar(50);
		$colectivo1 = new Colectivo("Semtur","Azul","102");
		$this->assertTrue($colectivo1->pagar_con($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtener_saldo(), 35.2);
		$tiempoFalso -> avanzar(600);
		$colectivo2 = new Colectivo("Semtur","Amarillo","145");
		$this->assertTrue($colectivo2->pagar_con($tarjeta) instanceof Boleto);
		$this->assertEquals($tarjeta->obtener_saldo(), 30.267);
	}

	public function testTiempoSesentaMin(){
		$tiempo = new TiempoFalso;
		$tarjeta = new Tarjeta($tiempo);
		$tiempo->avanzar(1538072993); //Jueves 30/9/2018 a las 18:29:53
		$tarjeta->recargar(50);
		$colectivo1 = new Colectivo("Semtur","Azul","102");
		$colectivo2 = new Colectivo("Semtur","Amarillo","145");
		$colectivo1->pagar_con($tarjeta);
		$this->assertEquals($tarjeta->obtener_saldo(), 35.2);
		$tiempo->avanzar(3000);//Adelanto 3000 seg para trasbordo
		$this->assertTrue($tarjeta->check_hora());
		$colectivo2->pagar_con($tarjeta);
		$this->assertEquals($tarjeta->obtener_saldo(), 30.267);
	}
	
	public function testTiempoNoventaMin(){
		$tiempo = new TiempoFalso;
		$tarjeta = new Tarjeta($tiempo);
		$tiempo->avanzar(1538245793); //Sabado 2/10/2018 a las 18:29:53
		$tarjeta->recargar(50);
		$colectivo1 = new Colectivo("Semtur","Azul","102");
		$colectivo2 = new Colectivo("Semtur","Amarillo","145");
		$colectivo1->pagar_con($tarjeta);
		$this->assertEquals($tarjeta->obtener_saldo(), 35.2);
		$tiempo->avanzar(3000);//Adelanto 3000 seg para trasbordo
		$this->assertTrue($tarjeta->check_hora());
		$colectivo2->pagar_con($tarjeta);
		$this->assertEquals($tarjeta->obtener_saldo(), 30.267);
	}
}
