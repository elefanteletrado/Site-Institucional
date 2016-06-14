<?php
class Ext_Base_Validate {
	public static function email( $email ) {
		return preg_match( '/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/', $email );
	}
	
	public static function telefone( $telefone ){
		return preg_match( '/^(\(\d{2}\)|\d{2}) ?\d{4,5}-?\d{4}$/', $telefone );
	}
	
	public static function cpf( $cpf ) {
		$cpf = preg_replace( '/\\D/', '', $cpf );

		if( strlen( $cpf ) != 11 || !ctype_digit( $cpf ) ) {
			return false;
		} else {
			if(
				$cpf == '11111111111' || $cpf == '22222222222' ||
			 	$cpf == '33333333333' || $cpf == '44444444444' ||
				$cpf == '55555555555' || $cpf == '66666666666' ||
				$cpf == '77777777777' || $cpf == '88888888888' ||
				$cpf == '99999999999' || $cpf == '00000000000' ) {
				return false;
			} else {
				$dv_informado = substr( $cpf, 9,2 );
	
				for ( $i=0; $i<=8; $i++ ) {
					$digito[$i] = substr( $cpf, $i,1 );
				}
	
				$posicao = 10;
				$soma = 0;
	
				for ( $i=0; $i<=8; $i++ ) {
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				}
	
				$digito[9] = $soma % 11;
	
				$digito[9] = $digito[9] < 2 ? 0 : 11 - $digito[9];
	
				$posicao = 11;
				$soma = 0;
	
				for ( $i=0; $i<=9; $i++ ) {
					$soma = $soma + $digito[$i] * $posicao;
					$posicao = $posicao - 1;
				}
	
				$digito[10] = $soma % 11;
	
				$digito[10] = $digito[10] < 2 ? 0 : 11 - $digito[10];
	
				$dv = $digito[9] * 10 + $digito[10];
	
				if ( $dv != $dv_informado ) {
					return false;
				}
			}
		}
	
		return true;
	}
	
	public static function cnpj( $cnpj ) {
	
		$cnpj = preg_replace( '/\\D/', '', $cnpj );
	
		if( strlen( $cnpj ) != 14 || !ctype_digit( $cnpj ) ) {
			return false;
		} else if(
				$cnpj == '11111111111111' || $cnpj == '22222222222222' ||
			 	$cnpj == '33333333333333' || $cnpj == '44444444444444' ||
				$cnpj == '55555555555555' || $cnpj == '66666666666666' ||
				$cnpj == '77777777777777' || $cnpj == '88888888888888' ||
				$cnpj == '99999999999999' || $cnpj == '00000000000000' ) {
			return false;
		} else {
			$j = 5;
			$k = 6;
			$soma1 = "";
			$soma2 = "";
	
			for ( $i = 0; $i < 13; $i++ ) {
				$j = $j == 1 ? 9 : $j;
				$k = $k == 1 ? 9 : $k;
				$soma2 += ( $cnpj{$i} * $k );
	
				if ( $i < 12 ) {
					$soma1 += ( $cnpj{$i} * $j );
				}
				$k--;
				$j--;
			}
	
			$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
			$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
	
			if ( $cnpj{12} != $digito1 || $cnpj{13} != $digito2 ) {
				return false;
			}
		}
	
		return true;
	}
	
	public static function cpf_cnpj ( $value ) {
		if( ( strlen( $value ) != 14 && strlen( $value ) != 11 ) || ( strlen( $value ) == 11 && !strlen( $value ) ) || ( strlen( $value ) == 14 && !strlen( $value ) ) ) {
			return false;
		}
		return true;
	}
}