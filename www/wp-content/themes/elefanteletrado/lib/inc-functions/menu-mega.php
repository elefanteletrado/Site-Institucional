<?php
	global $g5lus_config_megamenu;
	$g5lus_config_megamenu = array(
	'icon' => array(
		'text' => __('Menu Icon','cupid'),
		'type' => 'icon-fontawesome'
	),
	'hide-text-menu' => array(
		'text' => __('Hide Text Menu','cupid'),
		'type' => 'checkbox'
	),

	'disable-link' => array(
		'text' => __('Disable Link','cupid'),
		'type' => 'checkbox'
	),
	'is-search-button' => array(
		'text' => __('Is Search Button/Cart Button','cupid'),
		'type' => 'checkbox'
	),
	'dropdown-element' => array(
		'text' => __('Side of Dropdown Elements','cupid'),
		'type' => 'select',
		'std' => 'left',
		'options' => array(
			'left' => 'Drop To Left Side',
			'right' => 'Drop To Right Side'
		),
	),

	'menu-layout' => array(
		'text' => __('Menu Layout','cupid'),
		'type' => 'select',
		'std' => 'auto',
		'options' => array(
			'auto'	=> __('Auto','cupid'),
			'full-width' => __('Full Width','cupid'),
			'col-md-1' => __('1/12','cupid'),
			'col-md-2'	=> __('2/12','cupid'),
			'col-md-3'	=> __('3/12','cupid'),
			'col-md-4'	=> __('4/12','cupid'),
			'col-md-5'	=> __('5/12','cupid'),
			'col-md-6'	=> __('6/12','cupid'),
			'col-md-7'	=> __('7/12','cupid'),
			'col-md-8'	=> __('8/12','cupid'),
			'col-md-9'	=> __('9/12','cupid'),
			'col-md-10'	=> __('10/12','cupid'),
			'col-md-11'	=> __('11/12','cupid')
		)
	),

	'menu-grid' => array(
		'text' => __('Menu Grid (Option for sub mega menu)','cupid'),
		'type' => 'select',
		'std' => '12/12',
		'options' => array(
			'12/12' => __('12/12','cupid'),
			'1/12'	=> __('1/12','cupid'),
			'2/12'	=> __('2/12','cupid'),
			'3/12'	=> __('3/12','cupid'),
			'4/12'	=> __('4/12','cupid'),
			'5/12'	=> __('5/12','cupid'),
			'6/12'	=> __('6/12','cupid'),
			'7/12'	=> __('7/12','cupid'),
			'8/12'	=> __('8/12','cupid'),
			'9/12'	=> __('9/12','cupid'),
			'10/12'	=> __('10/12','cupid'),
			'11/12'	=> __('11/12','cupid')
		)
	),
	'sub-menu-type' => array(
		'text' => __('Sub Menu Type','cupid'),
		'type' => 'select',
		'std' => 'standard',
		'class' => 'mega-menu-sub-type-menu',
		'options' => array(
			'standard' => __('Standard Dropdown','cupid'),
			'multi-column' => __('Multi Column Dropdown','cupid')
		)
	),
	'bg-image' => array(
		'text' => __('Dropdown Background Image','cupid'),
		'type' => 'background',
		'class' => 'mega-menu-background',
		'items' => array(
			'bg-image-attr-repeat' => array(
				'text' => __('Background Image Repeat','cupid'),
				'type' => 'select',
				'std' => 'repeat',
				'hide-label' => 'true',
				'options' => array(
					'repeat' => 'repeat',
					'no-repeat' => 'no-repeat',
					'repeat-x' => 'repeat-x',
					'repeat-y' => 'repeat-y'
				)
			),
			'bg-image-attr-attachment' => array(
				'text' => __('Background Image Attachment','cupid'),
				'type' => 'select',
				'std' => 'scroll',
				'hide-label' => 'true',
				'options' => array(
					'scroll' => 'scroll',
					'fixed' => 'fixed'
				)
			),
			'bg-image-attr-position' => array(
				'text' => __('Background Image Position','cupid'),
				'type' => 'select',
				'std' => 'center',
				'hide-label' => 'true',
				'options' => array(
					'center' => 'center',
					'center left' => 'center left',
					'center right' => 'center right',
					'top left' => 'top left',
					'top center' => 'top center',
					'top right' => 'top right',
					'bottom left' => 'bottom left',
					'bottom center' => 'bottom center',
					'bottom right' => 'bottom right'
				)
			),
			'bg-image-attr-size' => array(
				'text' => __('Background Image Size','cupid'),
				'type' => 'select',
				'std' => 'auto',
				'hide-label' => 'true',
				'options' => array(
					'auto' => 'Keep original',
					'100% auto' => 'Stretch to width',
					'auto 100%' => 'Stretch to height',
					'cover' => 'Cover',
					'contain' => 'Contain'
				)
			)
		)
	)

);

class G5Plus_Mega_Menu {
	function G5Plus_Mega_Menu() {

		// enqueue media
		add_action( 'admin_enqueue_scripts', array( $this, 'load_g5plus_wp_admin_style' ) );

		//show custom field in backend menu
		add_filter( 'wp_edit_nav_menu_walker', array( &$this, 'modify_backend_walker' ), 100 );

		// update custom field when save backend menu
		add_action('wp_update_nav_menu_item', array( &$this, 'custom_nav_update' ),100, 3);
	}


	function load_g5plus_wp_admin_style() {
		wp_register_style( 'g5lus_mega_menu_wp_admin_css', get_template_directory_uri() . '/assets/admin/css/mega-menu.css', false, '1.0.0' );
		wp_enqueue_style( 'g5lus_mega_menu_wp_admin_css' );

		wp_register_script('g5plus_mega_menu_wp_admin_js', get_template_directory_uri() . '/assets/admin/js/mega-menu.js', false, '1.0.0' );
		wp_enqueue_script( 'g5plus_mega_menu_wp_admin_js' );
	}

	function modify_backend_walker() {
		return 'G5plus_Mega_Backend_Walker';
	}

	function custom_nav_update( $menu_id, $menu_item_db_id, $args ) {

		global $g5lus_config_megamenu;

		$custom_fields = array();
		foreach ((array) $g5lus_config_megamenu as $key=>$value) {
			$custom_fields[] = $key;
			if (isset($value['items'])) {
				foreach ((array)$g5lus_config_megamenu[$key]['items'] as $sub_key => $sub_value) {
					$custom_fields[] = $sub_key;
				}
			}
		}

		foreach ((array) $custom_fields as $field) {
			if ( isset($_REQUEST['menu-item-g5plus-' . $field]) && isset($_REQUEST['menu-item-g5plus-' . $field][$menu_item_db_id]))  {
				$custom_value = $_REQUEST['menu-item-g5plus-' . $field][$menu_item_db_id];
				update_post_meta( $menu_item_db_id, '_menu-item-g5plus-' . $field, $custom_value );
			}
			else {
				update_post_meta( $menu_item_db_id, '_menu-item-g5plus-' . $field, '' );
			}
		}
	}
}

// init maga menu
new G5Plus_Mega_Menu();

if ( ! class_exists( 'G5plus_Mega_Backend_Walker' ) ) {
	/**
	 * Create HTML list of nav menu input items.
	 * This walker is a clone of the wordpress edit menu walker with some options appended, so the user can choose to create mega menus
	 *
	 * @package G5Plus
	 * @since   1.0
	 * @uses    Walker_Nav_Menu
	 */
	class G5plus_Mega_Backend_Walker extends Walker_Nav_Menu {
		/**
		 * @see   Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of page.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
		}
		/**
		 * @see   Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of page.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * @see   Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output       Passed by reference. Used to append additional content.
		 * @param object $item         Menu item data object.
		 * @param int    $depth        Depth of menu item. Used for padding.
		 * @param int    $current_page Menu item ID.
		 * @param object $args
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {

			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			ob_start();

			$item_id = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) )
					$original_title = false;
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title = $original_object->post_title;
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)', 'cupid' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __('%s (Pending)', 'cupid'), $item->title );
			}

			$title = empty( $item->label ) ? $title : $item->label;

			?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
						echo wp_nonce_url(
							esc_url(add_query_arg(
								array(
									'action' => 'move-up-menu-item',
									'menu-item' => $item_id,
								),
								remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
							)),
							'move-menu_item'
						);
						?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'cupid'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
						echo wp_nonce_url(
							esc_url(add_query_arg(
								array(
									'action' => 'move-down-menu-item',
									'menu-item' => $item_id,
								),
								remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
							)),
							'move-menu_item'
						);
						?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'cupid'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item','cupid'); ?>" href="<?php
					echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url(add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ));
					?>"><?php _e( 'Edit Menu Item', 'cupid' ); ?></a>
                </span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
							<?php _e( 'URL', 'cupid' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Navigation Label', 'cupid' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id) ; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id) ; ?>">
						<?php _e( 'Title Attribute', 'cupid' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id) ; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr($item_id) ; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id) ; ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id) ; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab', 'cupid' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr($item_id) ; ?>">
						<?php _e( 'CSS Classes (optional)', 'cupid' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id) ; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id) ; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id) ; ?>">
						<?php _e( 'Link Relationship (XFN)', 'cupid' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id) ; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Description', 'cupid' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id) ; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'cupid'); ?></span>
					</label>
				</p>
				<?php
				/*
				 * This is the added field
				 */
				global $g5lus_config_megamenu;

				foreach ((array) $g5lus_config_megamenu as $item_key=>$item_data) {
					G5plus_Mega_Backend_Walker::display_custom_field($item, $item_id, $item_key, $item_data);
				}
				/*
				 * end added field
				 */
				?>
				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s', 'cupid'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
					echo wp_nonce_url(
						esc_url(add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
						)),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e('Remove', 'cupid'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
					?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php _e('Cancel', 'cupid'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}

		function display_custom_field ($item, $item_id, $item_key, $item_data) {
			$title = $item_data['text'];
			$key = "menu-item-g5plus-" . $item_key;
			$value = get_post_meta($item_id, '_' . $key, true ); //$item->$item_key
			$item_class = isset($item_data['class']) ? ' ' . $item_data['class'] : '' ;

			$show_advanced_option = '';

			$sub_menu_type = get_post_meta( $item->ID, '_menu-item-g5plus-sub-menu-type', true );
			$advanced_option_field = array('widget-area','bg-image');

			if (isset($sub_menu_type) && in_array($item_key, $advanced_option_field)) {
				$show_advanced_option = 'display:none';
				switch ($sub_menu_type) {
					case 'standard':
						break;
					case 'multi-column':
						if ($item_data['type'] !='widget-area') {
							$show_advanced_option = 'display:block';
						}
						break;
					case 'widget-area':
						$show_advanced_option = 'display:block';
						break;
				}
			}

			switch ($item_data['type']) {
				case 'textbox':
					?>
					<p class="field-custom description description-wide<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option); ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id) ; ?>">
							<?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo  wp_kses_post($title) . '<br />';?>
							<input type="text" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="widefat code edit-menu-item-custom" name="<?php echo esc_attr($key . '[' . $item_id  . ']') ; ?>" value="<?php echo esc_attr( $value ); ?>" />
						</label>
					</p>
					<?php
					break;
				case 'checkbox':
					$value = ( $value == 'active' ) ? ' checked="checked" ' : '';
					?>
					<p class="field-custom description description-wide<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option); ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>">
							<input type="checkbox" value="active" id="edit-<?php echo esc_attr($key . '-' . $item_id) ; ?>" class=" <?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>" <?php echo wp_kses_post($value); ?> /><?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo wp_kses_post($title) . '<br />';?>
						</label>
					</p>
					<?php
					break;
				case 'select':
					?>
					<p class="field-custom description description-wide field-custom-full-width<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option); ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id) ; ?>">
							<?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo wp_kses_post($title) . '<br />';?>
							<select name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>" id="edit-<?php  echo esc_attr($key . '-' . $item_id); ?>">
								<?php
									foreach ($item_data['options'] as $option_key => $option_value) {
										$option_selected = '';
										if (isset($value) && $value) {
											$option_selected = ($value == $option_key) ? 'selected = "selected"' : '';
										}
										else {
											if (isset($item_data['std']) && $item_data['std'] == $option_key) {
												$option_selected = 'selected = "selected"';
											}
										}
										?>
										<option <?php echo wp_kses_post($option_selected); ?> value="<?php echo esc_attr($option_key);?>"><?php echo wp_kses_post($option_value);?></option>
										<?php
									}
								?>
							</select>
						</label>
					</p>
					<?php
					break;
				case 'widget-area':
					?>
					<p class="field-custom description description-wide field-custom-full-width<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option) ; ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id) ; ?>">
							<?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo wp_kses_post($title) . '<br />';?>
							<select name="<?php echo esc_attr($key . '[' . $item_id . ']') ; ?>" id="edit-<?php  echo esc_attr($key . '-' . $item_id); ?>">
								<option value=""><?php echo wp_kses_post($item_data['select-text-default']);?></option>
								<?php
								$sidebars = $GLOBALS['wp_registered_sidebars'];

								foreach ($sidebars as $sidebar) {
									$option_selected = (( $value == $sidebar['id'] ) ? ' selected="selected" ' : '' );
									$option_value = '[' . $sidebar['id'] . '] - ' . $sidebar['name'];
									?>
									<option <?php echo wp_kses_post($option_selected); ?> value="<?php echo esc_attr($sidebar['id']);?>"><?php echo esc_html($option_value) ;?></option>
									<?php
								}
								?>

							</select>
						</label>
					</p>
					<?php
					break;
				case 'background':
					?>
					<div class="field-custom description description-wide<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option); ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" style="display: block">
							<?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo wp_kses_post($title) . '<br />';?>
							<input type="text" value="<?php echo esc_attr($value); ?>" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class=" <?php echo esc_attr($key) ; ?>" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" />
							<button type="button" id="browse-edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="set_custom_images button button-secondary submit-add-to-menu"><?php echo __('Browse Image','cupid'); ?></button>
						</label>
						<label class="field-custom-width-4" style="display: block">
							<?php
							foreach ($item_data['items'] as $bg_key => $bg_data) {
								G5plus_Mega_Backend_Walker::display_custom_field($item, $item_id, $bg_key, $bg_data);
							}
							?>
							<div style="clear:both"></div>
						</label>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function ($) {
							g5plus_media_init("#edit-<?php echo esc_js($key . '-' . $item_id); ?>",'.set_custom_images');
						});
					</script>
					<?php

					break;
				case 'icon-fontawesome':
					?>
					<p class="field-custom description description-wide field-custom-full-width<?php echo esc_attr($item_class); ?>" style="<?php echo esc_attr($show_advanced_option); ?>">
						<label for="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="icon">
							<?php if (!isset($item_data['hide-label']) || ($item_data['hide-label']) != 'true') echo wp_kses_post($title). '<br />';?>
							<input type="text" value="<?php echo esc_attr($value) ; ?>" id="edit-<?php echo esc_attr($key . '-' . $item_id); ?>" class="<?php echo esc_attr($key); ?>  input-icon" name="<?php echo esc_attr($key . "[" . $item_id . "]"); ?>" />
							<button type="button" class="browse-icon button button-secondary"><?php echo __('Choose Icon','cupid'); ?></button>
							<span class="icon-preview"><i class="fa <?php echo esc_attr( $value );  ?>"></i></span>
						</label>
					</p>
					<?php
					break;
			}
			?>
			<?php

		}

		/* Add a 'hasChildren' property to the item
		 * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633
		 */
		function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
		{
			// check whether this item has children, and set $item->hasChildren accordingly
			$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

			// continue with normal behavior
			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}
	}
}


if ( ! class_exists( 'G5Plus_Mega_Menu_Walker' ) ) {
	class G5Plus_Mega_Menu_Walker extends Walker_Nav_Menu {
		public $current_item = array();
		public $items_parent = array();
		public $is_mega_menu = false;

		function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			// check whether this item has children, and set $item->hasChildren accordingly
			$element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);
			// continue with normal behavior
			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			array_push($this->items_parent, $this->current_item);

			$tabs = str_repeat("\t", $depth);
			$sub_menu_type = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-sub-menu-type', true );
			$menu_layout = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-menu-layout', true );

			if ( isset($sub_menu_type) && $sub_menu_type == 'multi-column' ) {
				$bg_image = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image', true );
				$bg_image_attr_repeat = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-repeat', true );
				$bg_image_attr_attachment = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-attachment', true );
				$bg_image_attr_position = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-position', true );
				$bg_image_attr_size = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-size', true );
				$style_bg = '';

				if (isset($bg_image) && $bg_image) {
					$style_bg = "background-image:url('$bg_image');background-attachment:$bg_image_attr_attachment;background-position:$bg_image_attr_position;background-repeat:$bg_image_attr_repeat;background-size:$bg_image_attr_size;";

					$style_bg = ' style="' . ($style_bg) . '"';
				}

				if (isset($menu_layout) && ($menu_layout != 'full-width') && ($menu_layout != 'auto')) {
					$output .= $tabs . '<ul class="dropdown-menu  not-auto-size ' . $menu_layout . '">';
				}
				else {
					$output .= $tabs . '<ul class="dropdown-menu">';
				}
				$output .= $tabs . '<li>';
				$output .= $tabs . '<div class="yamm-content"' . $style_bg . '>';
				$output .= $tabs . '<div class="row">';
			}
			else {
				$sub_menu_type_parent = get_post_meta( $this->current_item->menu_item_parent, '_menu-item-g5plus-sub-menu-type', true );
				if ( isset($sub_menu_type_parent) && $sub_menu_type_parent == 'multi-column' ) {
					$output .= "\n{$tabs}<ul class=\"list-unstyled\">\n";
				}
				else {
					if ($this->is_mega_menu) {
						$output .= "\n{$tabs}<ul class=\"list-styled\">\n";
					}
					else {
						if ( isset($sub_menu_type) && $sub_menu_type == 'widget-area' ) {
							if (isset($menu_layout) && ($menu_layout != 'full-width') && ($menu_layout != 'auto')) {
								$output .= "\n{$tabs}<ul class=\"dropdown-menu not-auto-size $menu_layout\">\n";
							}
							else {
								$output .= "\n{$tabs}<ul class=\"dropdown-menu\">\n";
							}
						}
						else {
							$output .= "\n{$tabs}<ul class=\"dropdown-menu\">\n";
						}
					}

				}
			}
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$tabs = str_repeat("\t", $depth);

			$item = array_pop($this->items_parent);

			$sub_menu_type = get_post_meta( $item->ID, '_menu-item-g5plus-sub-menu-type', true );
			if ( isset($sub_menu_type) && $sub_menu_type == 'multi-column' ) {
				$output .= "\n{$tabs}</div><!--.row-->\n";
				$output .= "\n{$tabs}</div><!--.yamm-content-->\n";
				$output .= "\n{$tabs}</li><!--.row-->\n";
				$output .= "\n{$tabs}</ul><!--.dropdown-menu-Mega-->\n";
			}
			else {
				$sub_menu_type_parent = get_post_meta( $this->current_item->menu_item_parent, '_menu-item-g5plus-sub-menu-type', true );
				if ( isset($sub_menu_type_parent) && $sub_menu_type_parent == 'multi-column' ) {
					$output .= "\n{$tabs}</ul>\n";
				}
				else {
					$output .= "\n{$tabs}</ul><!--.dropdown-menu-->\n";
				}

			}
		}
		function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
			if (is_array($args)) {
				$args = (object) $args;
			}
			$this->current_item = $item;
			global $wp_query, $cupid_data;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			/* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */
			if ($item->hasChildren) {
				$classes[] = 'dropdown';
				// level-1 menus also need the 'dropdown-submenu' class
				if($depth >= 1) {
					$classes[] = 'dropdown-submenu';
				}
			}
			/* This is the stock Wordpress code that builds the <li> with all of its attributes */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

			$sub_menu_type = get_post_meta( $item->ID, '_menu-item-g5plus-sub-menu-type', true );

			$dropdown_element = 'drop-to-' . get_post_meta( $item->ID, '_menu-item-g5plus-dropdown-element', true );

			$sub_menu_type_parent = get_post_meta( $item->menu_item_parent, '_menu-item-g5plus-sub-menu-type', true );
			$menu_grid = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-menu-grid', true );
			$menu_grid = 'col-sm-' . str_replace('/12','', $menu_grid);
			$widget_area = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-widget-area', true );

			$menu_layout = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-menu-layout', true );
			$hide_text_menu = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-hide-text-menu', true ); //
			$disable_link = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-disable-link', true ); //
			$is_search_button = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-is-search-button', true ); //
			$menu_layout_class = '';
			if ($menu_layout == 'full-width') $menu_layout_class = ' yamm-fw';
			if ($is_search_button) {
				$class_names .= ' icon-search-button';
			}

			if ( isset($sub_menu_type) && $sub_menu_type == 'widget-area' ) {
				$class_names = ' class="' . esc_attr( $class_names ) . ' menu-item-has-children mega-menu dropdown ' . $dropdown_element . $menu_layout_class . '"';
				$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
			}
			else {
				if ( isset($sub_menu_type) && $sub_menu_type == 'multi-column' ) {
					$class_names .= ' mega-menu '. $menu_layout_class;
				}
				if ( isset($sub_menu_type_parent) && $sub_menu_type_parent == 'multi-column' ) {
					$class_names = ' class="' . esc_attr( $class_names ) . ' ' . $menu_grid . $menu_layout_class . ' mega-menu-item "';
					$output .= $indent . '<div id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
				}
				else {
					if ($this->is_mega_menu) $dropdown_element = '';
					$class_names = ' class="' . esc_attr( $class_names ) . ' ' . $dropdown_element . '"';
					$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
				}
			}

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			if ($disable_link == 'active') {
				$attributes .= ' href="javascript:;"';
			}
			else {
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			}

			$item_output = $args->before;

			$icon_menu = get_post_meta( $item->ID, '_menu-item-g5plus-icon', true );
			$icon_menu_item = '';
			$icon_menu_is_valid = '';
			if (isset($icon_menu) && $icon_menu != '') {
				$icon_menu_item = '<i class="fa ' . $icon_menu . '"></i> ';
				$icon_menu_is_valid = ' has-icon-menu';
			}

			$use_on_page_menu = get_post_meta(get_the_ID(),'use-on-page-menu',true);

			if (isset($use_on_page_menu) && ($use_on_page_menu) && ($depth == 0)) {
				$attributes .= ' data-hash="true" ';
			}

			/* If this item has a dropdown menu, make clicking on this link toggle it */
			if ($item->hasChildren && $depth == 0) {
				$item_output .= '<a'. $attributes .' class="animsition-link dropdown-toggle disabled '. ($hide_text_menu == 'active' ? 'hide-text ' : '') . esc_attr($icon_menu_is_valid) . '" data-toggle="dropdown">';
			} else {
				if ( isset($sub_menu_type) && $sub_menu_type == 'widget-area' && is_active_sidebar($widget_area )) {
					$item_output .= '<a'. $attributes .' class="animsition-link dropdown-toggle disabled '. ($hide_text_menu == 'active' ? 'hide-text ' : ''). esc_attr($icon_menu_is_valid) . '" data-toggle="dropdown">';
				}
				else {
					$item_output .= '<a'. $attributes .' class="animsition-link '. ($hide_text_menu == 'active' ? 'hide-text ' : ''). esc_attr($icon_menu_is_valid) . '">';
				}
			}

			$class_hide_text_menu = $hide_text_menu == 'active' ? 'class="hide-text"' : '';

			if ($is_search_button) {
				$item_output .= $args->link_before;
				$has_cart = '';

				if ( class_exists( 'WooCommerce' ) && isset($cupid_data['show-mini-cart']) && $cupid_data['show-mini-cart'] ) {
					$has_cart = 'has-cart';
				}
				if (isset($cupid_data['show-search-button']) && $cupid_data['show-search-button'] ) {
					$item_output .=  '<i class="fa fa-search ' . esc_attr($has_cart) .'"></i>' . $args->link_after;
				}

				if (!empty($has_cart)) {
					ob_start();
					?>
					<div class="widget_shopping_cart_content">
						<?php get_template_part('woocommerce/cart/mini-cart'); ?>
					</div>
					<?php
					$cart_content  = ob_get_clean();
					$item_output .= $cart_content;
				}

				$item_output .= $args->link_after;
			}
			else {
				$item_output .= $args->link_before . $icon_menu_item. "<span $class_hide_text_menu>" . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' . $args->link_after;
			}


			/* Output the actual caret for the user to click on to toggle the menu */
			if ($item->hasChildren) {
				$item_output .= '<b class="caret"></b></a>';
			} else {
				if ( isset($sub_menu_type) && $sub_menu_type == 'widget-area' && is_active_sidebar($widget_area )) {
					$item_output .= '<b class="caret"></b></a>';
				}
				else {
					$item_output .= '</a>';
				}
			}

			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

			if ( isset($sub_menu_type) && $sub_menu_type == 'widget-area' ) {
				if (is_active_sidebar($widget_area ) ) {
					$bg_image = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image', true );
					$bg_image_attr_repeat = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-repeat', true );
					$bg_image_attr_attachment = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-attachment', true );
					$bg_image_attr_position = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-position', true );
					$bg_image_attr_size = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-bg-image-attr-size', true );
					$style_bg = '';
					if (isset($bg_image) && $bg_image) {
						$style_bg = "background-image:url('$bg_image');background-attachment:$bg_image_attr_attachment;background-position:$bg_image_attr_position;background-repeat:$bg_image_attr_repeat;background-size:$bg_image_attr_size;";

						$style_bg = ' style="' . esc_attr($style_bg) . '"';
					}
					ob_start();
					dynamic_sidebar( $widget_area );
					$widget_data  = ob_get_clean();
					$output .= $indent . '<ul class="dropdown-menu mega-menu-widget-wrapper">';
					$output .= $indent . '<li>';
					$output .= $indent . '<div class="mega-menu-widget "'. $style_bg. '>' . $widget_data . '</div>';
					$output .= $indent . '</li>';
					$output .= $indent . '</ul>';
				}
			}
			if ( isset($sub_menu_type) && ($sub_menu_type == 'multi-column' || $sub_menu_type == 'widget-area')) {
				$this->is_mega_menu = true;
			}
		}
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$sub_menu_type = get_post_meta( $item->ID, '_menu-item-g5plus-sub-menu-type', true );
			if ( isset($sub_menu_type) && ($sub_menu_type == 'multi-column' || $sub_menu_type == 'widget-area')) {
				$this->is_mega_menu = false;
			}

			$sub_menu_type_parent = get_post_meta( $item->menu_item_parent, '_menu-item-g5plus-sub-menu-type', true );

			if ( isset($sub_menu_type_parent) && $sub_menu_type_parent == 'multi-column' ) {
				$output .= $indent . '</div>';
			}
			elseif (isset($sub_menu_type_parent) && $sub_menu_type_parent == 'widget-area') {
				$widget_area = get_post_meta( $this->current_item->ID, '_menu-item-g5plus-widget-area', true );
				if (is_active_sidebar($widget_area ) ) {
					$output .= $indent . '</div>';
				}
				else {
					$output .= $indent . '</li>';
				}
			}
			else
			{
				$output .= $indent . '</li>';
			}
		}
	}
}