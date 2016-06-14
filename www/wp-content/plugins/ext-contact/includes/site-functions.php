<?php
function ext_contact_save() {
	require_once EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact.php';

	$option_id = 1;
	$option = get_option( 'ext_contact_type_item_' . $option_id );

	require EXT_BASE_INCLUDE_DIR . '/class-ext-base-validate.php';

	$result = array(
		'status' => 0,
		'msg' => null
	);
	$error_list = array();

	if( !trim( $_REQUEST['nome'] ) ) {
		$error_list['nome'] = 'O campo "Nome" é obrigatório.';
	}
	if( !Ext_Base_Validate::email( $_REQUEST['email'] ) ) {
		$error_list['email'] = 'Preencha o campo "E-mail" com um endereço válido.';
	}

	if( !Ext_Base_Validate::telefone( $_REQUEST['telefone'] ) ) {
		$error_list['telefone'] = 'Digite um número de telefone válido.';
	}

	if(EXT_CONTACT_MULTIPLE_SUBJECTS) {
		$valid = false;
		if( isset( $_REQUEST['assunto'] ) ) {
			foreach( $option['subject_list'] as $item ) {
				if( $item['id'] == $_REQUEST['assunto'] ) {
					$valid = true;
					break;
				}
			}
		}
		if( !$valid ) {
			$error_list['assunto'] = 'O campo "Sobre o que deseja falar?" é obrigatório.';
		}
	} else {
		$_REQUEST['assunto'] = EXT_CONTACT_CODE_ALL_SUBJECTS;
	}

	if( strlen( trim( $_REQUEST['mensagem'] ) ) < 4 ) {
		$error_list['mensagem'] = 'O campo "Mensagem" é obrigatório.';
	}

	if( !$error_list && isset( $option['active_captcha'] ) ) {
		switch( $option['active_captcha'] ) {
			case 1:
				require EXT_BASE_INCLUDE_DIR . '/class-ext-base-recaptcha.php';
				$resp = Ext_Base_Recaptcha::check_answer();
				if( !$resp->is_valid ) {
					$error_list['captcha'] = 'Preencha o captcha corretamente.';
				}
				break;
			case 2:
				$id = $_REQUEST['siwp_captcha_id'];
				$code = $_REQUEST['siwp_captcha_value'];
				if( !ext_captcha_check( $id, $code ) ) {
					$error_list['captcha'] = 'Preencha o captcha corretamente.';
				}
		}
	}

	if( $error_list ) {
		$result['msg'] = 'Os seguintes erros foram encontrados:' . "\n" . implode( "\n", $error_list );
	} else {
		require EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact-model.php';

		$model = Ext_Contact_Model::get_instance();

		$insert = array(
			'nome' => $_REQUEST['nome'],
			'email' => $_REQUEST['email'],
			'telefone' => preg_replace( '/\\D/', '', $_REQUEST['telefone'] ),
			'assunto' => $_REQUEST['assunto'],
			'mensagem' => $_REQUEST['mensagem']
		);
		foreach( $insert as &$item ) {
			$item = strip_tags( $item );
		}

		if($model->insert($insert)) {
			Ext_Contact::sendMail($option_id, $insert);
			$result['status'] = '1';
			$result['msg'] = 'Entraremos em contato o mais rápido possível.';
		} else {
			$result['msg'] = 'Ocorreu um erro inesperado. Contate o administrador do sistema.';
		}
	}
	exit(json_encode($result));
}

add_action('wp_ajax_nopriv_ext_contact_save', 'cbmtbt_site_ext_contact_save');
add_action('wp_ajax__ext_contact_save', 'cbmtbt_site_ext_contact_save');