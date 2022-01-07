<?php
/*
Template name: Blog
*/
get_header(); ?>
	<div class="container">
    	<div class="section blog">
        	<?php
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$blog_posts_limite = get_option( 'appyn_blog_posts_limite' );
			$blog_posts_limite = (empty($blog_posts_limite)) ? '10' : $blog_posts_limite;
			$args = array( 'post_type' => 'blog', 'posts_per_page' => $blog_posts_limite, 'paged' => $paged );
			$query = new WP_Query( $args );
			if( $query->have_posts() ): ?>
            <div class="title-section">
				<?php the_title(); ?>
            </div>
            <ul class="bloques">
            <?php 
			$i = 1;
			while( $query->have_posts() ): $query->the_post(); ?>
                <?php get_template_part( 'template-parts/loop/blog' ); ?>
                <?php if($i == 6) { ?>
                    <?php if( !wp_is_mobile() ) { echo ads( "ads_home" ); } ?> 
                <?php } ?>
			<?php $i++; endwhile; ?>
            </ul>
            <?php paginador( $query, $blog_posts_limite );
			endif; 
			wp_reset_query(); 
			?>
    	</div>
        <?php get_sidebar(); ?>
   </div>
<?php get_footer(); ?>