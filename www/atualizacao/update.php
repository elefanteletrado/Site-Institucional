﻿<?php
$config = file_get_contents(__DIR__.'/../wp-config.php');

preg_match('@[\r\n]+\s*define.*[\'""]DB_HOST[\'""]\s*,\s*[\'""](.+)[\'""]@', $config, $matches);
$host = $matches[1];
preg_match('@[\r\n]+\s*define.*[\'""]DB_USER[\'""]\s*,\s*[\'""](.+)[\'""]@', $config, $matches);
$user = $matches[1];
preg_match('@[\r\n]+\s*define.*[\'""]DB_PASSWORD[\'""]\s*,\s*[\'""](.+)[\'""]@', $config, $matches);
$pass = $matches[1];
preg_match('@[\r\n]+\s*define.*[\'""]DB_NAME[\'""]\s*,\s*[\'""](.+)[\'""]@', $config, $matches);
$database = $matches[1];

$replaces = array(
	'http://www.elefanteletrado.com.br' => 'http://54.207.12.236/redesign',
	'http://localhost/elefanteletrado.com.br/www' => 'http://54.207.12.236/redesign',
	'wordpress@agencianico.com.br' => 'suporte@elefanteletrado.com.br'
);

require 'inc.php';