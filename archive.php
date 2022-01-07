<?php get_header(); ?>
	<div class="container">
    	<div class="section">
            <div class="title-section">
				<?php
                if( is_year() ){
                    echo __( 'Apps', 'appyn' ).': '.get_the_time('Y');    
                } 
                if( is_month() ){
                    echo __( 'Apps', 'appyn' ).': '.get_the_time('F, Y');
                } 
                if( is_author() ){
                    echo __( 'Apps de', 'appyn' ).': '.get_the_author();
                } else {
					echo post_type_archive_title( '', false );
				}
                ?>
            </div>
            <?php
            $i = 1;
            if( have_posts() ):
            ?> 
            <div class="bloque-apps">
                <?php
				while( have_posts() ) : the_post();
                    get_template_part( 'template-parts/loop/app' );
                    if( $i == 6) {
                        if( !wp_is_mobile( ) )
                            echo '</div>'.ads("ads_home").'<div class="bloque-apps">';
                    }
                    $i++; 
                endwhile;
                ?>
            </div>
            <?php paginador();
            else: 
                echo '<div class="no-entries"><p>'.__( 'No hay entradas', 'appyn' ).'</p></div>';
            endif; ?>
    	</div>
   </div>
<?php get_footer(); ?>