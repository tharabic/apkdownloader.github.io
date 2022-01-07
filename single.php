<?php get_header(); ?>
	<div class="container">
		<div class="aplication-single">
			<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 	
				
				$get_download = get_query_var( 'download' );
			?>
				<div class="box<?php echo ($get_download == "true" || $get_download == "redirect" || $get_download == "links") ? ' box-download': ''; ?>">
					<?php
					if( $get_download ) { 
						get_template_part( 'template-parts/single-infoapp-get' );
					} else {
						get_template_part( 'template-parts/single-infoapp' );
					} 
					?>
					<div class="right s2 box-social">
						<?php echo px_botones_sociales(); ?>
					</div>
				</div>
				<?php 
				echo do_action( 'box_report' );
				echo ads("ads_single_top"); 
				echo do_action( 'seccion_cajas' );

				$cvn = (get_option('appyn_versiones_no_cajas')) ? get_option('appyn_versiones_no_cajas') : array(1);
				if( ( $post->post_parent == 0 || !in_array( 'comentarios', $cvn ) ) ) {
					comments_template();
				}
			endwhile; endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>