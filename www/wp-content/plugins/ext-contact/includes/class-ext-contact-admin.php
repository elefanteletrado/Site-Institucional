<?php
/**
 * Admin Contato
 *
 * @package		plugins
 * @subpackage	ext_contact
 * @author Luiz Felipe Bertoldi de Oliveira
 */
class Ext_Contact_Admin {
	private static $instance;
	/**
	 * @var wpdb
	 */
	public $wpdb;
	public $prefix;
	public $table_name;
	public $file;
	public $dir;
	public $url;
	public $title;
	/**
	 * @var Ext_Contact_Model
	 */
	public $model;
	public $primary_key;
	private $option;
	private $option_name;
	private $option_id;
	
	private $order_id;
	private $order_old;

	private $multiple_subjects = EXT_CONTACT_MULTIPLE_SUBJECTS;
	
	public function __construct( $file ) {
		global $wpdb;

		$this->wpdb = $wpdb;
		$this->prefix = 'ext_contact';
		$this->table_name = $wpdb->prefix.'ext_contato';
		$this->file = $file;
		$this->url = plugin_dir_url( $file );
		
		if( EXT_CONTACT_ADMIN ) {
			$this->model = Ext_Contact_Model::get_instance();
			$this->primary_key = $this->model->get_primary_key();
			
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_print_styles', array( $this, 'enqueue_styles' ) );

			$this->option_name = $this->prefix . '_type_item_name_' . str_replace( array( $this->prefix . '_', '-subject', '-list', '-settings' ), '', $_REQUEST['page'] );
			$this->option_id = get_option( $this->option_name );
			$this->option = get_option( $this->prefix . '_type_item_' . $this->option_id );
			$this->title = $this->option['admin_title'];
		}

		if( is_admin() ) {
			add_action( 'wp_ajax_' . $this->prefix  . '_publish', array( $this, 'publish' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_subject_list', array( $this, 'subject_list' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_subject_edit', array( $this, 'subject_edit' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_subject_delete', array( $this, 'subject_delete' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_subject_publish', array( $this, 'subject_publish' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_subject_save', array( $this, 'subject_save' ) );
			add_action( 'wp_ajax_' . $this->prefix  . '_email_link', array( $this, 'email_link' ) );
		}
	}
	
	public function enqueue_scripts() {
		Ext_Base_List_Table::enqueue_script();
		switch( $_REQUEST['page'] ) {
			case $this->prefix . '_' . $this->option['name'] . '-subject':
				wp_enqueue_script( 'ext-contact-functions-subject', $this->url . 'admin/functions-subject.js' );
				wp_enqueue_script( 'wp-ajax-response' );
				break;
			case $this->prefix . '_' . $this->option['name'] . '-settings':
				wp_enqueue_script( 'ext-contact-functions-settings', $this->url . 'admin/functions-settings.js' );
				wp_enqueue_script( 'wp-ajax-response' );
				break;
			case $this->prefix . '_' . $this->option['name'] . '-list':
				wp_enqueue_script( 'ext-contact-functions', $this->url . 'admin/functions.js' );
		}
	}
	
	public function enqueue_styles() {
		Ext_Base_List_Table::enqueue_style();
		wp_enqueue_style( 'ext-contact-style', $this->url . 'admin/style.css' );
	}
	
	public static function get_instance( $file ) {
		if( !self::$instance ) {
			self::$instance = new self( $file );
		}

		return self::$instance;
	}

	public function activate() {
		if( $this->wpdb->get_var( "show tables like '" . $this->table_name . "'" ) != $this->table_name ) {
			$sql = "CREATE TABLE `" . $this->table_name . "` (
					  `contato_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária.',
					  `nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome da pessoa ou da empresa.',
					  `cpf_cnpj` varchar(14) COLLATE utf8_unicode_ci NOT NULL COMMENT 'CPF ou CNPJ do solicitante.',
					  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'E-mail para contato.',
					  `telefone` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Telefone de contato.',
					  `assunto` int(11) NOT NULL COMMENT 'Sobre o que o solicitante do contato deseja falar. Armazena o código númerico de cada assunto. Os códigos de cada assunto são armazenados na aplicação.',
					  `credor` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome do credor. Exibido apenas se o contato for um assunto de cobrança.',
					  `escola` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome da escola.',
					  `mensagem` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Dados da dívida caso seja um contato de assunto de cobrança ou mensagem em caso contrário.',
					  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Data de registro do contato.',
  					PRIMARY KEY (`contato_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$this->install_default_options();
	}
	
	public function install_default_options() {
		$type_list = array(
			1 => array( 
				'name' => 'speak-us', 'title' => 'Contato', 'admin_title' => 'Fale Conosco',
				'subject_list' => null,
				'post_id' => 73,
				'fields' => array()
			)
		);
		if($this->multiple_subjects) {
			$type_list[1]['subject_list'] = array(
					6 => array( 'id' => 6, 'title' => 'Demonstração', 'ordering' => 6, 'publish' => 1 ),
					7 => array( 'id' => 7, 'title' => 'Contato', 'ordering' => 7, 'publish' => 1 )
				);
		} else {
			$type_list[1]['subject_list'] = array(
					EXT_CONTACT_CODE_ALL_SUBJECTS => array( 'id' => 9, 'title' => 'Todos os Assuntos', 'ordering' => 4, 'publish' => 1 )
				);
		}
		$type_list_option = array();
		foreach( $type_list as $type_id => $type ) {
			$type['email_initial_subject'] = 'Contato via Site';
			$type['email_initial_body'] = "Prezado {NOME},\n" .
					"estamos entrando em contato referente a contato efetuado pelo site em {DATA_HORA}.\n\n" .
					"INSIRA A RESPOSTA. INSIRA A RESPOSTA. INSIRA A RESPOSTA.\n" .
					"Mensagem original:\n" .
					"{MENSAGEM_ENVIADA}\n\n" .
					"Atenciosamente";
			update_option( $this->prefix . '_type_item_' . $type_id, $type );
			update_option( $this->prefix . '_type_item_menu_' . $type['post_id'], $type_id );
			update_option( $this->prefix . '_type_item_name_' . $type['name'], $type_id );
			$type_list_option[] = $type_id;
			foreach( $type['subject_list'] as $id => $item ) {
				$item['to'] = array( 'suporte@elefanteletrado.com.br' );
				$item['type'] = $type_id;
				update_option( $this->prefix . '_item_' . $id, $item );
			}
		}
		update_option( $this->prefix . '_type_list', $type_list_option );
		update_option( $this->prefix . '_subject_item_key_next', 10 );
	}

	public function deactivate() {
		delete_option( $this->prefix . '_homepage_count' );
		$this->wpdb->query( 'DROP TABLE IF EXISTS ' . $this->table_name );
	}
	
	public function map_meta_cap( $caps, $cap, $user_id, $args ) {
		$meta_caps = array(
			$this->prefix . '_list' => 'edit_posts',
			$this->prefix . '_add' => 'edit_posts',
			$this->prefix . '_edit' => 'edit_posts',
			$this->prefix . '_manage' => 'edit_posts'
		);
	
		$caps = array_diff( $caps, array_keys( $meta_caps ) );
	
		if ( isset( $meta_caps[ $cap ] ) )
			$caps[] = $meta_caps[ $cap ];
	
		return $caps;
	}
	
	public function menu() {
		$icon = $this->url . '/admin/images/menu-icon.png';
		foreach( get_option( $this->prefix . '_type_list' ) as $id ) {
			$type = get_option( $this->prefix . '_type_item_' . $id );
			$key_object = $this->prefix . '_' . $type['name'];
			add_object_page( $type['admin_title'], $type['admin_title'], 'manage_options', $key_object . '-list', array( $this, 'list_items' ), $icon );
			add_submenu_page( $key_object . '-list', 'Assuntos', 'Assuntos', 'manage_options', $key_object . '-subject', array( $this, 'subject' ) );
			add_submenu_page( $key_object . '-list', 'Configurações', 'Configurações', 'manage_options', $key_object . '-settings', array( $this, 'settings' ) );
		}
	}

	public function list_items() {
		$sortable_columns = array(
			'nome' => 'nome',
			'email' => 'email',
			'created' => 'created'
		);
		$where = 'assunto IN (' . implode( ',', array_keys( $this->option['subject_list'] ) ) . ')';
		$search_nome = isset( $_REQUEST['search-nome'] ) ? $_REQUEST['search-nome'] : '';
		$search_cpf_cnpj = isset( $_REQUEST['search-cpf-cnpj'] ) ? $_REQUEST['search-cpf-cnpj'] : '';
		$search_assunto = isset( $_REQUEST['search-assunto'] ) ? $_REQUEST['search-assunto'] : '';
		if( $search_nome ) {
			$where .= " AND nome LIKE '%" . str_replace( ' ', '%', $this->wpdb->escape( $search_nome ) ) . "%'";
		}
		if( $search_cpf_cnpj ) {
			$where .= " AND cpf_cnpj LIKE '%" . str_replace( ' ', '%', $this->wpdb->escape( preg_replace( '/\\D/', '', $search_cpf_cnpj ) ) ) . "%'";
		}
		if( $search_assunto ) {
			$where .= " AND assunto LIKE '%" . str_replace( ' ', '%', $this->wpdb->escape( $search_assunto ) ) . "%'";
		}

		$order = '';
		if( !isset( $_GET['orderby'] ) || !in_array( $_GET['orderby'], $sortable_columns ) ) {
			$_REQUEST['orderby'] = $_GET['orderby'] = 'created';
			$_REQUEST['orderby'] = $_GET['order'] = 'DESC';
		}
		$order = $_GET['orderby'] . ' ' . ('asc' == $_GET['order'] ? 'ASC' : 'DESC');
		$wp_list_table = new Ext_Base_List_Table( $this->primary_key, null, null, $this->option_name );
		$wp_list_table->edit_url = admin_url( 'admin.php?page=' . $this->prefix . '_' . $this->option['name'] . '-list&action=edit&id=' );
		$wp_list_table->columns = array(
			'nome' => 'Nome',
			//'cpf_cnpj' => 'CPF/CNPJ',
			'email' => 'E-mail',
			'telefone' => 'Telefone',
			'assunto' => 'Assunto',
			'escola' => 'Escola',
			'created' => 'Data de registro',
			//'link' => 'Responder'
		);
		$wp_list_table->columns_actions['nome'] = array(
			'<a title="Visualizar" href="' . $wp_list_table->edit_url . '{' . $this->primary_key . '}">Visualizar</a>'
		);
		$wp_list_table->sortable_columns = $sortable_columns;
		$page_num = $wp_list_table->get_pagenum();
		$wp_list_table->length = $this->model->get_admin( 'LENGTH', $where );
		//Executar ações
		$do_action = $wp_list_table->current_action();
		$wp_list_table->prepare_items();
		$wp_list_table->views = array();
		foreach( get_option( $this->prefix . '_type_list' ) as $id ) {
			$option_type = get_option( $this->prefix . '_type_item_' . $id );
			$length = $this->model->get_admin( 'LENGTH', 'assunto IN (' . implode( ',', array_keys( $option_type['subject_list'] ) ) . ')');
			$page = $this->prefix . '_' . $option_type['name'] . '-list';
			$class = $page == $_REQUEST['page'] ? 'class="current"' : '';
			$url = admin_url( 'admin.php?page=' . $page );
			$wp_list_table->views[$option_type['name']] = '<a href="' . $url . '" ' . $class . '>';
			$wp_list_table->views[$option_type['name']] .= $option_type['admin_title'] . ' '; 
			$wp_list_table->views[$option_type['name']] .= '<span class="count">(' . $length . ')</span></a>';
		}
		require_once ABSPATH . '/wp-admin/admin-header.php';
		$icon = $this->url . '/admin/images/icon.png';
		?>
		<div class="wrap ext-contact ext-list-table">
			<div class="icon32" style="background-image: url(<?php echo $icon; ?>);"><br></div>
			<h2>
				<?php echo $this->title; ?>
			</h2>
			<?php $wp_list_table->views(); ?>
			<form action="<?php echo admin_url( 'admin.php?page=ext_contact' ); ?>" method="get">
				<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
				<p class="search-box">
					<label class="screen-reader-text" for="search-assunto">Assunto:</label>
					<select id="search-assunto" name="search-assunto" class="placeholder placeholder-selected">
						<option value="" class="placeholder-selected">Filtrar por assunto</option>
						<?php foreach( $this->option['subject_list'] as $item ): ?>
						<option value="<?php echo $item['id']; ?>" <?php echo $search_assunto == $item['id'] ? 'selected="selected"' : ''; ?>><?php echo $item['title']; ?></option>
						<?php endforeach; ?>
					</select>
					<label class="screen-reader-text" for="search-nome">Nome:</label>
					<input type="search" id="search-text" name="search-nome" value="<?php echo $search_nome; ?>" placeholder="Filtrar por nome" />
					<?php /*
					<label class="screen-reader-text" for="search-cpf-cnpj">CPF/CNPJ:</label>
					<input type="search" id="search-cpf-cnpj" name="search-cpf-cnpj" value="<?php echo $search_cpf_cnpj; ?>" placeholder="Filtrar por CPF/CNPJ" />
 					*/ ?>
					<?php submit_button( 'Procurar Mensagens', 'button', false, false, array('id' => 'search-submit') ); ?>
				</p>
				<input type="hidden" name="_total" value="<?php echo esc_attr( $wp_list_table->get_pagination_arg( 'total_items' ) ); ?>" />
				<input type="hidden" name="_per_page" value="<?php echo esc_attr( $wp_list_table->get_pagination_arg( 'per_page' ) ); ?>" />
				<input type="hidden" name="_page" value="<?php echo esc_attr( $wp_list_table->get_pagination_arg( 'page' ) ); ?>" />
				<?php if ( isset( $_REQUEST['paged'] ) ): ?>
				<input type="hidden" name="paged" value="<?php echo esc_attr( absint( $_REQUEST['paged'] ) ); ?>" />
				<?php endif; ?>
			</form>
			<br class="clear" />
			<?php
			if( isset( $_REQUEST['action'] ) && 'edit' == $_REQUEST['action'] ) {
				$this->edit();
				return;
			} else {
				$wp_list_table->items = $this->model->get_admin( 'ROWS', $where, $order, $wp_list_table->get_per_page(), $wp_list_table->get_offset() );
				foreach( $wp_list_table->items as &$item ) {
					$item->telefone = Ext_Base_Format::telefone( $item->telefone );
					$item->assunto = $this->option['subject_list'][$item->assunto]['title'];
					//$item->link = '<a href="' . admin_url( 'admin-ajax.php?action=ext_contact_email_link&page=' . $_REQUEST['page'] . '&id=' . $item->contato_id ) . '" class="ext_contact_email_link">Responder</a>';
				}
				$wp_list_table->display();
			}
			?>
		</div>
		<?php
	}
	
	public function edit() {
		$item = $this->model->get( $_REQUEST['id'] );
		?>
		<h3>
			Dados da mensagem
		</h3>
		<table class="form-table">
			<tr class="form-field form-required">
				<th scope="row" valign="top"><label for="name">Nome</label></th>
				<td>
					<?php echo $item->nome; ?>
				</td>
			</tr>
			<?php /*
			<tr class="form-field">
				<th scope="row" valign="top"><label for="cpf_cnpj">CPF/CNPJ</label></th>
				<td>
					<?php echo Ext_Base_Format::cpf_cnpj( $item->cpf_cnpj ); ?>
				</td>
			</tr>
			*/ ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="email">E-mail</label></th>
				<td>
					<?php echo $item->email; ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="telefone">Telefone</label></th>
				<td>
					<?php echo Ext_Base_Format::telefone( $item->telefone ); ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="assunto">Assunto</label></th>
				<td>
					<?php echo $this->option['subject_list'][$item->assunto]['title']; ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="escola">Escola</label></th>
				<td>
					<?php echo $item->escola; ?>
				</td>
			</tr>
			<?php if( in_array( 'credor', $this->option ) ): ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="credor">Credor</label></th>
				<td>
					<?php echo $item->credor; ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="mensagem">Mensagem</label></th>
				<td>
					<?php echo $item->mensagem; ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="order">Data de registro</label></th>
				<td>
					<?php
					$dateTime = new DateTime( $item->created );
					echo $dateTime->format('d/m/Y H:i:s');
					?>
				</td>
			</tr>
		</table>
		<a title="Voltar" href="<?php echo admin_url( 'admin.php?page=' . $this->prefix . '_' . $this->option['name'] . '-list' ); ?>" class="alignright button-primary">
			Voltar
		</a>
		<?php
	}
	
	public function subject_list() {
		$wp_list_table = new Ext_Base_List_Table( 'id', null, null, $this->option_name );
		$wp_list_table->mode = Ext_Base_List_Table::MODE_ARRAY;
		$wp_list_table->edit_url = admin_url( 'admin-ajax.php?action=' . $this->prefix  . '_subject_edit&page=' . $_REQUEST['page'] . '&id=' );
		$wp_list_table->delete_url = admin_url( 'admin-ajax.php?action=' . $this->prefix  . '_subject_delete&page=' . $_REQUEST['page'] . '&id=' );
		$wp_list_table->link_publish = admin_url( 'admin-ajax.php?action=' . $this->prefix  . '_subject_publish&type_id=' . $this->option_id );
		$wp_list_table->columns = array(
			'title' => 'Título',
			'to' => 'Destinatários'
		);
		if(EXT_CONTACT_SUBJECT_EDIT) {
			$wp_list_table->columns['ordering'] = 'Ordem';
			$wp_list_table->columns['publish'] = 'Publicado';
		}
		$delete_onclick = "if( confirm( '" . esc_js( "Você está prestes a excluir este assunto.\n'Cancelar' para interromper, 'OK' para excluir." ) . "' ) ) { return true; }return false;";
		$wp_list_table->columns_actions['title'] = array(
			'edit' => '<a class="row-edit-link" href="' . $wp_list_table->edit_url . '{id}">' . __( 'Edit' ) . '</a>'
		);
		if(EXT_CONTACT_SUBJECT_EDIT) {
			$wp_list_table->columns_actions['title']['delete'] = '<a class="row-delete-link submitdelete" href="' . $wp_list_table->delete_url . '{id}" onclick="' . $delete_onclick . '">' . __( 'Delete' ) . '</a>';
		}
		$page_num = $wp_list_table->get_pagenum();
		$wp_list_table->items = $this->option['subject_list'];
		foreach( $wp_list_table->items as &$item ) {
			$option = get_option( $this->prefix . '_item_' . $item['id'] );
			$item['to'] = implode( ', ', $option['to'] );
		}
		$wp_list_table->length = count( $wp_list_table->items );
		//Executar ações
		$wp_list_table->prepare_items();
		$wp_list_table->views = array();

		$wp_list_table->views();
		$wp_list_table->display();
		if( isset( $_REQUEST['action'] ) && $this->prefix . '_subject_list' == $_REQUEST['action'] ) {
			exit;
		}
	}
	
	public function subject() {
		$icon = $this->url . '/admin/images/icon.png';
		?>
		<div class="ext-contact ext-list-table wrap">
			<div class="icon32" style="background-image: url(<?php echo $icon; ?>);"><br /></div>
			<h2>
				<?php echo $this->title; ?> - Assuntos
			</h2>
			<div class="updated below-h2" id="message" style="display: none;">
				<p>&nbsp;</p>
			</div>
			<div id="col-right">
				<div id="<?php echo $this->prefix; ?>-list">
					<?php $this->subject_list(); ?>
				</div>
				<div id="<?php echo $this->prefix; ?>-list-loading" class="alignleft" style="display: none;">
					Atualizando lista...
				</div>
				<?php if(EXT_CONTACT_SUBJECT_EDIT): ?>
				<div class="alignright">
					<a href="#" id="<?php echo $this->prefix; ?>-button-add" class="button button-primary">Adicionar assunto</a>
				</div>
				<?php endif; ?>
				<br class="clear" />
			</div>
			<div id="col-left">
				<div class="col-wrap">
					<div class="form-wrap">
						<h3>
							<div id="ext-contact-title-add" class="alignleft">
								Adicionar novo Assunto
							</div>
							<div id="ext-contact-title-edit" style="display: none;" class="alignleft">
								Editar Assunto
							</div>
							<div id="ext-contact-loading">&nbsp;</div>
							<br class="clear" />
						</h3>
						<input type="hidden" name="link-list" id="link-list" value="<?php echo admin_url( 'admin-ajax.php?action=' . $this->prefix . '_subject_list&page=' . $_REQUEST['page'] ); ?>" />
							<form id="form-<?php echo $this->prefix . '-subject'; ?>" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="validate" data-multiple-subjects="<?php echo $this->multiple_subjects ? '1' : '0'; ?>">
								<input type="hidden" name="subject-action" id="subject-action" value="<?php echo $this->prefix; ?>_subject_save" />
								<input type="hidden" name="subject-id" id="subject-id" value="" />
								<input type="hidden" name="subject-type" id="subject-type" value="<?php echo $this->option_id; ?>" />
								<div class="form-field form-required">
									<label for="subject-title">Título</label>
									<input name="subject-title" id="subject-title" type="text" value="" size="40" aria-required="true">
									<p>O título do assunto exibido para a seleção na página.</p>
								</div>
								<div class="form-field form-required">
									<label for="subject-to">Enviar para</label>
									<textarea name="subject-to" id="subject-to" rows="5" cols="40" aria-required="true"></textarea>
									<p>Lista de e-mails (um por linha) que deve ser enviado o aviso de nova mensagem.</p>
								</div>
								<?php if(EXT_CONTACT_SUBJECT_EDIT): ?>
									<div class="form-field form-required">
										<label for="subject-ordering">Ordem</label>
										<input name="subject-ordering" id="subject-ordering" type="text" value="" size="40" aria-required="true">
										<p>A posição que será exibido o assunto na página.</p>
									</div>
									<div class="form-field form-required">
										<label for="subject-publish">Publicado</label>
										<input name="subject-publish" id="subject-publish" type="checkbox" value="1"  style="width: auto;" />
										<p>
											Indica se o assunto será exibido no formulário.
											Observa-se que assuntos que tenham sido utilizadas em alguma mensagem não podem ser excluídas, apenas despublicadas.
										</p>
									</div>
								<?php endif; ?>
								<p class="submit">
									<input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar" />
								</p>
							</form>
						</div>
					</div>
				</div>
				<br class="clear" />
			</div>
		<?php
	}
	
	public function subject_edit() {
		$id = $_REQUEST['id'];
		$option = get_option( $this->prefix . '_item_' . $id );
		$option['to'] = implode( "\n", $option['to'] );
		exit( json_encode( $option ) );
	}
	
	public function subject_save() {
		$result = array(
			'result' => 1,
			'msg' => null
		);

		$type = $_REQUEST['type'];

		$id = intval( $_REQUEST['id'] );
		if( !$id || !get_option( $this->prefix . '_item_' . $id ) ) {
			$key_next = $this->prefix . '_subject_item_key_next';
			$id = get_option( $key_next );
			update_option( $key_next, $id + 1 );
		}
		$data = array(
			'id' => $id,
			'title' => strip_tags( $_REQUEST['title'] ),
			'to' => preg_split( '/\\s+/', $_REQUEST['to'] ),
			'ordering' => $_REQUEST['ordering'],
			'type' => $type,
			'publish' => isset( $_REQUEST['publish'] ) ? 1 : 0
		);
		if(EXT_CONTACT_SUBJECT_EDIT) {
			$data['ordering'] = $_REQUEST['ordering'];
			$data['publish'] = isset( $_REQUEST['publish'] ) ? 1 : 0;
		} else {
			$data['ordering'] = $id;
			$data['publish'] = 1;
		}
		foreach( $data['to'] as &$item ) {
			$item = strip_tags( $item );
		}
		
		$this->subject_update( $type, $id, $data );
		
		$result['msg'] = 'Assunto atualizado com sucesso.';
		exit( json_encode( $result ) );
	}
	
	private function subject_update( $type, $id, $data ) {
		$this->order_id = $id;
		$key = $this->prefix . '_type_item_' . $type;
		$type_item = get_option( $key );
		$this->order_old = isset( $type_item['subject_list'][$id]['ordering'] ) ? $type_item['subject_list'][$id]['ordering'] : $data['ordering'];
		$type_item['subject_list'][$id] = $data;
		unset( $type_item['subject_list'][$id]['to'], $type_item['subject_list'][$id]['type'] );
		uasort( $type_item['subject_list'], array( $this, 'callback_type_list_ordering' ) );
		$this->subject_list_compress_order_save_items( $type_item['subject_list'], $data );
		update_option( $key, $type_item );
	}
	
	public function subject_publish() {
		$id = $_REQUEST['id'];
	
		$data = get_option( $this->prefix . '_item_' . $id );
		if( $data ) {
			$data['publish'] = $_REQUEST['publish'] ? 1 : 0;
	
			$this->subject_update( $_REQUEST['type_id'], $id, $data );
	
			$result = array(
				'result' => 1,
				'msg' => 'Status de publicação atualizado com sucesso.'
			);
		} else {
			$result = array(
				'result' => 0,
				'msg' => 'O item não foi encontrado.'
			);
		}
	
		exit( json_encode( $result ) );
	}
	
	public function callback_type_list_ordering( $item1, $item2 ) {
		if( $item1['publish'] > $item2['publish'] ) {
			return -1;
		} else if( $item1['publish'] < $item2['publish'] ) {
			return 1;
		}
		if( $item1['ordering'] > $item2['ordering'] ) {
			return 1;
		}
		if( $item1['ordering'] < $item2['ordering'] ) {
			return -1;
		}
		if( $item1['id'] == $this->order_id ) {
			return $this->order_old > $item2['ordering'] ? -1 : 1;
		} else if( $item2['id'] == $this->order_id ) {
			if( $this->order_old < $item1['ordering'] ) {
				return -1;
			}
		}
		return 1;
	}
	
	public function subject_list_compress_order_save_items( &$list, $data_new = null ) {
		$ordering = 1;
		foreach( $list as &$item ) {
			$item['ordering'] = $ordering;
			
			$key = $this->prefix . '_item_' . $item['id'];
			$data = $data_new && $item['id'] == $data_new['id'] ? $data_new : get_option( $key );
			$data['ordering'] = $ordering;
			update_option( $key, $data );
			
			$ordering++;
		}
	}
	
	public function subject_delete() {
		global $wpdb;
		
		$id = intval( $_REQUEST['id'] );

		$result = array(
			'result' => 0,
			'msg' => null
		);

		$key = $this->prefix . '_item_' . $id;
		$option = get_option( $key );
		if( $option ) {
			if( $this->model->get_count( 'assunto = ' . $id ) ) {
				$result['msg'] = 'Não foi possível excluir esse registro por existir mensagens vinculados a esse assunto.';
			} else {
				$type_item = get_option( $this->prefix . '_type_item_' . $option['type'] );
				unset( $type_item['subject_list'][$option['id']] );
				$this->subject_list_compress_order_save_items( $type_item['subject_list'] );
				update_option( $this->prefix . '_type_item_' . $option['type'], $type_item );
				delete_option( $key );
				$result['result'] = 1;
				$result['msg'] = 'Assunto excluído com sucesso.';
			}
		} else {
			$result['msg'] = 'Não foi encontrado o assunto.';
		}
		exit( json_encode( $result ) );
	}
	
	public function settings() {
		require_once EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact.php';

		$icon = $this->url . '/admin/images/icon.png';
		$message = null;
		if( isset( $_REQUEST['page_id'] ) && $_REQUEST['page_id'] ) {
			$this->option['post_id'] = $_REQUEST['page_id'];
			update_option( $this->prefix . '_type_item_' . $this->option_id, $this->option );
			$message = 'Página vinculada atualizada com sucesso.';
		}
		if( isset( $_REQUEST['contact_email_subject'] ) && $_REQUEST['contact_email_subject'] ) {
			$this->option['email_initial_subject'] = $_REQUEST['contact_email_subject'];
			update_option( $this->prefix . '_type_item_' . $this->option_id, $this->option );
			$message = 'Assunto e mensagem do e-mail prévio atualizados com sucesso.';
		}
		if( isset( $_REQUEST['contact_email_body'] ) && $_REQUEST['contact_email_body'] ) {
			$this->option['email_initial_body'] = $_REQUEST['contact_email_body'];
			update_option( $this->prefix . '_type_item_' . $this->option_id, $this->option );
			$message = 'Assunto e mensagem do e-mail prévio atualizados com sucesso.';
		}
		if( isset( $_REQUEST['active_captcha'] ) ) {
			$this->option['active_captcha'] = min( max( intval( $_REQUEST['active_captcha'] ), 0 ), 2 );
			update_option( $this->prefix . '_type_item_' . $this->option_id, $this->option );
			$message = 'Status do captcha atualizado com sucesso.';
		}
		if( !isset( $this->option['active_captcha'] ) ) {
			$this->option['active_captcha'] = 0;
		}
		?>
		<div class="wrap">
			<div class="icon32" style="background-image: url(<?php echo $icon; ?>);"><br /></div>
			<h2>
				<?php echo $this->title; ?> - Configurações
			</h2>
			<?php if( $message ): ?>
			<div class="updated below-h2" id="message">
				<p>
					<?php echo $message ? $message : '&nbsp;'; ?>
				</p>
			</div>
			<?php endif; ?>
			<h3>
				Conteúdo prévio ao enviar mensagem
			</h3>
			<div class="col-wrap">
				<div class="form-wrap">
					<form id="form-ext_contact-settings-email" method="post" action="<?php echo admin_url( 'admin.php?page=' . $_REQUEST['page'] ); ?>">
						<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
						<div class="form-field form-required">
							<label for="contact_email_subject">Assunto</label>
							<input type="text" name="contact_email_subject" id="contact_email_subject" aria-required="true" value="<?php echo esc_attr( $this->option['email_initial_subject'] ); ?>" />
							<p>Define o assunto prévio dos e-mails enviados através da coluna "Enviar E-mail" na lista de mensagens.</p>
						</div>
						<div class="form-field form-required">
							<label for="contact_email_body">Mensagem</label>
							<textarea name="contact_email_body" id="contact_email_body" rows="10" cols="40" aria-required="true"><?php echo $this->option['email_initial_body']; ?></textarea>
							<p>Define a mensagem prévia dos e-mails enviados através da coluna "Enviar E-mail" na lista de mensagens. A marcação "{NOME}" será substituída pelo nome da pessoa, a marcação {DATA_HORA} pela data e hora que foi enviado o contato e a marcação {MENSAGEM_ENVIADA} pelo texto da mensagem enviada pelo site.</p>
						</div>
						<p class="submit">
							<input type="submit" name="submit" class="button button-primary" value="Salvar" />
						</p>
					</form>
				</div>
			</div>
			<h3>
				Página vinculada
			</h3>
			<div class="col-wrap">
				<div class="form-wrap">
					<form id="form-ext_contact-settings-menu" method="get" action="<?php echo admin_url( 'admin.php' ); ?>">
						<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
						<div class="form-field form-required">
							<label for="post_id">Menu</label>
							<?php wp_dropdown_pages( array( 'show_option_none' => __( '&mdash; Select &mdash;' ), 'selected' => $this->option['post_id'] ) ); ?>
							<p>Selecione a página que as mensagens e os assuntos cadastrados serão vinculados.</p>
						</div>
						<p class="submit">
							<input type="submit" name="submit" class="button button-primary" value="Salvar" />
						</p>
					</form>
				</div>
			</div>
			<h3>
				Captcha
			</h3>
			<div class="col-wrap">
				<div class="form-wrap">
					<form method="get" action="<?php echo admin_url( 'admin.php' ); ?>">
						<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
						<div class="form-field form-required">
							<label for="active_captcha">Status</label>
							<select name="active_captcha" id="active_captcha">
								<option value="0" <?php echo 0 == $this->option['active_captcha'] ? 'selected="selected"' : ''; ?>>Desativado</option>
								<option value="<?php echo EXT_CONTACT_RECAPTCHA; ?>" <?php echo EXT_CONTACT_RECAPTCHA == $this->option['active_captcha'] ? 'selected="selected"' : ''; ?>>reCAPTCHA</option>
								<?php if(defined('EXT_CAPTCHA_FILE')): ?>
								<option value="<?php echo EXT_CONTACT_CAPTCHA; ?>" <?php echo EXT_CONTACT_CAPTCHA == $this->option['active_captcha'] ? 'selected="selected"' : ''; ?>>Ext Captcha</option>
								<?php endif; ?>
							</select>
							<p>Habilita o captcha no formulário.</p>
						</div>
						<p class="submit">
							<input type="submit" name="submit" class="button button-primary" value="Salvar" />
						</p>
					</form>
				</div>
			</div>
			<br class="clear" />
		</div>
		
		<?php
	}
	
	public function email_link() {
		$contact = $this->model->get( $_REQUEST['id'] );
		$dateTime = new DateTime( $contact->created );
		$search = array('{NOME}', '{DATA_HORA}', '{MENSAGEM_ENVIADA}' );
		$replace = array($contact->nome, $dateTime->format( 'd/m/Y H:i:s' ), $contact->mensagem );
		$body = str_replace( $search, $replace, $this->option['email_initial_body'] );
		exit( Ext_Base_Format::get_mailto( $contact->email, $this->option['email_initial_subject'], $body, false ) );
	}
}