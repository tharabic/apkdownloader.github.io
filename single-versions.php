<?php get_header(); ?>
	<div class="container">
		<div class="aplication-single">
			<?php 
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 	
			?>
				<div class="box box-versions">
					<?php 
					$datos_download = get_datos_download();
					$get_download = get_query_var( 'download' );
					?>
					<div class="right s2">
						<?php px_breadcrumbs(); ?>
						<?php 
						$datos_informacion = get_post_meta($post->ID, 'datos_informacion', true); ?>
						<h1 class="box-title">
							<?php 
							$title = get_the_title(); 
							echo ( str_replace( @$datos_informacion['version'], '', $title ) );  
							?>
						</h1><?php echo ( !empty(@$datos_informacion['version']) ) ? '<h4 class="version">'.@$datos_informacion['version'].'</h4>' : ''; ?>
						<div class="clear"></div>
    					<div class="meta-cats"><?php echo px_pay_app(); ?><?php the_category(); ?></div>
					</div>
					<div class="left s1">
    					<?php echo px_post_thumbnail( 'thumbnail', $post, true ); ?>
						<a href="<?php the_permalink(); ?>" class="downloadAPK"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?php echo __( 'Regresar', 'appyn' ); ?></a>
					</div>
				</div>
				<?php echo do_action( 'func_caja_versiones', true );
			endwhile; endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>