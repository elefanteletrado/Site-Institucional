<?php
/**
 * Admin Base
 *
 * @package		plugins
 * @subpackage	ext_base
 * @author Luiz Felipe Bertoldi de Oliveira
 */
class Ext_Base_Admin {
	private static $instance;
	private $prefix;
	private $file;
	private $url;
	private $title;
	private $option_recaptcha;

	public function __construct( $file ) {
		$this->prefix = 'ext_base';
		$this->file = $file;
		$this->url = plugin_dir_url( $file );
		$this->option_recaptcha = get_option( $this->prefix . '_recaptcha' );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	public function enqueue_scripts() {
		wp_enqueue_script( 'wp-ajax-response' );
		wp_enqueue_script( 'ext-base-recaptcha', $this->url . 'admin/functions-recaptcha.js' );
	}
	
	public static function get_instance( $file ) {
		if( !self::$instance ) {
			self::$instance = new self( $file );
		}

		return self::$instance;
	}

	public function activate() {
		$this->install_default_options();
	}
	
	public function install_default_options() {
		$recaptcha = array(
			'private_key' => '6LeB-NwSAAAAAE6WQcdYiUZypLPTVC27k9OTUbqR',
			'public_key' => '6LeB-NwSAAAAACyJyctgz3Zmf4VG2WVOO_RIBXVg'
		);
		update_option( $this->prefix . '_recaptcha', $recaptcha );
	}

	public function deactivate() {
		
	}
	
	public function menu() {
		add_options_page( 'reCAPTCHA', 'reCAPTCHA', 'manage_options', 'ext_base_recaptcha', array( $this, 'recaptcha' ) );
	}
	
	public function recaptcha() {
		$message = null;
		if( isset( $_REQUEST['private_key'] ) && $_REQUEST['private_key'] && isset( $_REQUEST['public_key'] ) && $_REQUEST['public_key'] ) {
			$this->option_recaptcha['public_key'] = strip_tags( $_REQUEST['public_key'] );
			$this->option_recaptcha['private_key'] = strip_tags( $_REQUEST['private_key'] );
			
			update_option( $this->prefix . '_recaptcha', $this->option_recaptcha );
			$message = 'Configurações do reCAPTCHA atualizadas com sucesso.';
		}
		?>
		<div class="wrap">
			<h2>
				reCAPTCHA
			</h2>
			<?php if( $message ): ?>
			<div class="updated below-h2" id="message">
				<p>
					<?php echo $message ? $message : '&nbsp;'; ?>
				</p>
			</div>
			<?php endif; ?>
			<div class="col-wrap">
				<div class="form-wrap">
					<form id="form-ext_base_recaptcha" method="post" action="<?php echo admin_url( 'admin.php?page=' . $_REQUEST['page'] ); ?>">
						<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
						<div class="form-field form-required">
							<label for="public_key">Public Key</label>
							<input type="text" name="public_key" id="public_key" aria-required="true" value="<?php echo esc_attr( $this->option_recaptcha['public_key'] ); ?>" />
							<p>Código utilizado no JavaScript, ou seja no lado cliente, pelo reCATCHA.</p>
						</div>
						<div class="form-field form-required">
							<label for="private_key">Private Key</label>
							<input type="text" name="private_key" id="private_key" aria-required="true" value="<?php echo esc_attr( $this->option_recaptcha['private_key'] ); ?>" />
							<p>Código utilizado pela aplicação servidor em conjunto com o reCAPTCHA para verificar a validade dos formulários..</p>
						</div>
						<p class="submit">
							<input type="submit" name="submit" class="button button-primary" value="Salvar" />
						</p>
					</form>
				</div>
			</div>
		</div>
		<?php
	}
}