<?php
/**
 * Model Contact
 * 
 * @package		plugins
 * @subpackage	ext_contact
 * @author Luiz Felipe Bertoldi de Oliveira
 */
class Ext_Contact_Model extends Ext_Base_Model {
	private static $instance;
	
	/**
	 * Construct
	 */
	protected function __construct() {
		parent::__construct('ext_contato', 'contato_id');
	}

	/**
	 * Retorna a lista de items para o Painel de Administração
	 * @param string	Tipo de consulta(LENGTH ou ROWS)
	 */
	public function get_admin( $type = 'ROWS', $where = '', $order = '', $limit = null, $offset = null ) {
		if($where) {
			$where = "WHERE $where";
		}
		switch( $type ) {
			case 'ROWS':
				if($order) {
					$order = "ORDER BY $order";
				}
				$extra = "$where $order";
				if( null !== $limit ) {
					$extra .= ' LIMIT ' . $limit;
				}
				if( null !== $offset ) {
					$extra .= ' OFFSET ' . $offset;
				}
				$sql = "SELECT * FROM $this->table_name $extra";
				return $this->wpdb->get_results( $sql );
			case 'LENGTH':
				$sql = "SELECT COUNT(*) FROM $this->table_name $where";
				return $this->wpdb->get_var( $sql );
			default:
				throw new Exception( 'Set the type of query.' );
		}
		return null;
	}

	/**
	 * Retorna o total de itens para uma lista de itens do Painel de Administração
	 */
	public function get_length_admin() {
		$sql = "SELECT COUNT(*) FROM $this->table_name";
		return $this->wpdb->get_var( $sql );
	}
	
	public function get_count( $where ) {
		$sql = "SELECT COUNT(*) FROM $this->table_name WHERE $where";
		return $this->wpdb->get_var( $sql );
	}
	
	/**
	 * Singleton
	 * 
	 * @return self Instance
	 */
	public static function get_instance() {
		if(null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	public function publish( $ids, $publish ) {
		return $this->wpdb->query( $this->wpdb->prepare( "UPDATE {$this->table_name} SET publish = %s WHERE " . $this->primary_key . ' IN (' . implode( ', ', array_map( 'absint', $ids ) ) . ')', $publish ) );
	}
}
?>