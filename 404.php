<?php get_header(); ?>
	<div class="container">
    	<div class="section error404">
        	<h1>404</h1>
            <h2><?php echo __( 'La página que estás buscando no existe.', 'appyn' ); ?></h2>
        	<form action="<?php bloginfo('url'); ?>">
            	<input type="text" name="s" required placeholder="<?php echo __( 'Buscar una aplicación', 'appyn' ); ?>">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
<?php get_footer(); ?>