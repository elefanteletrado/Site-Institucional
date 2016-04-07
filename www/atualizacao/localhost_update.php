<?php
$homologUrl = 'http://internethomolog.meta.com.br:8080/hoepers/portal/atualizacao/dump.php';
$homologUser = 'hoepers';
$homologPass = 'hoepersmeta2013';

define('DB_NAME', 'cbmtbt_fase2');
define('DB_USER', 'root');
define('DB_PASSWORD', 'onlyoffice');
define('DB_HOST', 'crowdit.cloudapp.net');

$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASSWORD;
$database = DB_NAME;

$from = 'http://cbmtbt:8080';
$to = 'http://cbmtbt.crowdit.com.br';
/*$from = 'http://printset.crowdit.com.br';
$to = 'http://localhost/printset';

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'hoepers_localhost.sql';
$pathBackup = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'hoepers_localhost_backup.sql';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $homologUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$homologUser:$homologPass");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
$out = curl_exec($ch);
if(!$out) {
	exit('Erro. O servidor de homologa��o n�o retornou dados.');
}
file_put_contents($path, $out);
curl_close($ch);
system("mysqldump -h$host -u$user " . ($pass ? "-p$pass " : '') . $database . " > $pathBackup");
if(!@filesize($pathBackup)) {
	exit('Erro ao criar o backup.');
}
system("mysql -h$host -u$user " . ($pass ? "-p$pass " : '') . $database . " < $path");
if(!@filesize($path)) {
	exit('Erro ao criar o dump para migra��o.');
}
*/
require 'inc.php';
