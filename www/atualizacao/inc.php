<?php
header('Content-type: text/plain');
/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @since 2.0.5
 *
 * @param mixed $data Value to check to see if was serialized.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized( $data ) {
	// if it isn't a string, it isn't serialized
	if ( ! is_string( $data ) )
		return false;
	$data = trim( $data );
 	if ( 'N;' == $data )
		return true;
	$length = strlen( $data );
	if ( $length < 4 )
		return false;
	if ( ':' !== $data[1] )
		return false;
	$lastc = $data[$length-1];
	if ( ';' !== $lastc && '}' !== $lastc )
		return false;
	$token = $data[0];
	switch ( $token ) {
		case 's' :
			if ( '"' !== $data[$length-2] )
				return false;
		case 'a' :
		case 'O' :
			return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		case 'b' :
		case 'i' :
		case 'd' :
			return (bool) preg_match( "/^{$token}:[0-9.E-]+;\$/", $data );
	}
	return false;
}

function rSubs(&$data, $find, $replace) {
	if(is_array($data) || is_object($data)) {
		foreach($data as &$item) {
			if(is_string($item)) {
				$item = str_replace($find, $replace, $item);
			} else if(is_array($item) || is_object($item)) {
				rSubs($item, $find, $replace);
			}
		}
	} else if(is_string($data)) {
		$data = str_replace($find, $replace, $data);
	}
}

/**
 * Unserialize value only if it was serialized.
 *
 * @since 2.0.0
 *
 * @param string $original Maybe unserialized original, if is needed.
 * @return mixed Unserialized data can be any type.
 */
function maybe_unserialize( $original ) {
	if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
		return @unserialize( $original );
	return $original;
}

/**
 * Serialize data, if needed.
 *
 * @since 2.0.5
 *
 * @param mixed $data Data that might be serialized.
 * @return mixed A scalar data
 */
function maybe_serialize( $data ) {
	if ( is_array( $data ) || is_object( $data ) )
		return serialize( $data );

	// Double serialization is required for backward compatibility.
	// See http://core.trac.wordpress.org/ticket/12930
	if ( is_serialized( $data ) )
		return serialize( $data );

	return $data;
}
try {
	//echo "mysql:dbname=$database;host=$host;charset=UTF-8, $user, $pass \n";
	$dbh = new PDO("mysql:dbname=$database;host=$host", $user, $pass);
} catch (PDOException $e) {
	exit('Connection failed: ' . $e->getMessage());
}
$tables = array('wp_options');
foreach($tables as $table) {
	$sth = $dbh->prepare("SELECT * FROM $table");
	$sth->execute();
	$rows = $sth->fetchAll(PDO::FETCH_CLASS, 'stdClass');
	foreach($rows as $row) {
		$data = maybe_unserialize(utf8_encode($row->option_value));
		rSubs($data, $from, $to);
		if(strpos($row->option_value, $from)) {
			$result = utf8_decode(serialize($data));
			//echo "$row->option_value\n\n\n";
			//echo "$result\n\n\n";
		} else {
			$result = str_replace($from, $to, $row->option_value);
		}
		if($result && $result != $row->option_value/* && $row->option_id != 242*/) {
			$sth = $dbh->prepare("UPDATE $table SET option_value = '" . $result . "' WHERE option_id = $row->option_id");
			$sth->execute();
		}
	}
}

$tables = array('wp_posts');
foreach($tables as $table) {
	$sth = $dbh->prepare("UPDATE $table
		SET
			post_title = REPLACE(post_title, '$from', '$to'),
			post_content = REPLACE(post_content, '$from', '$to'),
			guid = REPLACE(guid, '$from', '$to');");
	$sth->execute();
}
$tables = array('wp_postmeta');
foreach($tables as $table) {
	$sth = $dbh->prepare("UPDATE $table
		SET
			meta_value = REPLACE(meta_value, '$from', '$to');");
	$sth->execute();
}

echo 'Banco de dados atualizado!';
