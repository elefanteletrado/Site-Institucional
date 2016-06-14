<?php
/**
 * List Table classes.
 *
 * @package plugins
 * @subpackage ext-base
 * @version 1.0
 */
require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
class Ext_Base_List_Table extends WP_List_Table {
	const MODE_ARRAY = 1;
	const MODE_OBJECT = 2;
	
	public $length;
	private $per_page = 10;
	private $primary_key;
	public $primary_key_selected;
	public $mode = self::MODE_OBJECT;
	public $display_tablenav_top = true;
	public $display_column_headers_foot = true;
	
	public $columns;
	
	public $columns_actions;
	
	public $sortable_columns = array();

	public $checkbox = true;

	public $pending_count = array();
	
	public $views;
	
	public $bulk_actions = array();
	
	public $link_publish;
	
	public $edit_url;

	public function __construct( $primary_key, $plural = null, $singular = null, $screen = null ) {
		$this->primary_key = $primary_key;
		
		if( null === $plural ) {
			$plural = 'itens';
		}
		if( null === $singular ) {
			$singular = 'item';
		}

		$args = array(
			'plural' => $plural,
			'singular' => $singular,
			'ajax' => true
		);
		if( null !== $screen ) {
			$args['screen'] = $screen;
		}
		parent::__construct( $args );
	}
	
	public function get_search() {
		return ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : null;
	}
	
	public function get_user_id() {
		return ( isset( $_REQUEST['user_id'] ) ) ? $_REQUEST['user_id'] : null;
	}
	
	public function get_order_by() {
		return ( isset( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : null;
	}
	
	public function get_order() {
		return ( isset( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : null;
	}
	
	public function get_number() {
		return isset( $_REQUEST['number'] ) ? ((int) $_REQUEST['number']) : null;
	}
	
	public function get_per_page() {
		return $this->per_page;
	}
	
	public function get_offset() {
		return ($this->get_pagenum() - 1) * $this->get_per_page();
	}

	public function ajax_user_can() {
		return current_user_can( 'edit_posts' );
	}

	function prepare_items() {
		$doing_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

		$number = $this->get_number();
		if ( null === $number ) {
			$number = $this->per_page + min( 8, $this->per_page ); // Grab a few extra
		}

		$page = $this->get_pagenum();

		if ( isset( $_REQUEST['start'] ) ) {
			$start = $_REQUEST['start'];
		} else {
			$start = ( $page - 1 ) * $this->per_page;
		}

		if ( $doing_ajax && isset( $_REQUEST['offset'] ) ) {
			$start += $_REQUEST['offset'];
		}

		$this->set_pagination_args( array(
			'total_items' => $this->length,
			'per_page' => $this->per_page
		) );
	}

	public function current_action() {
		if ( isset( $_REQUEST['delete_all'] ) || isset( $_REQUEST['delete_all2'] ) )
			return 'delete_all';

		return parent::current_action();
	}

	public function display() {
		extract( $this->_args );
		if( $this->display_tablenav_top ) {
			$this->display_tablenav( 'top' );
		}

?>
<table class="<?php echo implode( ' ', $this->get_table_classes() ); ?>" cellspacing="0">
	<thead>
	<tr>
		<?php $this->print_column_headers(); ?>
	</tr>
	</thead>
	<?php if( $this->display_column_headers_foot ): ?>
	<tfoot>
	<tr>
		<?php $this->print_column_headers( false ); ?>
	</tr>
	</tfoot>
	<?php endif; ?>

	<tbody>
		<?php $this->display_rows_or_placeholder(); ?>
	</tbody>
</table>
<?php

		$this->display_tablenav( 'bottom' );
	}

	public function single_row( $a ) {
		echo "<tr>";
		echo $this->single_row_columns( $a );
		echo "</tr>\n";
	}

	public function column_cb( $item ) {
		$value = self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key} : $item[$this->primary_key];
		echo "<input type='checkbox' name='id[]' value='".$value."'";
		if($this->primary_key_selected) {
			$valueRef = self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key_selected} : $item[$this->primary_key_selected];
			echo $value == $valueRef ? 'checked' : '';
		}
		echo " />";
	}

	public function column_default( $item, $column_name ) {
		$value = self::MODE_OBJECT == $this->mode ? $item->$column_name : $item[$column_name];
		if( $this->edit_url ) {
			$id = self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key} : $item[$this->primary_key];
			echo '<a class="row-edit-link" href="' . $this->edit_url . $id . '">' . $value . '</a>';
		} else {
			echo $value;
		}
		if( isset( $this->columns_actions[$column_name] ) ) {
			$actions = $this->columns_actions[$column_name];
			$id = self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key} : $item[$this->primary_key];
			foreach( $actions as &$content ) {
				$content = str_replace( '{' . $this->primary_key . '}', $id, $content );
			}
			echo $this->row_actions( $actions );
		}
	}
	
	public function column_is_publish( $item ) {
		$return = '<div class="publish-button"><div class="loading">&nbsp;</div>';
		$url = $this->link_publish . '&id=' . (self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key} : $item[$this->primary_key]);
		if( self::MODE_OBJECT == $this->mode ? $item->is_publish : $item['is_publish'] ) {
			$return .= '<a href="' . $url . '" class="publish-on">&nbsp;</a>';
		} else {
			$return .= '<a href="' . $url . '" class="publish-off">&nbsp;</a>';
		}
		return $return . '</div>';
	}
	
	public function column_publish( $item ) {
		$return = '<div class="publish-button"><div class="loading">&nbsp;</div>';
		$url = $this->link_publish . '&id=' . (self::MODE_OBJECT == $this->mode ? $item->{$this->primary_key} : $item[$this->primary_key]);
		if( self::MODE_OBJECT == $this->mode ? $item->publish : $item['publish'] ) {
			$return .= '<a href="' . $url . '" class="publish-on">&nbsp;</a>';
		} else {
			$return .= '<a href="' . $url . '" class="publish-off">&nbsp;</a>';
		}
		return $return . '</div>';
	}
	
	public function column_arquivo( $item ) {
		$id = self::MODE_OBJECT == $this->mode ? $item->arquivo : $item['arquivo'];
		echo self::MODE_OBJECT == $this->mode ? $item->arquivo : $item['arquivo'];
	}
	
	public function get_views() {
		return $this->views;
	}
	
	public function get_bulk_actions() {
		return $this->bulk_actions;
	}
	
	public function column_created( $item ) {
		$value = self::MODE_OBJECT == $this->mode ? $item->created : $item['created'];
		if( !$value || '0000-00-00 00:00:00' == $value ) {
			return '-';
		}
		$dateTime = new DateTime( $value );
		return $dateTime->format( 'd/m/Y H:i:s' );
	}
	
	public function column_modified( $item ) {
		$value = self::MODE_OBJECT == $this->mode ? $item->modified : $item['modified'];
		if( !$value || '0000-00-00 00:00:00' == $value ) {
			return '-';
		}
		$dateTime = new DateTime( $value );
		return $dateTime->format( 'd/m/Y H:i:s' );
	}
	
	/**
	 * Generate the table navigation above or below the table
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	public function display_tablenav( $which ) {
		?>
		<div class="tablenav <?php echo esc_attr( $which ); ?>">
			<div class="alignleft actions">
				<?php $this->bulk_actions(); ?>
			</div>
			<?php
			$this->extra_tablenav( $which );
			$this->pagination( $which );
			?>
			<br class="clear" />
		</div>
		<?php
	}
	
	public function get_columns() {
		return $this->columns;
	}
	
	public function get_sortable_columns() {
		return $this->sortable_columns;
	}
	
	public static function enqueue_script() {
		$url = plugin_dir_url( EXT_BASE_FILE );
		wp_enqueue_script( 'ext-base-list-functions', $url . '/admin/list-table.js' );
	}
	
	public static function enqueue_style() {
		$url = plugin_dir_url( EXT_BASE_FILE );
		wp_enqueue_style( 'ext-base-list-style', $url . 'admin/list-table.css' );
	}
}
?>