<?php get_header(); ?>
  <div class="container">
   <div class="page-woocommerce">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
	<?php endwhile; endif; wp_reset_query(); ?>
   </div>
   <?php get_sidebar(); ?>
  </div>
<?php get_footer(); ?>