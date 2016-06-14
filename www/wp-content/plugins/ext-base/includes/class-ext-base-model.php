<?php
/**
 * Model
 *
 * @package		plugins
 * @subpackage	ext-base
 * @author Luiz Felipe Bertoldi de Oliveira
 */
class Ext_Base_Model {
	/**
	 * @var wpdb
	 */
	protected $wpdb;
	protected $table_name;
	protected $primary_key;

	/**
	 * Construct
	 * 
	 * @param string	Table name
	 * @param string	Primary key
	 */
	protected function __construct($table_name, $primary_key) {
		global $wpdb;

		$this->wpdb = $wpdb;
		$this->table_name = $wpdb->prefix . $table_name;
		$this->primary_key = $primary_key;
	}

	/**
	 * Returns the row from the table
	 * 
	 * @param string $output Optional. one of ARRAY_A | ARRAY_N | OBJECT constants. Return an associative array (column => value, ...),
	 * 	a numerically indexed array (0 => value, ...) or an object ( ->column = value ), respectively.
	 * @param int $y Optional. Row to return. Indexed from 0.
	 * @return mixed Database query result in format specified by $output or null on failure
	 */
	public function get( $id, $output = OBJECT, $y = 0 ) {
		$sql = "SELECT * FROM $this->table_name WHERE $this->primary_key = %d";
		return $this->wpdb->get_row( $this->wpdb->prepare( $sql, $id ), $output, $y );
	}

	/**
	 * Insert a row into a table.
	 * 
	 * @param array $data Data to insert (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).
	 * @param array|string $format Optional. An array of formats to be mapped to each of the value in $data. If string, that format will be used for all of the values in $data.
	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.
	 * @return int|false The number of rows inserted, or false on error.
	 */
	public function insert( $data, $format = null ) {
		return $this->wpdb->insert( $this->table_name, $data, $format );
	}

	/**
	 * Updates or inserts a row in the table from the primary key
	 * 
	 * @param array $data Data to update (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).
	 * @param array $where A named array of WHERE clauses (in column => value pairs). Multiple clauses will be joined with ANDs. Both $where columns and $where values should be "raw".
	 * @param array|string $format Optional. An array of formats to be mapped to each of the values in $data. If string, that format will be used for all of the values in $data.
	 * 	A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.
	 * @param array|string $where_format Optional. An array of formats to be mapped to each of the values in $where. If string, that format will be used for all of the items in $where. A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $where will be treated as strings.
	 * @return int|false The number of rows updated, or false on error.
	 */
	public function update( $data, $where = null, $format = null, $where_format = null ) {
		if( null === $where ) {
			if( isset( $data[ $this->primary_key ] ) ) {
				$where = array(
						$this->primary_key => $data[ $this->primary_key ]
				);
				$where_format = array( '%d' );
			} else {
				throw new Exception( 'Não foi defina a clausúla WHERE e a PRIMARY_KEY da tabela.' );
			}
		}

		return $this->wpdb->update( $this->table_name, $data, $where, $format, $where_format );
	}

	/**
	 * Updates or inserts a row in the table from the primary key
	 * 
	 * @param array $data Data to update (in column => value pairs). Both $data columns and $data values should be "raw" (neither should be SQL escaped).
	 * @return int|false The number of rows updated, or false on error.
	 */
	public function store( $data ) {
		if( isset( $data[ $this->primary_key ] ) ) {
			return $this->update( $data );
		}

		return $this->insert( $data );
	}

	/**
	 * Delete a row in the table
	 * 
	 * @param array $where A named array of WHERE clauses (in column => value pairs). Multiple clauses will be joined with ANDs. Both $where columns and $where values should be "raw".
	 * @param array|string $where_format Optional. An array of formats to be mapped to each of the values in $where. If string, that format will be used for all of the items in $where. A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $where will be treated as strings unless otherwise specified in wpdb::$field_types.
	 * @return int|false The number of rows updated, or false on error.
	 */
	public function delete($where, $where_format = null) {
		if( null === $where ) {
			if( isset( $data[ $this->primary_key ] ) ) {
				$where = array(
						$this->primary_key => $data[ $this->primary_key ]
				);
				$format = null;
				$where_format = array( '%d' );
			} else {
				throw new Exception( 'Não foi defina a clausúla WHERE e a PRIMARY_KEY da tabela.' );
			}
		}

		return $this->wpdb->delete( $this->table_name, $where, $where_format );
	}

	
	/**
	 * Delete a row in the table by the primary key
	 *
	 * @param integer		Primary key
	 * @param array|string	$where_format Optional. An array of formats to be mapped to each of the values in $where. If string, that format will be used for all of the items in $where. A format is one of '%d', '%f', '%s' (integer, float, string). If omitted, all values in $where will be treated as strings unless otherwise specified in wpdb::$field_types.
	 * @return int|false	The number of rows updated, or false on error.
	 */
	public function delete_id($id) {
		$where = array(
				$this->primary_key => $id
		);
		$where_format = array( '%d' );

		return $this->wpdb->delete( $this->table_name, $where, $where_format );
	}
	
	public function get_primary_key() {
		return $this->primary_key;
	}
}