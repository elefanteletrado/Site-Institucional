<div id="secondary" class="col-md-3 col-md-pull-9 hidden-sm hidden-xs" role="complementary">
    <div class="primary-sidebar">
        <?php if (is_active_sidebar( 'primary-sidebar' ) ) :
            dynamic_sidebar( 'primary-sidebar' );
        endif; // end sidebar widget area
        ?>
    </div>
</div><!-- #secondary -->