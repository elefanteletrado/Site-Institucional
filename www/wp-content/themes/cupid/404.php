<?php
global $post;

$frontpage_id = get_option('page_on_front');
$post = get_post($frontpage_id);

get_template_part('el-templates/header');
?>
    <main>
        <?php
        echo apply_filters('the_content', $post->post_content);
        ?>
        <?php get_template_part('el-templates/section-contact'); ?>
        <div id="message-404" class="el-modal el-modal-confirm">
            <div>
                <div class="el-modal-dialog">
                    <section class="el-modal-content el-modal-content-msg">
                        <div class="el-modal-header">
                            <h4 class="el-modal-title">Página não encontrada</h4>
                        </div>
                        <div class="el-modal-body">
                            <p class="el-modal-message">
                                O link que você acessou não está disponível. Em caso de dúvidas entre em contato!
                            </p>
                            <button class="submit-ok message-404-ok">Voltar para o site</button>
                        </div>
                        <div class="el-modal-footer">

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
<?php get_template_part('el-templates/footer'); ?>