<?php get_header(); ?>
<div class="container">
   <div class="aplication-page">
   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
         <div class="box">
            <ol id="breadcrumbs">
               <li><a href="<?php bloginfo('url'); ?>">Home</a> /</li>
               <li><a href="<?php bloginfo('url'); ?>/blog/">Blog</a></li>
            </ol>
            <h1 class="box-title"><?php the_title(); ?></h1>
            <?php px_blog_postmeta(); ?>
            <?php px_botones_sociales(); ?>
            <div class="entry"><?php px_the_content(); ?></div>
         </div>
      <?php echo ads("ads_single_top"); ?> 
      <?php
      $post_tags = wp_get_post_tags($post->ID);
      if(!empty($post_tags)) {?>
         <div class="box etiquetas"><h2>TAGS</h2><?php the_tags('', ''); ?></div> 
      <?php } ?> 
      <?php comments_template(); ?> 
   <?php endwhile; endif; ?>
   </div>
   <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>