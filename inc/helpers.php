<?php
/**
 * Feature Name: Some Helpers
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

if ( ! function_exists( 'array_insert' ) ) {
	/**
	 * This little helper function inserts an array to an array
	 * on a specific position
	 *
	 * @param	array $array
	 * @param	string $key
	 * @param	array $insert
	 * @param	boolean $before adds the array before the key
	 * @return	array
	 */
	function array_insert( $array, $key, $insert, $before = FALSE ) {

		$index = array_search( $key, array_keys( $array ) );
		if ( $index === FALSE ){
			$index = count( $array );
		} else {
			if ( ! $before )
				$index++;
		}

		$end = array_splice( $array, $index );
		return array_merge( $array, $insert, $end );
	}
}