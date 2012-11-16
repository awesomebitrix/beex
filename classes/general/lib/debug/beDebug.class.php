<?php

class beDebug {

	public static function dump($value) {

		echo '<pre style="font-size: 12px; font-family: monospace">';
		print_r($value);
		echo '</pre>';
		
	}
	
}