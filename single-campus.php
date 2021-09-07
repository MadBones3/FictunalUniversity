<?php get_header(); 
pageBanner();
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus');?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Campuses </a> 
            <span class="metabox__main"><?php the_field('street_address');?></span>
        </p>
    </div>
    <div class="generic-content">
        <?php the_content() ?>

    </div>

    <?php 
    $today = date('Ymd');
/* =========================================================
=== Pull programs based on ACF data
============================================================*/ 
    $relatedPrograms = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'program',
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
        // filters/ query db
        array(
            'key' => 'related_campus',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'
        ),
        )
    ));
    
    // Test if there are any Programs
    if($relatedPrograms->have_posts()) {

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Programs Available at this campus</h2>';
        echo '<ul class="min-list link-list">';
        while($relatedPrograms->have_posts()) {
            $relatedPrograms->the_post(); ?>

            <li>
                <a href="<?php the_permalink();?>"><?php the_title();?></a>
            </li>

        <?php }
        echo '</ul>';
    }

    wp_reset_postdata();

?>
</div>

<?php get_footer(); ?>