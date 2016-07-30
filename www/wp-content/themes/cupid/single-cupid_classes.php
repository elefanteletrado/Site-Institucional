<?php get_header(); ?>
<?php get_template_part('content','top');?>
<?php
global $cupid_data,$cupid_archive_loop;

$use_custom_layout = get_post_meta(get_the_ID(),'use-custom-layout',true);
$archive_layout = get_post_meta(get_the_ID(),'page-layout',true);

if (!isset($archive_layout) || empty($archive_layout) || $archive_layout == 'none' || $use_custom_layout == '0') {
    $archive_layout = $cupid_data['post-archive-layout'];
}

$class_col = 'col-md-12';
if (function_exists('dynamic_sidebar')&& is_active_sidebar('archive-classes-left-sidebar'))
    $class_col = 'col-md-9';

$meta_teacher = get_post_meta( get_the_ID(), 'teacher-class', true );
$post_teacher = get_posts(array(
    'name' => $meta_teacher,
    'posts_per_page' => 1,
    'post_type' => 'our-staffs',
    'post_status' => 'publish'
));
$teacher='';
if(count($post_teacher)>0){
    $teacher = $post_teacher[0]->post_title;
}

$month_old = get_post_meta( get_the_ID(), 'month-olds', false );
$class_size = get_post_meta( get_the_ID(), 'class-size', false );
$enroll = get_post_meta( get_the_ID(), 'enroll-link', false );
$title_structure = get_post_meta( get_the_ID(), 'title_structure', true );
$class_structure = get_post_meta( get_the_ID(), 'class_structure', true );
$title_overview = get_post_meta( get_the_ID(), 'title_overview', true );
$class_overview = get_post_meta( get_the_ID(), 'overview', true );
$title_requirement = get_post_meta( get_the_ID(), 'title_requirement', true );
$class_entry_requirement = get_post_meta( get_the_ID(), 'entry_requirement', true );
$enroll_link = '#';
if(count($enroll)>0 && $enroll!='')
    $enroll_link =$enroll[0]

?>
<main role="main" class="cupid-classes-content">
    <div class="container clearfix">
        <div class="row clearfix">
            <div class="<?php echo esc_attr($class_col); ?>">
                <div class="blog-wrapper">
                    <div class="blog-nav">
                        <?php cupid_the_breadcrumb(); ?>
                    </div>
                    <div class="class-attribute small-size hidden-md hidden-lg">
                        <div class="teacher bg-second">
                            <span><?php echo __('Teachers','cupid')?></span>
                            <span>
                                <a href="<?php if(count($post_teacher) >0){ echo  esc_attr(get_the_permalink($post_teacher[0]->ID)); } else{ echo '#';} ?>">
                                    <?php echo esc_html($teacher);?>
                                </a>
                            </span>
                        </div>
                        <div class="year-olds bg-orgin">
                            <span><?php echo __('Month olds','cupid')?></span>
                            <span>
                                <?php  if(count($month_old)>0){ echo esc_html($month_old[0]);};?>
                            </span>
                        </div>
                        <div class="class-size bg-second">
                            <span><?php echo __('Class size','cupid')?></span>
                                <span>
                                    <?php  if(count($class_size)>0){ echo esc_html($class_size[0]);};?>
                                </span>
                        </div>
                        <div class="enroll-wrap">
                            <div class="enroll">
                                <a href="<?php echo esc_url($enroll_link) ?>"><?php  _e('Enroll your child','cupid'); ?></a>
                            </div>
                        </div>
                    </div>

                    <div  class="blog-inner blog-single clearfix">
                        <?php
                        if ( have_posts() ) :
                            // Start the Loop.
                            while ( have_posts() ) : the_post();
                                get_template_part( 'content', get_post_type() );
                            endwhile;
                        else :
                            get_template_part( 'content', 'none' );
                        endif;
                        ?>
                    </div>
                </div>
                <?php if(  (isset($class_overview) && !empty($class_overview) ) ||
                           (isset($class_structure) && !empty($class_structure) ) ||
                           (isset($class_entry_requirement) && !empty($class_entry_requirement) )
                         ) {?>
                <div class="overview" rol="tab-overview">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php if(!empty($title_overview) && !empty($class_overview)) {?>
                            <li role="presentation" class="active"><a href="#class-overview" aria-controls="home" role="tab" data-toggle="tab"><?php echo esc_html($title_overview); ?></a></li>
                        <?php } ?>
                        <?php if(!empty($title_structure) && !empty($class_structure)) {?>
                            <li role="presentation"><a href="#class-structure" aria-controls="profile" role="tab" data-toggle="tab"><?php echo esc_html($title_structure); ?></a></li>
                        <?php } ?>
                        <?php if(!empty($title_requirement) && !empty($class_entry_requirement)) {?>
                            <li role="presentation"><a href="#class-entry-requirement" aria-controls="messages" role="tab" data-toggle="tab"><?php echo esc_html($title_requirement); ?></a></li>
                        <?php } ?>
                    </ul>

                    <div class="tab-content">
                        <?php if(!empty($title_overview) && !empty($class_overview)) {?>
                            <div role="tabpanel" class="tab-pane fade in active" id="class-overview"><?php echo wp_kses_post($class_overview) ?></div>
                        <?php } ?>
                        <?php if(!empty($title_structure) && !empty($class_structure)) {?>
                            <div role="tabpanel" class="tab-pane fade in" id="class-structure"><?php echo wp_kses_post($class_structure) ?></div>
                        <?php } ?>
                        <?php if(!empty($title_requirement) && !empty($class_entry_requirement)) {?>
                            <div role="tabpanel" class="tab-pane fade in" id="class-entry-requirement"><?php echo wp_kses_post($class_entry_requirement) ?></div>
                        <?php } ?>
                    </div>

                </div>
                <?php } ?>

                <?php
                $meta = get_post_meta(get_the_ID(), 'cupid_classes_qa_settings', TRUE);
                if(isset($meta) && is_array($meta) && isset($meta['classes_qa'])){
                ?>
                    <div class="question-answer">
                        <div class="title">
                            <h4><?php _e('Questions & ','cupid') ?><span><?php _e('Answers','cupid') ?></span></h4>
                        </div>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <?php

                                $is_expand = 1;
                                $unique_tab_ids =  array_unique(array(count($meta['classes_qa'])));
                                $index = 1;
                                foreach ($meta['classes_qa'] as $col)
                                {
                                    $question = $col['qaQuestion'] ;
                                    $answer = $col['qaAnswer'] ;
                                    $unique_tab_id = 'qa_tab_'.($index++);
                                    if($is_expand==1){
                                        $expanded = 'true';
                                        $collapse = 'in';
                                        $is_expand = 0;
                                    }
                                    else{
                                        $expanded = 'false';
                                        $collapse = '';
                                    }


                                ?>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading_<?php echo esc_attr($unique_tab_id) ?>">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo esc_attr($unique_tab_id) ?>" aria-expanded="<?php echo esc_attr($expanded) ?>"  aria-controls="<?php echo esc_attr($unique_tab_id) ?>">
                                                    <?php echo wp_kses_post($question) ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="<?php echo esc_attr($unique_tab_id) ?>" class="panel-collapse collapse <?php echo esc_attr($collapse) ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($unique_tab_id) ?>">
                                            <div class="panel-body">
                                                <?php echo wp_kses_post($answer) ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                <?php }?>
                <?php comments_template('/comment-classes.php'); ?>
            </div>
            <div class="col-md-3 hidden-xs hidden-sm">
                <div class="class-attribute">
                        <div class="teacher bg-second">
                            <span><?php echo __('Teachers','cupid')?></span>
                            <span>
                                <a href="<?php if(count($post_teacher) >0){ echo  esc_attr(get_the_permalink($post_teacher[0]->ID)); } else{ echo '#';} ?>">
                                    <?php echo esc_html($teacher);?>
                                </a>
                            </span>
                        </div>
                        <div class="year-olds bg-orgin">
                            <span><?php echo __('Month olds','cupid')?></span>
                            <span>
                                <?php  if(count($month_old)>0){ echo esc_html($month_old[0]);};?>
                            </span>
                        </div>
                        <div class="class-size bg-second">
                            <span><?php echo __('Class size','cupid')?></span>
                                <span>
                                    <?php  if(count($class_size)>0){ echo esc_html($class_size[0]);};?>
                                </span>
                        </div>
                        <div class="enroll-wrap">
                            <div class="enroll">
                                <a href="<?php echo esc_url($enroll_link) ?>"><?php  _e('Enroll your child','cupid'); ?></a>
                            </div>
                        </div>
                </div>
                <?php if (function_exists('dynamic_sidebar')&& is_active_sidebar('archive-classes-left-sidebar')){ ?>
                    <div class="sidebar">
                        <?php dynamic_sidebar('archive-classes-left-sidebar'); ?>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</main>


<?php get_footer(); ?>

