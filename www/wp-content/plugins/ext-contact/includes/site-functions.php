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

	if( !trim( $_REQUEST['name'] ) ) {
		$error_list['name'] = 'O campo "Nome" é obrigatório.';
	}
	if( !Ext_Base_Validate::email( $_REQUEST['email'] ) ) {
		$error_list['email'] = 'Preencha o campo "E-mail" com um endereço válido.';
	}

	if( !Ext_Base_Validate::telefone( $_REQUEST['phone'] ) ) {
		$error_list['phone'] = 'Digite um número de telefone válido.';
	}

	if(EXT_CONTACT_MULTIPLE_SUBJECTS) {
		$valid = false;
		if( isset( $_REQUEST['subject'] ) ) {
			foreach( $option['subject_list'] as $item ) {
				if( $item['id'] == $_REQUEST['subject'] ) {
					$valid = true;
					break;
				}
			}
		}
		if( !$valid ) {
			$error_list['subject'] = 'O campo "Sobre o que deseja falar?" é obrigatório.';
		}
	} else {
		$_REQUEST['subject'] = EXT_CONTACT_CODE_ALL_SUBJECTS;
	}

	if( strlen( trim( $_REQUEST['school'] ) ) < 4 ) {
		$error_list['escola'] = 'O campo "Escola" é obrigatório.';
	}

	if( strlen( trim( $_REQUEST['message'] ) ) < 4 ) {
		$error_list['message'] = 'O campo "Mensagem" é obrigatório.';
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
		$result['title'] = 'Erro';
		$result['msg'] = 'Os seguintes erros foram encontrados:' . "\n" . implode( "\n", $error_list );
	} else {
		require EXT_CONTACT_INCLUDE_DIR . 'class-ext-contact-model.php';

		$model = Ext_Contact_Model::get_instance();

		$insert = array(
			'nome' => $_REQUEST['name'],
			'email' => $_REQUEST['email'],
			'telefone' => preg_replace( '/\\D/', '', $_REQUEST['phone'] ),
			'assunto' => $_REQUEST['subject'],
			'escola' => $_REQUEST['school'],
			'mensagem' => $_REQUEST['message']
		);
		foreach( $insert as &$item ) {
			$item = strip_tags( $item );
		}

		if($model->insert($insert)) {
			Ext_Contact::sendMail($option_id, $insert);
			$result['status'] = '1';
			$result['title'] = 'Obrigado!';
			$result['msg'] = 'Entraremos em contato o mais rápido possível.';
		} else {
			$result['title'] = 'Erro';
			$result['msg'] = 'Ocorreu um erro inesperado. Contate o administrador do sistema.';
		}
	}
	exit(json_encode($result));
}

add_action('wp_ajax_nopriv_ext_contact_save', 'ext_contact_save');
add_action('wp_ajax_ext_contact_save', 'ext_contact_save');