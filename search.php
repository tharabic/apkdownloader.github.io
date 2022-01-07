<?php get_header(); ?>
	<div class="container">
    	<div class="section">
            <div class="title-section">
				<?php echo __( 'Buscar', 'appyn' ); ?>: <?php the_search_query(); ?>
            </div>
            <?php if( have_posts() ): ?>
            <div class="bloque-apps"> 
				<?php while( have_posts() ): the_post();
				get_template_part( 'template-parts/loop/app' );
				endwhile; ?>
            </div>
			<?php paginador();
            else: 
                echo '<div class="no-entries"><p>'.__( 'No hay entradas', 'appyn' ).'</p></div>';
            endif; ?>
    	</div>
   </div>
<?php get_footer(); ?>