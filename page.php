<?php get_header(); ?>
  <div class="container">
   <div class="aplication-page">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       <div class="box">
        <div id="breadcrumbs">
            <a href="<?php bloginfo('url'); ?>">Home</a> /
        </div>
        <h1 class="box-title"><?php the_title(); ?></h1>
        <div class="px-postmeta">
        	<span><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php the_time('j M, Y') ?></span> <span><i class="fa fa-user" aria-hidden="true"></i> <?php the_author_link(); ?></span> <span><i class="fa fa-comments-o" aria-hidden="true"></i> <?php comments_number(); ?></span>
        </div>
        <div class="box-social">
			<?php get_template_part('template-parts/botones_sociales'); ?>
        </div>
        <div class="entry"><?php px_the_content(); ?></div>
       </div>        
	<?php comments_template(); ?> 
	<?php endwhile; endif; ?>
   </div>
   <?php get_sidebar(); ?>
  </div>
<?php get_footer(); ?>