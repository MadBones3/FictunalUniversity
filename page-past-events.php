<?php get_header(); 
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'Recap of our past events'
))
?>

<div class="container container--narrow page-section">
  <?php
    $today = date('Ymd');
    // load past events
    $pastEvents = new WP_Query(array(
        // paged for pagination
        'paged' => get_query_var('paged', 1),
        'posts_per_page' => '-1',
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'order_by' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric'
          )
        )
    ));


  while ($pastEvents->have_posts()) {
    $pastEvents->the_post(); 

    get_template_part('/templates/content-event');

  }
//   pagination for custom query, to get the max number of pages to show
  echo paginate_links(array(
      'total' => $pastEvents->max_num_pages
  ));

  ?>

</div>
<?php get_footer(); ?>