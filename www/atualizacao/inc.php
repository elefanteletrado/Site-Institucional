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
	// don't attempt to unserialize data that wasn't serialized going in
	if ( is_serialized( $original ) ) {
		$return = @unserialize( $original );
		if ($return) {
			return $return;
		}
		
		$originalBkp = $original;
		preg_match_all('@s:\d+:(""|"[^\\\\]"|".+?[^\\\\]");@s', $original, $matches);
		foreach($matches[0] as $match) {
			preg_match('@(s:)(\d+)(:")(.*)(";)@s', $match, $matchesItem);
			unset($matchesItem[0]);
			$matchesItem[2] = strlen($matchesItem[4]);
			$original = str_replace($match, implode('', $matchesItem), $original);
		}
		$return = @unserialize( $original );
		if (!$return && $original != 'a:0:{}') {
			throw new Exception('ERROR UNSERIALIZE');
		}
	}
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

function wpReplaceIterable($params, $from, $to, $removeNotUpdated = false) {
	$updated = false;
	if ($params) {
		foreach($params as $name => &$value) {
			$old = $value;
			$value = str_replace($from, $to, $value);

			if($old != $value) {
				$updated = true;
			} else if($removeNotUpdated) {
				if(is_object($params)) {
					unset($params->$name);
				} else {
					unset($params[$name]);
				}
			}
		}
		unset($value);
	}

	if($updated) {
		return $params;
	}

	return null;
}

foreach($replaces as $from => $to) {
	echo "FROM $from TO $to".PHP_EOL.PHP_EOL.PHP_EOL;

	$table = $tablePrefix . 'revslider_slides';
	$sth = $dbh->prepare("SELECT * FROM $table");
	$sth->execute();
	$rows = $sth->fetchAll(PDO::FETCH_CLASS, 'stdClass');
	foreach($rows as $row) {
		$bind = array();

		$params = wpReplaceIterable(json_decode($row->params), $from, $to);
		if($params) {
			$bind['params'] = json_encode($params);
		}

		$layers = json_decode($row->layers);
		if(is_object($layers)) {
			$layers = wpReplaceIterable($layers, $from, $to);
			if($layers) {
				$bind['layers'] = json_encode($layers);
			}
		} else if(is_array($layers)) {
			$updated = false;
			foreach($layers as $pos => $layer) {
				$layer = wpReplaceIterable($layer, $from, $to);
				if($layer) {
					$updated = true;
					$layers[$pos] = $layer;
				}
			}
			if($updated) {
				$bind['layers'] = json_encode($layers);
			}
		}
		if($bind) {
			$sets = array();
			foreach(array_keys($bind) as $name) {
				$sets[] = "{$name} = :{$name}";
			}
			$bind['id'] = $row->id;
			$sth = $dbh->prepare("UPDATE $table SET ".implode(', ', $sets)." WHERE id = :id");
			$sth->execute($bind);

			echo "Table: $table id: {$bind['id']}" . PHP_EOL;
		}
	}

	$tables = array($tablePrefix . 'options');
	foreach($tables as $table) {
		$sth = $dbh->prepare("SELECT * FROM $table");
		$sth->execute();
		$rows = $sth->fetchAll(PDO::FETCH_CLASS, 'stdClass');
		foreach($rows as $row) {
			$data = maybe_unserialize(utf8_encode($row->option_value));
			rSubs($data, $from, $to);
			if(strpos($row->option_value, $from)) {
				$result = utf8_decode(serialize($data));
			} else {
				$result = str_replace($from, $to, $row->option_value);
			}
			if($result && $result != $row->option_value) {
				$sql = "UPDATE $table SET option_value = :option_value WHERE option_id = :option_id";
				$bind = array('option_value' => $result, 'option_id' => $row->option_id);
				$sth = $dbh->prepare($sql);
				$sth->execute($bind);

				echo "Table: $table option_id: {$bind['option_id']}" . PHP_EOL;
			}
		}
	}

	$tables = array($tablePrefix . 'posts');
	foreach($tables as $table) {
		$sth = $dbh->prepare("SELECT * FROM $table");
		$sth->execute();
		$rows = $sth->fetchAll(PDO::FETCH_CLASS, 'stdClass');
		foreach($rows as $row) {
			$id = $row->ID;
			$return = wpReplaceIterable($row, $from, $to, true);
			if($return) {
				$row = get_object_vars($row);
				$sets = array();
				foreach($row as $name => $value) {	
					$sets[] = "{$name} = :{$name}";
				}
				$row['ID'] = $id;
				$sql = "UPDATE $table SET ".implode(', ', $sets)." WHERE id = :ID";
				$sth = $dbh->prepare($sql);
				$sth->execute($row);
			}
		}
	}

	$tables = array($tablePrefix . 'postmeta');
	foreach($tables as $table) {
		$sth = $dbh->prepare("SELECT * FROM $table");
		$sth->execute();
		$rows = $sth->fetchAll(PDO::FETCH_CLASS, 'stdClass');
		foreach($rows as $row) {
			$data = maybe_unserialize($row->meta_value);
			rSubs($data, $from, $to);
			$dataBkp = $data;
			if(strpos($row->meta_value, $from)) {
				$result = utf8_decode(serialize($data));
			} else {
				$result = str_replace($from, $to, $row->meta_value);
			}
			if($result && $result != $row->meta_value) {
				$sql = "UPDATE $table SET meta_value = :meta_value WHERE meta_id = :meta_id";
				$bind = array('meta_value' => $result, 'meta_id' => $row->meta_id);
				$sth = $dbh->prepare($sql);
				$sth->execute($bind);

				echo "Table: $table meta_id: {$bind['meta_id']}" . PHP_EOL;
			}
		}
	}
}
echo 'Banco de dados atualizado!';