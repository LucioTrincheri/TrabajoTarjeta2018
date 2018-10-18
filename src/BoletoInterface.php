<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return ColectivoInterface
	 */
	public function obtener_colectivo();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return int
	 */
	public function fecha();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return string
	 */
	public function tipo_tarjeta();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return float
	 */
	public function saldo_tarjeta();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return int
	 */
	public function id_tarjeta();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return string
	 */
	public function linea_colectivo();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return float
	 */
	public function abono();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return int
	 */
	public function plus_abonados();

	/**
	 * Devuelve un objeto que respresenta el colectivo donde se viajó.
	 *
	 * @return int
	 */
	public function pasaje_abonado();
}
