<?php get_header(); 
pageBanner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have several campuses'
))
?>

<div class="container container--narrow page-section">
    <ul class="link-list min-list">
    <?php
    
    while (have_posts()) {
        the_post(); ?>

        <li>
            <a href="<?php the_permalink();?>">
                <h3><?php the_title();?></h3>
            </a>
            <p><?php echo the_field('street_address');?></p>
        </li>
        
    <?php } ?>
  </ul>

</div>
<?php get_footer(); ?>