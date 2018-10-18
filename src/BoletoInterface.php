<?php

namespace TrabajoTarjeta;

interface BoletoInterface {

	/**
	 * Devuelve el objeto colectivo correspondiente al boleto
	 *
	 * @return 
	 */
	public function obtener_colectivo();

	/**
	 * Devuelve la fecha del boleto
	 *
	 * @return 
	 */
	public function fecha();

	/**
	 * Devuelve el tipo de tarjeta que abono el boleto
	 *
	 * @return 
	 */
	public function tipo_tarjeta();

	/**
	 * Devuelve el saldo restante de la tarjeta que abono el boleto
	 *
	 * @return 
	 */
	public function saldo_tarjeta();

	/**
	 * Devuelve la id de la tarjeta que abono el boleto
	 *
	 * @return 
	 */
	public function id_tarjeta();

	/**
	 * Devuelve la linea del colectivo donde se abono el boleto
	 *
	 * @return 
	 */
	public function linea_colectivo();

	/**
	 * Devuelve el abono total del boleto
	 *
	 * @return 
	 */
	public function abono();

	/**
	 * Devuelve la cantidad de plus abonados
	 *
	 * @return 
	 */
	public function plus_abonados();

	/**
	 * Devuelve el valor del pasaje
	 *
	 * @return 
	 */
	public function pasaje_abonado();
}
