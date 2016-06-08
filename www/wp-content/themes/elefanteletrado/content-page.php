<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php the_content(); ?>

    </div>
    <?php wp_link_pages( array(
        'before'      => '<div class="cupid-page-links"><span class="cupid-page-links-title">' . __( 'Pages:', 'cupid' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span class="cupid-page-link">',
        'link_after'  => '</span>',
    ) ); ?>
    <!-- .entry-content -->
    <?php edit_post_link( __( 'Edit', 'cupid' ), '<div class="entry-footer-edit"><span class="edit-link">', '</span></div>' ); ?>
</div>