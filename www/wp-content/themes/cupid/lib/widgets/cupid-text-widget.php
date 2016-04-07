<?php
/**
 * Cupid Text Widget
 *
 * @author      hoan.trinh
 * @category    Widgets
 * @package     G5PlusThemes/Widget
 * @version     1.0.0
 * @extends     G5Plus_Widget
 */

class Cupid_Text_Widget extends G5Plus_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'cupid-text-widget';
		$this->widget_description = __( "List Category", 'cupid' );
		$this->widget_id          = 'cupid_text_widget';
		$this->widget_name        = __( 'cupid: Text Widget', 'cupid' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Title', 'cupid' )
			),
			'content'  => array(
				'type'  => 'text-area',
				'std'   => '',
				'label' => __( 'Content', 'cupid' )
			),
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title         = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$content         = empty( $instance['content'] ) ? '' : apply_filters( 'widget_content', $instance['content'] );
		$widget_id = $args['widget_id'];
		$class_custom   = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_class_custom', $instance['class_custom'] );

		echo wp_kses_post($before_widget);

		if ( $class_custom <> '' ) {
			echo '<div class="' . esc_attr($class_custom) . '">';
		}
		echo '<div class="' . esc_attr($this->widget_cssclass . '-inner') . '">';
		if ( ! empty( $title ) ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		}
		echo wp_kses_post($content);
		echo '</div>';
		if ( $class_custom <> '' ) {
			echo '</div>';
		}
		echo wp_kses_post($after_widget);
	}
}

if (!function_exists('cupid_register_text_widget')) {
	function cupid_register_text_widget() {
		register_widget('Cupid_Text_Widget');
	}
	add_action('widgets_init', 'cupid_register_text_widget', 1);
}