//Rotina de validação de Números que iniciam com “7”, “8” ou “9”
<?php 
	function validacns_provisorio($cns) {
		if ((strlen(trim($cns))) != 15) {
			return false;
			}
			$soma = (((substr($cns,0,1)) * 15) +
			((substr($cns,1,1)) * 14) +
			((substr($cns,2,1)) * 13) +
			((substr($cns,3,1)) * 12) +
			((substr($cns,4,1)) * 11) +
			((substr($cns,5,1)) * 10) +
			((substr($cns,6,1)) * 9) +
			((substr($cns,7,1)) * 8) +
			((substr($cns,8,1)) * 7) +
			((substr($cns,9,1)) * 6) +
			((substr($cns,10,1)) * 5) +
			((substr($cns,11,1)) * 4) +
			((substr($cns,12,1)) * 3) +
			((substr($cns,13,1)) * 2) +
			((substr($cns,14,1)) * 1));	
			$resto = fmod($soma,11);
			if ($resto != 0) {
				return false;
			} else {
				return true;
			}
			
	}
?>