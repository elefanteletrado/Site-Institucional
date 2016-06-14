<?php
class Ext_Base_Format {
	public static function filename( $nomeDesformat ) {
		$nomeFormat = trim( self::removeAcentos( $nomeDesformat ) );

		$nomeFormat = str_replace( ' ', '_', $nomeFormat );
		$nomeFormat = str_replace( '-', '_', $nomeFormat );
		$nomeFormat = preg_replace( '/[^a-zA-z0-9_.-]/', '', $nomeFormat );
		$nomeFormat = strtolower( $nomeFormat );

		return $nomeFormat;
	}
	
	public static function removeAcentos( $texto ) {
		$texto = preg_replace( '/[áàãâä]/', 'a', $texto );
		$texto = preg_replace( '/[éèêë]/' , 'e', $texto );
		$texto = preg_replace( '/[íìîï]/' , 'i', $texto );
		$texto = preg_replace( '/[óòôõö]/', 'o', $texto );
		$texto = preg_replace( '/[úùûü]/' , 'u', $texto );
		$texto = preg_replace( '/[ñ]/'    , 'n', $texto );
		$texto = preg_replace( '/[ç]/'    , 'c', $texto );
		$texto = preg_replace( '/[ÁÀÃÂÄ]/', 'A', $texto );
		$texto = preg_replace( '/[ÉÈÊË]/' , 'E', $texto );
		$texto = preg_replace( '/[ÍÌÎÏÏ]/', 'I', $texto );
		$texto = preg_replace( '/[ÓÒÔÕÖ]/', 'O', $texto );
		$texto = preg_replace( '/[ÚÙÛÜ]/' , 'U', $texto );
		$texto = preg_replace( '/[Ñ]/'    , 'N', $texto );
		$texto = preg_replace( '/[Ç]/'    , 'C', $texto );
		$texto = preg_replace( '/[Ç]/'    , 'C', $texto );
		$texto = preg_replace( '/[Ç]/'    , 'C', $texto );
		$texto = preg_replace( '/[?²¹º³ª]/', '', $texto );
	
		return addslashes( $texto );
	}
	
	public static function file_extension( $file ) {
		return strtolower( substr( $file, strrpos( $file, '.' ) + 1 ) );
	}
	
	public static function telefone($telefone, $ddd = null) {
		$format = preg_replace('/\\D/', '', $telefone);
		switch(strlen($format)) {
			case 11:
			case 10:
				return '('.substr($format, 0, 2).') '.substr($format, 2, 4).'-'.substr($format, 6);
			case 8:
				$format = substr($format, 0, 4).'-'.substr($format, 4);
				if(!empty($ddd)) {
					return '('.$ddd.') '.$format;
				}
				return $format;
			default:
				if(!empty($ddd) && !empty($telefone)) {
					return '('.$ddd.') '.$telefone;
				}
		}
		return $telefone;
	}
	
	public static function cpf( $cpf ) {
		preg_match( '/(\\d{3})(\\d{3})(\\d{3})(\\d{2})/', $cpf, $matches );
		return $matches[1] . '.' . $matches[2] . '.' . $matches[3] . '-' . $matches[4];
	}
	
	public static function cnpj( $cnpj ) {
		preg_match( '/(\\d{2})(\\d{3})(\\d{3})(\\d{4})(\\d{2})/', $cnpj, $matches );
		return $matches[1] . '.' . $matches[2] . '.' . $matches[3] . '/' . $matches[4] . '-' . $matches[5];
	}
	
	public static function cpf_cnpj( $cpf_cnpj ) {
		return 11 == strlen( $cpf_cnpj ) ? self::cpf( $cpf_cnpj ) : self::cnpj( $cpf_cnpj );
	}
	
	public static function youtube_duracao( $link ) {
		$xml = file_get_contents( 'http://gdata.youtube.com/feeds/api/videos/' . self::youtube_codigo( $link ) );
		$duration = substr( $xml, strpos( $xml, 'seconds=' ) + 9 );
		$duration = substr( $duration, 0, strpos( $duration, "'" ) );
		return date( 'H:i:s', mktime( 0, 0, $duration ));
	}
	
	public static function youtube_codigo( $link ) {
		$arr_url = parse_url( $link );
		parse_str( $arr_url['query'], $query );
		return $query['v'];
	}
	
	public static function youtube_jquery_media( $link ) {
		return 'http://www.youtube.com/v/' . self::youtube_codigo( $link );
	}
	
	public static function youtube_embed_url( $link ) {
		return 'http://www.youtube.com/embed/' . self::youtube_codigo( $link );
	}
	
	public static function youtube_thumb( $link, $hq = false ) {
		if( $hq ) $hq = 'hq';
		return 'http://i2.ytimg.com/vi/' . self::youtube_codigo( $link ) . '/' . $hq . 'default.jpg';
	}
	
	public static function get_mailto( $to, $subject, $body, $bool_esc_attr = true ) {
		$to = str_replace( '+', '%20', urlencode( $to ) );
		$subject = str_replace( '+', '%20', urlencode( $subject ) );
		$body = str_replace( '+', '%20', urlencode( $body ) );
		$return = 'mailto:' . $to . '&subject=' . $subject . '&body=' . $body;
		return $bool_esc_attr ? esc_attr( $return ) : $return;
	}

	public static function brToDate($value) {
		return implode('-', array_reverse(explode('/', $value)));
	}

	public static function dateToBr($value) {
		return implode('/', array_reverse(explode('-', substr($value, 0, 10))));
	}

	public static function moneyBrToDecimal($value) {
		return str_replace(',', '.', str_replace('.', '', $value));
	}

	public static function decimalToMoneyBr($value) {
		return number_format($value, 2, ',', '.');
	}

	public static function filterFields(array &$args, array $fields) {
		$fieldsRemove = array_diff(array_keys($args), $fields);
		foreach ($fieldsRemove as $name) {
			unset($args[$name]);
		}
	}

	public static function extractNumbers($number) {
		return preg_replace('@\D@', '', $number);
	}

	public static function generatePassword($size, $uppercase, $lowercase, $numbers, $symbols) {
		$uc = "ABCDEFGHIJKLMNOPQRSTUVYXWZ";
		$lc = "abcdefghijklmnopqrstuvyxwz";
		$nb = "0123456789";
		$sb = "!@#$%¨&*()_+=";

		$password = '';
		if($uppercase) {
			$password .= str_shuffle($uc);
		}
		if($lowercase) {
			$password .= str_shuffle($lc);
		}
		if ($numbers) {
			$password .= str_shuffle($nb);
		}
		if($symbols) {
			$password .= str_shuffle($sb);
		}

		return substr(str_shuffle($password), 0, $size);
	}
}