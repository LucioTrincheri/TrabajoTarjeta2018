<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

    /**
     * Devuelve el valor del boleto.
     * (Reemplazado por Abono())
     * @return int
     */
    

    /**
     * Devuelve un objeto que respresenta el colectivo donde se viajó.
     *
     * @return ColectivoInterface
     */
    public function obtenerColectivo();

	public function obtenerTarjeta();

	public function Fecha();

	public function TipoTarjeta();

	public function SaldoTarjeta();

	public function IDTarjeta();

	public function LineaColectivo();

	public function Abono();

	public function PlusAbonados();
}
