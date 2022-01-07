<?php get_header(); ?>
	<div class="container">
    	<div class="section blog">
        	<?php
			if( have_posts() ): ?>
            <div class="title-section">
				<?php echo post_type_archive_title( '', false ); ?>
            </div>
            <ul class="bloques">
            <?php 
			$i = 1;
			while( have_posts() ): the_post(); ?>
                <?php get_template_part( 'template-parts/loop/blog' ); ?>
                <?php if($i == 6) { ?>
                    <?php if( !wp_is_mobile() ) { echo ads( "ads_home" ); } ?> 
                <?php } ?>
			<?php $i++; endwhile; ?>
            </ul>
            <?php paginador();
            else: 
                echo '<div class="no-entries"><p>'.__( 'No hay entradas', 'appyn' ).'</p></div>';
            endif; ?>
    	</div>
        <?php get_sidebar(); ?>
   </div>
<?php get_footer(); ?>