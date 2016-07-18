<?php
$option_id = 1;
$option = get_option( 'ext_contact_type_item_' . $option_id );
$optionRecaptcha = get_option( 'ext_base_recaptcha' );
?>
<div id="popup-contact" class="el-modal" style="display: none">
	<div>
		<div class="el-modal-dialog">
			<section class="el-modal-content">
				<div class="el-modal-header">
					<button type="button" class="el-close popup-contact-close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">X</span></button>
					<h4 class="el-modal-title">Por favor preencha o formulário abaixo:</h4>
				</div>
				<div class="el-modal-body">
					<form class="form-contact" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
						<input type="hidden" name="action" value="ext_contact_save">
						<input type="hidden" name="subject" value="6">
						<div class="row">
							<div class="col-sm-12">
								<label for="modal-contsct-name" class="sr-only">Nome completo</label>
								<input class="form-control" id="modal-contsct-name" name="name" type="text" maxlength="100" placeholder="Nome completo" required>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<label for="modal-contsct-email" class="sr-only">E-mail</label>
								<input class="form-control" id="modal-contsct-email" name="email" type="email" maxlength="100" required placeholder="E-mail">
							</div>
							<div class="col-sm-6">
								<label for="modal-contsct-phone" class="sr-only">Telefone</label>
								<input class="form-control" id="modal-contsct-phone" name="phone" type="tel" maxlength="20" required oninput="onInputTel(this)" placeholder="Telefone">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="modal-contsct-school" class="sr-only">Nome da Instituição</label>
								<input class="form-control" id="modal-contsct-school" name="school" type="text" maxlength="100" required placeholder="Nome da Instituição">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label for="modal-contact-message" class="sr-only">Mensagem</label>
								<textarea class="form-control" id="modal-contact-message" name="message" placeholder="Mensagem" required></textarea>
							</div>
						</div>
						<?php if(!empty($option['active_captcha'])): ?>
							<div class="row">
								<div class="col-sm-12">
									<div style="width: 235px; height: 70px; margin: auto;">
										<div class="g-recaptcha" id="recaptcha-contact-popup"></div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<button type="submit" class="submit-button">Enviar</button>
					</form>
				</div>
				<div class="el-modal-footer">

				</div>
			</section>
		</div>
	</div>
</div>
<div id="popup-contact-message" class="el-modal el-modal-confirm" style="display: none">
	<div>
		<div class="el-modal-dialog">
			<section class="el-modal-content el-modal-content-msg">
				<div class="el-modal-header">
					<button type="button" class="el-close popup-contact-message-ok" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">X</span></button>
					<h4 class="el-modal-title">Obrigado!</h4>
				</div>
				<div class="el-modal-body">
					<p class="el-modal-message">
						Entraremos em contato o mais rápido possível.
					</p>
					<button class="submit-ok popup-contact-message-ok">OK</button>
				</div>
				<div class="el-modal-footer">

				</div>
			</section>
		</div>
	</div>
</div>
<?php if(!empty($option['active_captcha'])): ?>
	<script type="text/javascript">
		var elCupidCaptchaCallback = function() {
			grecaptcha.render('recaptcha-contact-section', {'sitekey': <?php echo json_encode($option['private_key']); ?>});
			grecaptcha.render('recaptcha-contact-popup', {'sitekey' : <?php echo json_encode($option['private_key']); ?>});
		};
	</script>
	<script src="https://www.google.com/recaptcha/api.js?onload=elCupidCaptchaCallback&render=explicit" async defer></script>
<?php endif; ?>