<table width="654" cellpadding="0" cellspacing="0" border="0">
<?php /*
	<tr>
		<td colspan="3"><img src="<?php echo $dir_img; ?>email_contato_topo.jpg" alt="Imagem do Topo" title="Imagem do Topo" width="654" height="105" /></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
*/ ?>
	<tr>
		<td width="30">&nbsp;</td>
		<td width="594">
			<font face="arial" size="3">
				<p><b><?php echo $option['title']; ?></b></p>
			</font>
			<font face="arial" size="2">
				<p><b>Nome: </b><?php echo $insert['nome']; ?></p>
				<?php
				if( !empty( $insert['cpf_cnpj'] ) ) {
					echo '<p><b>CPF / CNPJ: </b>' . $insert['cpf_cnpj'] . '</p>';
				}
				?>
				<p><b>E-mail: </b><?php echo $insert['email']; ?></p>
				<p><b>Telefone: </b><?php echo $insert['telefone']; ?></p>
				<p><b>Escola: </b><?php echo $insert['escola']; ?></p>
				<?php /*
				<p><b>Assunto: </b><?php echo $option['subject_list'][$insert['assunto']]['title']; ?></p>
				*/ ?>
 				<?php
				if( isset( $insert['credor'] ) && $insert['credor'] ) {
					echo '<p><b>Credor: </b>' . $insert['credor'] . '</p>';
				}
				?>
				<p><b>Mensagem: </b></p>
				<p><?php echo nl2br( $insert['mensagem']['value'] ); ?></p>
				<p><i>Para ver todas as mensagens <a href="<?php echo $admin_url; ?>" target="_blank" title="clique aqui">clique aqui</a>.</i></p>
			</font>
		</td>
		<td width="30">&nbsp;</td>
	</tr>
<?php /*
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><img src="<?php echo $dir_img; ?>email_contato_rodape.jpg" alt="Imagem do Rodapé" title="Imagem do Rodapé" width="654" height="73" /></td>
	</tr>
*/ ?>
</table>