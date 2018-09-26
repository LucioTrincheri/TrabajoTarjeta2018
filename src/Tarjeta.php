<?php

namespace TrabajoTarjeta;

class Tarjeta implements TarjetaInterface {

    	protected $saldo=0;
	protected $plus=2;
	protected $valorPasaje = 14.8;
	protected $puedeTrasb = False;
	protected $horaViaje = 0;
	protected $tipo = "Movi";
	protected $ultViajePlus=0;
	protected $ultimoAbono=0;
	protected $ultPasaje=0;
	protected $ID=0;

	protected $lineaAnterior = "Inicializacion";
	protected $numeroAnterior = "Inicializacion";

	public function __construct(TiempoInterface $tiempo, $id=0)
	{
		$this->tiempo = $tiempo;
		$this->ID = $id;
	}
	
		
    public function recargar($monto) {
    	if ($monto == 10 || $monto == 20 || $monto == 30 || $monto == 50 || $monto == 100 || $monto == 510.15 || $monto == 962.59) {

			if($monto == 510.15) {
				$this->saldo += 81.93;
			}

			if($monto == 962.59) {
				$this->saldo += 221.58;
			}

        	$this->saldo += $monto;
			return True;
		}
		return False;
    }

    public function obtenerSaldo() {
		return $this->saldo;
    }

	public function obtenerPlus() {
		return $this->plus;
    }

//comienzo trasbordo y métodos derivados --------- --------- --------- --------- --------- --------- --------- --------- --------- ---------
	public function abonarTrasbordo($colectivo)
	{
		$valor = (round(($this->valorPasaje / 3),3) + abs($this->plus - 2) * $this->valorPasaje);
		$this->saldo -= $valor;
		$this->horaViaje = $this->tiempo->time();
		$this->puedeTrasb = False;
		$this->plus = 2;
		$this->CalculoAbonoTotal($valor , round(($this->valorPasaje / 3),3));
		$this->NuevoColectivo($colectivo);
		return True;
	}

	public function evaluarTrasbordo($colectivo)
	{
		$saldoSuf = (round(($this->valorPasaje / 3),3) + abs($this->plus - 2) * $this->valorPasaje) < $this->saldo;
		return ($this->compararBus($colectivo) && $this->checkHora() && $this->puedeTrasb && $saldoSuf);
	}
	
	public function compararBus($colectivo)
	{	
		return (($this->lineaAnterior != $colectivo->linea()) || ($this->numeroAnterior != $colectivo->numero()));
	}
	
	public function checkHora()
	{
		#falta hacer que los tiempos sean correspondientes según en dia.
		
		if(($this->tiempo->time() - $this->horaViaje) <= 3600)
		{
			return True;
		}
	}
	
//fin trasbordo y métodos derivados --------- --------- --------- --------- --------- --------- --------- --------- --------- ---------
	public function abonarPasaje(ColectivoInterface $colectivo){
	
		if($this->evaluarTrasbordo($colectivo)){return $this->abonarTrasbordo($colectivo);}
		
		if($this->saldo >= ($this->valorPasaje * (1 + abs($this->plus - 2))))
		{
			$this->saldo -= ($this->valorPasaje * (1 + abs($this->plus - 2)));
			$this->horaViaje = $this->tiempo->time();
			$this->plus = 2;
			$this->puedeTrasb = True;
			$this->CalculoAbonoTotal(($this->valorPasaje * (1 + abs($this->plus - 2))), $this->valorPasaje);
			$this->NuevoColectivo($colectivo);
			return True;
		}else if($this->plus > 0){
			$this->plus -= 1;
			$this->horaViaje = $this->tiempo->time();
			$this->puedeTrasb = True;
			$this->CalculoAbonoTotal(0, 0);
			$this->NuevoColectivo($colectivo);
			return True;
		}
		return False;
	}

	public function valorDelPasaje(){
		return $this->valorPasaje;
	}

	public function tipoTarjeta(){
		return $this->tipo;
	}
	
	public function CalculoAbonoTotal($total , $valor){
		if($total == 0){
			$this->ultimoAbono=0;
			$this->ultViajePlus=1;
			return NULL;
		}
		$this->ultimoAbono = $total;
		$this->ultViajePlus = round(($total - $valor) / $this->valorPasaje);
		$this->ultPasaje = $valor;
	}

	public function ultAbono(){
		return $this->ultimoAbono;
	}

	public function ultCantPlus(){
		return $this->ultViajePlus;
	}
	
	public function ultPasajeAbonado(){
		return $this->ultPasaje;
	}

	public function getID(){
		return $this->ID;
	}

	public function getHora(){
		return $this->horaViaje;
	}

	public function NuevoColectivo($colectivo){
		$this->lineaAnterior = $colectivo->linea();
		$this->numeroAnterior = $colectivo->numero();
	}
}
