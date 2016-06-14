<?php
class Ext_Base_Debug {
	const IP_TYPE_DESENV = 3;
	
	//Na classe WApplication o valor do status e modificado no servidor de producao.  
	public static $status = true;
	public static $ipType = null;
	
	private static function get_instance_db() {
		return $wpdb;
	}

	public static function get( $variavel, $descricao = null, $cor='red', $fundo= '#EAE6E9' ) {
		if(self::$status) {
			$id = 'debug___' . uniqid();
			$conteudo = print_r($variavel,true);
			
			$h = (strlen($conteudo) <= 400) ? '200px' : '400px';
			
			return '<fieldset style="color: '.$cor.'; border: '.$cor.' 2px solid; background: '.$fundo.'; font-family: Verdana; font-size:12px; text-align:left;">
					<legend><b><font color="'.$cor.'">DEBUG '.$descricao.' &nbsp;&nbsp;&nbsp;| <a href="javascript:void(0);" id="toggler_'.$id.'">View Mode</a> | <a href="javascript:void(0);" id="collapse_'.$id.'">Comprimir</a> | </font></b></legend>
					<div class="debug_main">
						<div class="debug_plain"><pre>'.$conteudo.'</pre></div>
						<textarea class="debug_text" style="display:none; width: 100%; height: '.$h.'">'.$conteudo.'</textarea>
					</div>
				</fieldset>
				<script>
				jQuery(document).ready(function() {
					jQuery("#toggler_'.$id.'").click(function() {
						var fieldset = jQuery(this).parent().parent().parent().parent();
						fieldset.find(".debug_plain").toggle();
						fieldset.find(".debug_text").toggle();
					});
					jQuery("#collapse_'.$id.'").click(function() {
						var fieldset = jQuery(this).parent().parent().parent().parent();
						fieldset.find(".debug_main").toggle();
						if (jQuery("#collapse_'.$id.'").html() == "Expandir") {
							jQuery("#collapse_'.$id.'").html("Comprimir");
						} else {
							jQuery("#collapse_'.$id.'").html("Expandir");
						}
					});
				});
				</script>';
		}
	}

	public static function show($variavel, $descricao = "", $cor="red", $fundo="#EAE6E9") {
		echo self::get($variavel, $descricao, $cor, $fundo);
	}
	
	public static function ajax($variavel) {
		echo print_r($variavel);
	}
	
	public static function ajaxClose($variavel) {
		self::ajax($variavel);
		exit;
	}

	public static function vars() {
		if(self::$status) {
			$cores = array("red","green","blue","orange","pink","purple","teal","silver","gray");
			$fundo = '#EAE6E9';
			$vars = func_get_args();
			foreach ($vars as $i => $var) {
				$cor = $cores[$i];
				echo "<fieldset style='color: $cor; border: $cor 3px solid; background: $fundo; font-family: Verdana; font-size:12px; text-align:left;'>";
				echo "<legend><b><font color='$cor'>DEBUG VAR ".$i."</font></b></legend>";
				echo "<pre>";
				echo htmlentities(print_r($var,true));
				echo "</pre>";
				echo "</fieldset>";
			}
		}
	}
	
	public static function varsClose() {
		$params = func_get_args();
		call_user_func_array('Ext_Base_Debug::vars', $params);
		if(self::$status) {
			exit;
		}
	}

	public static function close($variavel, $descricao = "", $cor="orange", $fundo="#EAE6E9"){
		self::show($variavel,"EXIT ".$descricao,$cor,$fundo);
		if(self::$status) {
			exit;
		}
	}

	public static function modelGet($variavel, $descricao = '', $cor = 'red', $fundo = '#EAE6E9') {
		$vars = array();
		foreach($variavel as $name => $value) {
			if($name[0] != '_') {
				$vars[$name] = $value;
			}
		}
		return self::get($vars, $descricao, $cor, $fundo);
	}

	public static function model($variavel, $descricao = '', $cor = 'red', $fundo = '#EAE6E9') {
		echo self::modelGet($variavel, $descricao, $cor, $fundo);
	}

	public static function modelClose($variavel, $descricao = '', $cor = 'red', $fundo = '#EAE6E9') {
		self::modelShow($variavel, $descricao, $cor, $fundo);
		exit;
	}
	
	public static function sqlGet($descricao = '', $cor='blue', $fundo='#F1F1F1') {
		global $db;
		return self::get($db->getQuery(), 'SQL '. $descricao, $cor, $fundo);
	}

	public static function sql($descricao = '', $cor='blue', $fundo='#F1F1F1') {
		echo self::sqlGet($descricao, $cor, $fundo);
	}
	
	public static function sqlClose($descricao = '', $cor='blue', $fundo='#F1F1F1') {
		self::sql($descricao, $cor, $fundo);
		exit;
	}

	public static function sqlList($cor = 'black', $fundo = '#F1F1F1') {
		$db = self::get_instance_db();
		self::show($db->_sql_list, 'SQL LIST ', $cor, $fundo);
	}
	
	private static function fileWrite($content, $addFileName = null, $formatDate = 'Y-m-d_H-i-s', $addUniqid = true) {
		$path = dirname(__FILE__) . '/debug/';
		$filename = $path . date( $formatDate ) . ($addFileName ? '_' . $addFileName . '_' : '') . ($addUniqid ?  '_' . uniqid() : '') . '.txt';
		$content = (file_exists( $filename ) ? file_get_contents( $filename ) . PHP_EOL : '') . $content;
		file_put_contents( $filename, $content ); 
	}
	
	public static function file($variavel, $varExport = false, $addFileName = null, $formatDate = 'Y-m-d_H-i-s', $addUniqid = true) {
		if($varExport) {
			$content = var_export($variavel, true);
		} else {
			$content = is_string( $variavel ) ? $variavel : print_r($variavel, true);
		}
		
		self::fileWrite( $content, $addFileName, $formatDate, $addUniqid );
	}
	
	public static function fileVars() {
		$content = '';
		
		$vars = func_get_args();
		foreach ($vars as $i => $var) {
			$content .= 'PARAMETRO: ' . $i . "\n";
			$content .= print_r($var, true) . "\n\n";
		}
		
		self::fileWrite($content);
	}
	
	/**
	 * Retorna se o tipo do usuario e o tipo escolhido de acordo com o IP de acesso.
	 * 
	 * @param	string	Tipo do usuario.
	 * 
	 * @return	boolean	Retorna TRUE caso o usuario seja do tipo escolhido.
	 */
	public static function ipType($type) {
		return in_array($_SERVER['REMOTE_ADDR'], self::$ipType[$type]);
	}
}
function x($variavel, $descricao = "", $cor="orange", $fundo="#EAE6E9") {
	Ext_Base_Debug::close($variavel, $descricao, $cor, $fundo);
}
function d($variavel, $descricao = "", $cor="red", $fundo="#EAE6E9") {
	Ext_Base_Debug::show($variavel, $descricao, $cor, $fundo);
}