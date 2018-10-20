<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

	/**
	 * Devuelve el objeto colectivo correspondiente al boleto
	 *
	 * @return ColectivoInterface
	 */
	public function obtener_colectivo();

	/**
	 * Devuelve la fecha del boleto
	 *
	 * @return int
	 */
	public function fecha();

	/**
	 * Devuelve el tipo de tarjeta que abono el boleto
	 *
	 * @return string
	 */
	public function tipo_tarjeta();

	/**
	 * Devuelve el saldo restante de la tarjeta que abono el boleto
	 *
	 * @return float
	 */
	public function saldo_tarjeta();

	/**
	 * Devuelve la id de la tarjeta que abono el boleto
	 *
	 * @return int
	 */
	public function id_tarjeta();

	/**
	 * Devuelve la linea del colectivo donde se abono el boleto
	 *
	 * @return string
	 */
	public function linea_colectivo();

	/**
	 * Devuelve el abono total del boleto
	 *
	 * @return float
	 */
	public function abono();

	/**
	 * Devuelve la cantidad de plus abonados
	 *
	 * @return int
	 */
	public function plus_abonados();

	/**
	 * Devuelve el valor del pasaje
	 *
	 * @return float
	 */
	public function pasaje_abonado();
}
