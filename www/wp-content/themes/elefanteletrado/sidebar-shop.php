<div id="secondary" class="col-md-3 hidden-sm hidden-xs" role="complementary">
    <div class="shop-sidebar">
        <?php if (is_active_sidebar( 'shop-sidebar' ) ) :
            dynamic_sidebar( 'shop-sidebar' );
        endif; // end sidebar widget area
        ?>
    </div>
</div><!-- #secondary -->