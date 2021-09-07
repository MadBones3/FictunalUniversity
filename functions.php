<?php
// Load CSS+JS
function resources() {
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,400;1,700');
    wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

}
add_action('wp_enqueue_scripts','resources');

// Theme support
function Theme_Support() {
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footer1', 'Footer 1');
    register_nav_menu('footer2', 'Footer 2');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

// custom crop image sizes
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);

}
add_action('after_setup_theme', 'Theme_Support');

/* ========= Post types are in the folder mu-pligins in root. =========== */



function uni_adjust_queries($query) {

// Pull latest Event post types based on ACF data in event archive
    if( !is_admin() && is_post_type_archive('event') && $query-> is_main_query() ) {
        $today = date('Ymd');
        $query -> set('meta_key', 'event_date');
        $query -> set('orderby', 'meta_value_num');
        $query -> set('order', 'ASC');
        $query -> set('meta_query', array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            )
          )
        );
    }

// Pull Program query in program archive
    if( !is_admin() && is_post_type_archive('program') && $query-> is_main_query() ) {
        $query -> set('orderby', 'title');
        $query -> set('order', 'ASC');
        $query -> set('posts_per_page', -1);
    }

// Pull campus query in campus archive
    if( !is_admin() && is_post_type_archive('campus') && $query-> is_main_query() ) {
        $query -> set('posts_per_page', -1);
    }
    
}
add_action('pre_get_posts', 'uni_adjust_queries');

/* ===========================================
========== page banner functuion =========================
============================================*/

// args = null makes it optional to have values
function pageBanner($args = NULL) { 
    // no title
    if( !$args['title'] ) {
        $args['title'] = get_the_title();
    }
    // no subtitle
    if( !$args['subtitle'] ) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    // no page banner
    if( !$args['photo'] ) {
        // if has acf field
        if( get_field('page_banner_background_image') && !is_archive() && !is_home() ) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }

    }
    
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle'];?></p>
        </div>
    </div>
</div>

<?php }