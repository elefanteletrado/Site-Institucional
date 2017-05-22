<?php
class Debug {
	public static $status = true;
	private static $_position = 0;

	private function __construct() {}

	public static function get($var, $description = null, $color = null, $background = null, $backtrace = 1) {
		if(null === $description) {
			$description = '';
		}
		if(null === $color) {
			$color = 'red';
		}
		if(null === $background) {
			$background = '#EAE6E9';
		}
		if(null === $backtrace) {
			$backtrace = 1;
		}
		if(self::$status) {
			$arrBacktrace = debug_backtrace();
			$file = str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', realpath($arrBacktrace[$backtrace]['file']));

			$id = "debug___".uniqid().'_'.(++self::$_position);
			$conteudo = htmlentities(print_r($var, true));
			$h = (strlen($conteudo) <= 400) ? "200px" : "400px";

			return '<fieldset style="color: '.$color.'; border: '.$color.' 2px solid; background: '.$background.'; font-family: Verdana; font-size:12px; text-align:left;">
					<legend>
						<b>
							<font color="'.$color.'">
								DEBUG '.$description . ' ' . $file . (isset($arrBacktrace[$backtrace + 1]['class']) ? '|' . $arrBacktrace[$backtrace + 1]['class'] : '') . ": {$arrBacktrace[$backtrace]['line']}" .' &nbsp;&nbsp;&nbsp;| 
								<a href="javascript:void(0);" id="toggler_'.$id.'" onclick="toggler_'.$id.'();">View Mode</a> | 
								<a href="javascript:void(0);" id="collapse_'.$id.'" onclick="collapse_'.$id.'();">Comprimir</a> | 
							</font>
						</b>
					</legend>
					<div class="debug_main" id="debug_main'.$id.'" style="text-transform: none;">
						<div class="debug_plain" id="debug_plain'.$id.'"><pre>'.$conteudo.'</pre></div>
						<textarea class="debug_text"  id="debug_text'.$id.'" style="display:none; width: 100%; height: '.$h.'">'.$conteudo.'</textarea>
					</div>
				</fieldset>
				<script>
				function toggler_'.$id.'() {
					if("block" == document.getElementById("debug_text'.$id.'").style.display) {
						document.getElementById("debug_plain'.$id.'").style.display = "block";
						document.getElementById("debug_text'.$id.'").style.display = "none";
					} else {
						document.getElementById("debug_plain'.$id.'").style.display = "none";
						document.getElementById("debug_text'.$id.'").style.display = "block";
					}
				}
				function collapse_'.$id.'() {
					if("Comprimir" == document.getElementById("collapse_'.$id.'").innerHTML) {
						document.getElementById("debug_plain'.$id.'").style.display = "none";
						document.getElementById("collapse_'.$id.'").innerHTML = "Expandir";
					} else {
						document.getElementById("debug_plain'.$id.'").style.display = "block";
						document.getElementById("collapse_'.$id.'").innerHTML = "Comprimir";
					}
				} 
				</script>';
		}
	}

	public static function show($var, $description = null, $color = null, $background = null, $backtrace = 1) {
		echo self::get($var, $description, $color, $background, $backtrace);
	}

	public static function ajax($var) {
		echo print_r($var);
	}

	public static function ajaxClose($var) {
		self::ajax($var);
		exit;
	}

	public static function varsByArray($vars, $backtrace = 1) {
		if(self::$status) {
			$arrBacktrace = debug_backtrace();
			$file = str_replace($_SERVER['DOCUMENT_ROOT'], '', $arrBacktrace[$backtrace]['file']);
			$colors = array("red","green","blue","orange","pink","purple","teal","silver","gray");
			$color = 'gray';
			$background = '#FFF';
			echo "<fieldset style='color: $color; border: $color 3px solid; background: $background; font-family: Verdana; font-size:12px; text-align:left;'>",
			"<legend><b><font color='$color'>{$file}: {$arrBacktrace[$backtrace]['line']}</font></b></legend>";
			foreach ($vars as $i => $var) {
				$color = $colors[$i];
				echo "<fieldset style='color: $color; border: $color 3px solid; background: $background; font-family: Verdana; font-size:12px; text-align:left;'>",
					"<legend><b><font color='$color'>DEBUG VAR ".$i."</font></b></legend>",
				"<pre>",
				htmlentities(print_r($var,true)),
				"</pre>",
				"</fieldset>";
			}
			echo "</fieldset>";
		}
	}

	public static function vars() {
		if(self::$status) {
			self::varsByArray(func_get_args(), 2);
		}
	}

	public static function varsClose() {
		if(self::$status) {
			self::varsByArray(func_get_args(), 2);
			exit;
		}
	}

	public static function close($var, $description = null, $color = null, $background = null, $backtrace = 1) {
		if(null === $description) {
			$description = null;
		}
		if(null === $color) {
			$color = 'blue';
		}
		if(null === $background) {
			$background = '#EAE6E9';
		}
		if(self::$status) {
			self::show($var, 'EXIT ' . $description, $color, $background, ++$backtrace);
			exit;
		}
	}

	public static function sqlGet($description = null, $color = null, $background = null, $backtrace = 1) {
		if(null === $color) {
			$color = 'blue';
		}
		if(null === $background) {
			$background = '#F1F1F1';
		}
		return self::get(Database::instance('default')->last_query, 'SQL ' . $description, $color, $background, ++$backtrace);
	}

	public static function sql($description = null, $color = null, $background = null, $backtrace = 1) {
		echo self::sqlGet($description, $color, $background, ++$backtrace);
	}

	public static function sqlClose($description = null, $color = null, $background = null, $backtrace = 1) {
		self::sql($description, $color, $background, ++$backtrace);
		exit;
	}

	private static function fileWrite($content) {
		if(!file_exists(APPPATH . '/debug') || !is_dir(APPPATH . '/debug')) {
			mkdir(APPPATH . '/debug');
		}
		file_put_contents(APPPATH . '/debug/' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.txt', $content);
	}

	public static function file($var) {
		$content = print_r($var, true);

		self::fileWrite($content);
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

    public static function shortTrace($description = null, $color = null, $background = null, $backtrace = 0) {
        if(null === $description) {
            $description = '';
        }
        if(null === $color) {
            $color = 'red';
        }
        if(null === $background) {
            $background = '#EAE6E9';
        }
        if(null === $backtrace) {
            $backtrace = 1;
        }
        if(self::$status) {
            $arrBacktrace = debug_backtrace();

            $id = "debug___".uniqid().'_'.(++self::$_position);
            $contentPlain = '';
            $contentHtml = '<ol>';
            $arrBacktraceLength = count($arrBacktrace);
            for ($i = $backtrace; $i < $arrBacktraceLength; $i++) {
                $file = str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', realpath($arrBacktrace[$i]['file']));
                $contentLine = $file . (isset($arrBacktrace[$i + 1]['class']) ? '|' . $arrBacktrace[$i + 1]['class'] : '') . ": {$arrBacktrace[$i]['line']}" . PHP_EOL;
                $contentPlain .= $contentLine;
                $contentHtml .= '<li>'.$contentLine.'</li>';
            }
            $contentHtml .= '</ol>';
            $h = (strlen($contentPlain) <= 400) ? "200px" : "400px";

            echo '<fieldset style="color: '.$color.'; border: '.$color.' 2px solid; background: '.$background.'; font-family: Verdana; font-size:12px; text-align:left;">
				<legend>
					<b>
						<font color="'.$color.'">
							DEBUG '.$description . ' &nbsp;&nbsp;&nbsp;| 
							<a href="javascript:void(0);" id="toggler_'.$id.'" onclick="toggler_'.$id.'();">View Mode</a> | 
							<a href="javascript:void(0);" id="collapse_'.$id.'" onclick="collapse_'.$id.'();">Comprimir</a> | 
						</font>
					</b>
				</legend>
				<div class="debug_main" id="debug_main'.$id.'" style="text-transform: none;">
					<div class="debug_plain" id="debug_plain'.$id.'">'.$contentHtml.'</div>
					<textarea class="debug_text"  id="debug_text'.$id.'" style="display:none; width: 100%; height: '.$h.'">'.$contentPlain.'</textarea>
				</div>
			</fieldset>
			<script>
			function toggler_'.$id.'() {
				if("block" == document.getElementById("debug_text'.$id.'").style.display) {
					document.getElementById("debug_plain'.$id.'").style.display = "block";
					document.getElementById("debug_text'.$id.'").style.display = "none";
				} else {
					document.getElementById("debug_plain'.$id.'").style.display = "none";
					document.getElementById("debug_text'.$id.'").style.display = "block";
				}
			}
			function collapse_'.$id.'() {
				if("Comprimir" == document.getElementById("collapse_'.$id.'").innerHTML) {
					document.getElementById("debug_plain'.$id.'").style.display = "none";
					document.getElementById("collapse_'.$id.'").innerHTML = "Expandir";
				} else {
					document.getElementById("debug_plain'.$id.'").style.display = "block";
					document.getElementById("collapse_'.$id.'").innerHTML = "Comprimir";
				}
			} 
			</script>';
        }
    }

    public static function shortTraceClose($description = null, $color = null, $background = null, $backtrace = 0) {
        if(null === $description) {
            $description = null;
        }
        if(null === $color) {
            $color = 'blue';
        }
        if(null === $background) {
            $background = '#EAE6E9';
        }
        if(self::$status) {
            self::shortTrace('EXIT ' . $description, $color, $background, ++$backtrace);
            exit;
        }
    }
}

function d($var, $description = null, $color = null, $background = null, $backtrace = 1) {
    Debug::show($var, $description, $color, $background, $backtrace);
}
function x($var, $description = null, $color = null, $background = null, $backtrace = 1) {
    Debug::close($var, $description, $color, $background, $backtrace + 1);
}
function st($description = null, $color = null, $background = null, $backtrace = 0) {
    Debug::shortTrace($description, $color, $background, $backtrace);
}
function stx($description = null, $color = null, $background = null, $backtrace = 0) {
    Debug::shortTraceClose($description, $color, $background, $backtrace);
}
function v() {
    if(Debug::$status) {
        Debug::varsByArray(func_get_args(), 2);
    }
}

function vx() {
    if(Debug::$status) {
        Debug::varsByArray(func_get_args(), 1);
        exit;
    }
}