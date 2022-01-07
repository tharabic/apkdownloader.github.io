<?php get_header(); ?>
	<div class="container">
    	<div class="section">
            <div class="title-section"><?php echo __( 'TAG', 'appyn' ); ?>: <?php echo single_tag_title("", false); ?></div>
            <?php if( !empty(tag_description()) ) { ?>
            <div class="ct_description"><?php echo tag_description(); ?></div>
            <?php
            }
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