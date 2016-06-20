<?php
/**
 * Template Name: :: Página Inicial
 */
?>
<?php get_template_part('el-templates/header'); ?>
<main>
	<section id="main-banner" class="el-banner-container">
		<div class="el-content" style="background-image: url('<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/banner-main.jpg');">
			<div>
				<div>
					<h2>Incentive a formação de pequenos leitores com o Elefante Letrado</h2>
					<p>Livros infantis nivelados e atividades pedagógicas em um ambiente digital lúdico e interativo para alunos do 1º ao 5º ano do ensino fundamental.</p>
					<div class="el-buttons">
						<a id="popup-contact-open" class="el-btn-contrast" href="">Agendar Demonstração</a>
						<a class="el-btn-outline" href="">Conheça nosso acervo</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<article class="el-article">
		<h1>O Elefante Letrado</h1>
		<p>
			Somos a primeira ferramenta pedagógica digital voltada ao desenvolvimento da formação e hábito da leitura nos
			alunos do 1º ao 5º ano do Ensino Fundamental. Pensando em facilitar e também auxiliar os professores, proporcionamos
			o acompanhamento do progresso da compreensão leitora de cada criança, através de relatórios e descritores baseados no Saeb.
		</p>
		<div class="visible-xs-block">
			<div id="owl-carousel-devices" class="owl-carousel el-carousel-devices">
				<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/dispositivos/biblioteca.jpg" width="450" height="453" title="Biblioteca Elefante Letrado">
				<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/dispositivos/livro.jpg" width="450" height="453" title="Livro do Elefante Letrado">
				<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/dispositivos/relatorios.jpg" width="450" height="453" title="Relatórios do Elefante Letrado">
			</div>
		</div>
		<div class="visible-sm-block">
			<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/devices.jpg" alt="Todos os dispositivos são compatíveis com o Elefante Letrado" class="img-style-1" />
		</div>
		<div class="el-box-special">
			<h2><span style="max-width: 350px; display: block; float: right;">Nosso propósito</span><br style="clear: both"> </h2>
			<div class="el-content">
				<p>
					Buscamos contribuir para o desenvolvimento da compreensão
					leitora, integrando a criança à cultura letrada por meio de uma
					plataforma de apoio ao ensino, sustentada por novas tecnolo-
					gias digitais.
				</p>
			</div>
		</div>
		<?php /*
		<div class="el-read-more">
			<a href="" class="el-btn-contrast">Saiba mais</a>
		</div>
 		*/ ?>
		<div style="height: 80px;">&nbsp;</div>
	</article>
	<section class="el-section-quote fade-effect">
		<div>
			<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/icon-book.svg" width="100" height="61" />
			<p class="el-author-quote">
				“Livros não mudam o mundo, quem muda o mundo
				são as pessoas. Os livros só mudam as pessoas.”
			</p>
			<p class="el-author-name">
				- Mário Quintana
			</p>
		</div>
	</section>
	<article class="el-article-style-2">
		<h1>Uma biblioteca para alunos e professores</h1>
		<div class="row" style="max-width: 1200px !important; margin: auto;">
			<div class="col-sm-6">
				<div class="el-icon-col-container">
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/icon-round-book.svg" width="90" height="90" aria-hidden="true">
				</div>
				<h2>Acervo literário digital</h2>
				<p>
					Trabalhe com centenas de obras e autores da literatura infantil
					em aula. A biblioteca é dividida de A a Z, de acordo com os
					níveis de proficiência em leitura de cada aluno.
				</p>
			</div>
			<div class="col-sm-6">
				<div class="el-icon-col-container">
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/icon-round-toga.svg" width="90" height="90" aria-hidden="true">
				</div>
				<h2>Atividades pedagógicas</h2>
				<p>
					Estimule a compreensão leitora dos alunos através de atividades
					relacionadas aos descritores do Saeb. Ao ler e realizar os jogos,
					a criança acumula pontos e avança de nível.
				</p>
			</div>
		</div>
		<div class="row" style="max-width: 1200px !important; margin: auto;">
			<div class="col-sm-6">
				<div class="el-icon-col-container">
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/icon-round-monitor-graph.svg" width="90" height="90" aria-hidden="true">
				</div>
				<span class="el-icon el-icon-"></span>
				<h2>Relatórios para professores</h2>
				<p>
					Acompanhe o progresso de sua turma através de relatórios
					sobre o desenvolvimento de cada aluno. Os dados fornecidos
					permitem avaliar e replanejar as práticas em aula.
				</p>
			</div>
			<div class="col-sm-6">
				<div class="el-icon-col-container">
					<img src="<?php echo get_template_directory_uri(); ?>/el-assets/images/layout/icon-round-tablet.svg" width="90" height="90" aria-hidden="true">
				</div>
				<h2>Acesso em qualquer lugar</h2>
				<p>
					Acesse os livros e relatórios da plataforma em notebooks, tablets
					e computadores através da Internet. Seus alunos também podem
					realizar as atividades aonde estiverem.
				</p>
			</div>
		</div>
		<div class="el-read-more">
			<a href="" class="el-btn-contrast">Mais funcionalidades</a>
		</div>
	</article>
	<?php /* SECTION AUTHORS */ ?>
	<?php /* SECTION CLIENTS */ ?>
	<?php /*
	<section class="el-section-impact fade-effect" style="background-image: url(<?php echo get_template_directory_uri(); ?>/el-assets/images/fake/bg-use-recommendation.jpg)">
		<div>
			<div>
				<p>Conheça as recomendações de uso da ferramenta em aula</p>
				<div class="el-buttons">
					<a href="" class="el-btn-outline">Confira</a>
				</div>
			</div>
		</div>
	</section>
 	*/ ?>
	<?php /* SECTION TEAM */ ?>
	<?php get_template_part('el-templates/section.collection'); ?>
	<?php get_template_part('el-templates/section-contact'); ?>
</main>
<?php get_template_part('el-templates/popup-contact'); ?>
<?php get_template_part('el-templates/footer'); ?>