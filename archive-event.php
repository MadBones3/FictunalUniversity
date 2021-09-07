<?php get_header(); 
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world!'
))
?>


<div class="container container--narrow page-section">
  <?php
  while (have_posts()) {
    the_post(); 

    get_template_part('/templates/content-event');

  }
  echo paginate_links();

  ?>
  <hr class="section-break">
  <p>Looking for a recap for Past Events? <a href="<?php echo site_url('/past-events');?>">See them here.</a></p>

</div>
<?php get_footer(); ?>