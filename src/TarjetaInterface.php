<?php

namespace TrabajoTarjeta;

interface TarjetaInterface {

	/**
	 * Recarga una tarjeta con un cierto valor de dinero.
	 *
	 * @param float $monto
	 *
	 * @return bool
	 *   Devuelve TRUE si el monto a cargar es válido, o FALSE en caso de que no
	 *   sea valido.
	 */
	public function recargar(float $monto);

	/**
	 * Devuelve el saldo que le queda a la tarjeta.
	 *
	 * @return float
	 */
	public function obtener_saldo();

	/**
	 * Devuelve la cantidad de plus que le queda a la tarjeta.
	 *
	 * @return int
	 */
	public function obtener_plus();

	/**
	 * Retira el valor del pasaje de la tarjeta, asi como abonar los plus necesarios
	 * y evaluar si se puede pagar trasbordo.
	 *
	 * @param ColectivoInterface $colectivo
	 *
	 * @return bool
	 * Devuelve true si el abono fue satisfactorio y false en caso contrario
	 */
	public function abonar_pasaje(ColectivoInterface $colectivo);

	/**
	 * Comprueba que el argumento monto sea válido como recarga
	 *
	 * @param float $monto
	 *
	 * @return bool
	 *   Devuelve TRUE si el monto a cargar es válido, o FALSE en caso de que no
	 *   sea valido.
	 */
	public function monto_valido(float $monto);

	/**
	 * Abona el trasbordo (1/3 del boleto).
	 *
	 * @param ColectivoInterface $colectivo
	 *
	 * @return bool
	 *   Devuelve siempre true, ya que evaluar_trasbordo analiza
	 *   previamente si se puede abonar o no el pasaje.
	 */
	public function abonar_trasbordo(ColectivoInterface $colectivo);

	/**
	 * Evalua si es posible abonar el trasbordo 
	 *
	 * @param ColectivoInterface $colectivo
	 *
	 * @return bool
	 *   Comprueba si es posible abonar el trasbordo.
	 */
	public function evaluar_trasbordo(ColectivoInterface $colectivo);

	/**
	 * Comprueba que los colectivos sean distintos para el trasbordo
	 *
	 * @param ColectivoInterface $colectivo
	 *
	 * @return bool
	 */
	public function comparar_bus(ColectivoInterface $colectivo);

	/**
	 * Comprueba si el intervalo posible para trasbordo serán 90 o 60 minutos
	 *
	 * @return bool
	 *   Devuelve true si el intervalo será de 90 minutos, false en otro caso
	 */
	public function intervalo_trasbordo();

	/**
	 * Comprueba si el intervalo del tiempo entre el ultimo pasaje y el actual
	 * permite pagar un pasaje tipo trasbordo
	 *
	 * @return bool
	 */
	public function check_hora();

	/**
	 * Devuelve el valor del pasaje
	 *
	 * @return float
	 */
	public function valor_del_pasaje();

	/**
	 * Devuelve el tipo de tarjeta.
	 *
	 * @return string
	 */
	public function tipo_tarjeta();

	/**
	 * Calcula la el monto y la cantidad de plus abonados
	 *
	 * @param float $total, float $valor
	 *
	 * @return null
	 */
	public function calculo_abono_total(float $total, float $valor);

	/**
	 * Devuelve el ultimo abono
	 *
	 * @return float
	 */
	public function ult_abono();

	/**
	 * Devuelve la cantidad de plus abonados en el ultimo viaje
	 *
	 * @return int
	 */
	public function ult_cant_plus();

	/**
	 * Devuelve el valor del pasaje abonado, no el total (sin plus)
	 *
	 * @return float
	 */
	public function ult_pasaje_abonado();

	/**
	 * Devuelve la ID de la tarjeta
	 *
	 * @return int
	 */
	public function get_id();

	/**
	 * Devuelve la hora del ultimo viaje.
	 *
	 * @return int
	 */
	public function get_hora();

	/**
	 * Guarda los valores del colectivo en el cual se viaja
	 * para poder analizar la posibilidad del trasbordo.
	 *
	 * @param ColectivoInterface $colectivo
	 *
	 * @return null
	 */
	public function nuevo_colectivo(ColectivoInterface $colectivo);
}
