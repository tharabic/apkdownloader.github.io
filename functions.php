<?php

if( ! defined( 'ABSPATH' ) ) die ( '✋' );

define( 'VERSIONPX', '2.0.9' );
define( 'THEMEPX', 'appyn' );
define( 'AMP_QUERY_VAR', apply_filters( 'amp_query_var', 'amp' ) );
define( 'API_URL', 'https://api.themespixel.net' );

add_action( 'after_setup_theme', 'px_theme_setup' );

function px_theme_setup() {
		
	add_theme_support( 'nav-menus' );

	register_nav_menus(array('menu' => __('menu')));

	register_nav_menus(array('menu-mobile' => __('menu movil')));

	register_nav_menus(array('menu-footer' => __('menu footer')));
		
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'miniatura', 75, 75, true );

	add_image_size( 'medio', 128, 128, true );

	add_theme_support( 'title-tag' );

	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	load_theme_textdomain( 'appyn', get_template_directory() . '/languages' );

}

add_action( 'widgets_init', 'px_widget_init' );

function px_widget_init() {

	register_sidebar(array(
		'name' => 'sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
		)
	);

	register_sidebar(array(
		'name' => 'footer',
		'id' => 'sidebar-footer',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

}

add_action( 'after_switch_theme', 'px_default_options' );

function px_default_options(){
	$url = get_bloginfo('template_url');
	$options = array(
		'logo' => $url.'/images/logo.png',
		'favicon' => $url.'/images/favicon.ico', 
		'titulo_principal' => __( 'Theme Appyn para aplicaciones Android', 'appyn' ), 
		'descripcion_principal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fermentum erat ut massa venenatis, vitae ultrices sem dictum. Aliquam leo ipsum, bibendum nec dolor et.', 
		'image_header1' => $url.'/images/minecraft.png',
		'image_header2' => $url.'/images/free-fire.png',
		'image_header3' => $url.'/images/plantasvszombies2.png',
		'social_facebook' => '#',
		'social_twitter' => '#',
		'social_instagram' => '#',
		'social_youtube' => '#',
		'social_pinterest' => '#',
		'footer_texto' => '© '.date('Y').' - '.__( 'Derechos reservados', 'appyn' ).' - <a href="https://themespixel.net/appyn/" target="_blank" rel="nofollow noopener">Appyn Theme</a>',
		'home_limite' => 12,
		'categories_home_limite' => 6,
		'blog_posts_limite' => 10,
		'mas_calificadas_limite' => 5,
		'blog_posts_home_limite' => 4,	
		'comments' => 'wp',
		'color_theme' => 'claro',
		'readmore_single' => 0,
		'color_theme_principal' => '1bbc9b',
		'download_links' => 0,
		'social_single_color' => 'default',
		'appyn_amp' => 0,
		'redirect_timer' => 5,
		'download_timer' => 5,
		'edcgp_sapk_server' => 1,
		'edcgp_rating' => 1,
		'apps_info_download_apk' => sprintf( 
			"<p><strong>%s</strong></p><p>%s</p><p>%s</p><p>%s</p>", 
			__( '¿Cómo instalar [Title] APK?', 'appyn' ), 
			__( '1. Toca el archivo [Title] APK descargado.', 'appyn' ), 
			__( '2. Toca instalar.', 'appyn' ), 
			__( '3. Sigue los pasos que aparece en pantalla.', 'appyn' )
		),
		'apps_info_download_zip' => sprintf( 
			"<p><strong>%s</strong></p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p>", 
			__( '¿Cómo instalar [Title]?', 'appyn' ), 
			__( '1. Descargar el archivo ZIP.', 'appyn' ), 
			sprintf( __( '2. Instale la aplicación %s', 'appyn' ), '<a href="https://play.google.com/store/apps/details?id=com.aefyr.sai" target="_blank">Split APKs Installer</a>'), 
			__( '3. Abra la aplicación y pulse en "Instalar APKs".', 'appyn' ),
			__( '4. Busque la carpeta donde se encuentra el ZIP descargado y selecciónelo.', 'appyn' ),
			__( '5. Sigue los pasos que aparece en pantalla.', 'appyn' )			
		),
		'general_text_edit' => array(
			'amc' => __( 'Aplicaciones más calificadas', 'appyn' ),
			'uadnw' => __( 'Últimas aplicaciones de nuestra web', 'appyn' ),
			'bua' => __( 'Buscar una aplicación', 'appyn' ),
		),
	);

	foreach($options as $key => $value){
		$getoption = get_option( 'appyn_'.$key );
		if(empty($getoption)) {
			update_option( 'appyn_'.$key, $value );
		}
	}

	if( ! get_option( 'run_first_time_cron' ) ) {
		px_appyn_hook_send_apps();
		update_option( 'run_first_time_cron', 1 );
	}
}

add_action( 'init', 'default_info_download_apk_zip');
function default_info_download_apk_zip() {
	update_option( 'appyn_apps_default_info_download_apk', sprintf( 
		"<p><strong>%s</strong></p><p>%s</p><p>%s</p><p>%s</p>", 
		__( '¿Cómo instalar [Title] APK?', 'appyn' ), 
		__( '1. Toca el archivo [Title] APK descargado.', 'appyn' ), 
		__( '2. Toca instalar.', 'appyn' ), 
		__( '3. Sigue los pasos que aparece en pantalla.', 'appyn' )
	) );
	update_option( 'appyn_apps_default_info_download_zip', sprintf( 
		"<p><strong>%s</strong></p><p>%s</p><p>%s</p><p>%s</p><p>%s</p><p>%s</p>", 
		__( '¿Cómo instalar [Title]?', 'appyn' ), 
		__( '1. Descargar el archivo ZIP.', 'appyn' ), 
		sprintf( __( '2. Instale la aplicación %s', 'appyn' ), '<a href="https://play.google.com/store/apps/details?id=com.aefyr.sai" target="_blank">Split APKs Installer</a>'), 
		__( '3. Abra la aplicación y pulse en "Instalar APKs".', 'appyn' ),
		__( '4. Busque la carpeta donde se encuentra el ZIP descargado y selecciónelo.', 'appyn' ),
		__( '5. Sigue los pasos que aparece en pantalla.', 'appyn' )			
	) );
}

add_action( 'init', 'blog_register' ); 

function blog_register(){
	$labels = array(
		'name' => 'Blog',
	);
	$args = array(
		'exclude_from_search' => true, 
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'blog'),
		'has_archive' => true,
		'show_in_rest' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title','editor','thumbnail','comments'),
	); 
	register_post_type('blog', $args );
}

add_action( 'init', 'dev_taxonomy_register' );

function dev_taxonomy_register() {
	register_taxonomy(
		'dev',
    	'post',
    	array(
      		'label' => __( 'Desarrollador', 'appyn' ),
      		'sort' => true,
      		'args' => array('orderby' => 'term_order'),
			'show_in_rest' => true,
      		'rewrite' => array('slug' => 'dev'),
	  		'labels' => array('menu_name' => __( 'Desarrollador', 'appyn' ))
    	)
  	);
	register_taxonomy(
		'cblog',
		'blog',
    	array(
      		'label' => __( 'Categorías', 'appyn' ),
      		'sort' => true,
      		'args' => array('orderby' => 'term_order'),
			'show_in_rest' => true,
			'rewrite' => array('slug' => 'cblog'),
	  		'labels' => array('menu_name' => __( 'Categorías', 'appyn' ))
		)
  	);
}

add_action( 'init', 'add_analytic_rewrite_rule' );

function add_analytic_rewrite_rule() {	
    add_rewrite_rule( '^([^/]*)/versions/?$', 'index.php?name=$matches[1]&section=versions', 'top' );
}

add_filter( 'query_vars', 'analytics_rewrite_add_var');

function analytics_rewrite_add_var( $vars ) {
    $vars[] = 'section';
    return $vars;
}

add_action( 'wp', 'px_404_versiones' );

function px_404_versiones() {
	global $post;
	if ( get_query_var('section') == __( 'versiones', 'appyn' ) && $post->post_parent ) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
	}
}

add_action( 'wp', 'px_wp_post_views');

function px_wp_post_views(){
	global $post;
	if( !is_single() ) {
		return;
	}
	setPostViews( $post->ID );
}

add_action( 'wp', 'new_rating_db' );

function new_rating_db() {
	global $wpdb;
	$table_name = $wpdb->prefix."ap_rating";
	if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) != $table_name ) return;

	$results = $wpdb->get_results( "SELECT *, COUNT(rating_count) users, SUM(rating_count) total_rating FROM $table_name GROUP BY post_id", 'OBJECT' );
	if( $results ) {
		// Limpiar tabla
			$wpdb->query( "DROP TABLE IF EXISTS $table_name");	
		foreach( $results as $r ) {	
			update_post_meta( $r->post_id, 'new_rating_users', $r->users );
			update_post_meta( $r->post_id, 'new_rating_count', $r->total_rating );
			update_post_meta( $r->post_id, 'new_rating_average', number_format(($r->total_rating / $r->users), 1, ".", "") );	
		}
	}
}

add_action( 'wp', 'new_views' );

function new_views() {
	global $wpdb;
	$table_name = $wpdb->prefix."views";
	if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) != $table_name ) return;

	$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."views_temp");
	
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."views" );

	if( !$results ) return;

	foreach( $results as $r ) {
		update_post_meta( $r->post_id, 'px_views', $r->total );
	}
	$wpdb->query( "DROP TABLE $table_name" );
}

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

add_filter( 'posts_where', 'wpse18703_posts_where', 10, 2 );

function wpse18703_posts_where($where, $wp_query){
    global $wpdb;
    if ( $wpse18703_title = $wp_query->get( 'wpse18703_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $wpse18703_title ) ) . '%\'';
    }
    return $where;
}

add_action( 'add_meta_boxes', 'datos_meta_boxes' );  

function datos_meta_boxes(){  
	add_meta_box('datos_informacion', __( 'Información de la aplicación', 'appyn' ), 'callback_informacion', 'post', 'normal');  
	add_meta_box('datos_video',  __( 'Video de la aplicación', 'appyn' ), 'callback_video', 'post', 'normal');  
	add_meta_box('datos_imagenes', __( 'Imágenes de la aplicación', 'appyn' ), 'callback_imagenes', 'post', 'normal');  
	add_meta_box('datos_download', __( 'Enlaces de descarga de la aplicación', 'appyn' ), 'datos_download', 'post', 'normal');  
	add_meta_box('custom_boxes', __( 'Cajas personalizadas', 'appyn' ), 'custom_boxes', 'post', 'normal');  
	add_meta_box('permanent_custom_boxes', __( 'Cajas personalizadas permanentes', 'appyn' ), 'permanent_custom_boxes', 'post', 'normal');  
	add_meta_box('box_ads_control', __( 'Control de anuncios', 'appyn' ), 'callback_box_ads_control', array('post', 'page', 'blog'), 'normal');  
}  

function callback_box_ads_control($post){
	$ac = appyn_gpm( $post->ID, 'appyn_ads_control' );

	echo '<p><label><input type="checkbox" name="appyn_ads_control" value="1" '.checked( 1, $ac, false ).'> '.__( 'Desactivar anuncios', 'appyn' ). '</label></p>';
}

function permanent_custom_boxes($post){
	$pcb = get_option( 'permanent_custom_boxes' );
	echo '<div id="permanent-boxes-content">';
	if( !empty($pcb) && is_array($pcb) ) {
		$i = 0;
		foreach($pcb as $box_key => $box_value) : $i++;
			if( !empty( $box_value['title'] ) || !empty( $box_value['content'] ) ) { ?>
			<div class="boxes-a">
				<h4><?php echo sprintf( __( 'Caja permanente %s', 'appyn' ), '#'.$i ); ?></h4>
				<p><input type="text" id="permanent_custom_boxes-title" class="widefat" name="permanent_custom_boxes[<?php echo $box_key; ?>][title]" value="<?php echo $box_value['title']; ?>" placeholder="<?php echo __( 'Título para la caja', 'appyn' ); ?>"></p>

				<p><?php wp_editor_fix($box_value['content'], 'permanent_custom_boxes-'.$box_key, array('textarea_name' => 'permanent_custom_boxes['.$box_key.'][content]', 'textarea_rows' => 5)); ?>
				</p>
				<p><a href="javascript:void(0)" class="delete-boxes button"><?php echo __( 'Borrar caja', 'appyn' ); ?></a></p>
			</div>
<?php } endforeach; 
	}
	echo '</div>';
	echo '<a href="javascript:void(0)" id="add-permanent-boxes" class="button">+ '.__( 'Añadir caja', 'appyn' ).'</a>'; ?>
<?php
}

function custom_boxes($post){
	$custom_boxes = get_post_meta($post->ID, 'custom_boxes', true);
	echo '<div id="boxes-content">';
	if(!empty($custom_boxes)) {
		foreach($custom_boxes as $box_key => $box_value) : 
			if( !empty( $box_value['title'] ) || !empty( $box_value['content'] ) ) { ?>
<div class="boxes-a">
    <p><input type="text" id="custom_boxes-title" class="widefat" name="custom_boxes[<?php echo $box_key; ?>][title]"
            value="<?php echo $box_value['title']; ?>"
            placeholder="<?php echo __( 'Título para la caja', 'appyn' ); ?>"></p>

    <p><?php wp_editor_fix($box_value['content'], 'custom_boxes-'.$box_key, array('textarea_name' => 'custom_boxes['.$box_key.'][content]', 'textarea_rows' => 5)); ?>
    </p>
    <p><a href="javascript:void(0)" class="delete-boxes button"><?php echo __( 'Borrar caja', 'appyn' ); ?></a></p>
</div>
<?php } endforeach; 
	}
	echo '</div>';
	echo '<a href="javascript:void(0)" id="add-boxes" class="button">+ '.__( 'Añadir caja', 'appyn' ).'</a>'; ?>
<?php
}

function px_label_help($t) {
	return '<div class="px-label-info"><span class="dashicons dashicons-editor-help"></span><div class="pxli-content">'.$t.'</div></div>';
}

function callback_informacion($post){
?>
<div><?php echo __( 'Estado de aplicación', 'appyn' ); ?>:
    <?php echo px_label_help( __('Con esta opción aparecerá una franja en cada aplicación lo cual indicará si se ha actualizado o es una aplicación nueva. La opción activa tendrá un tiempo de duración de 2 semanas basada en la fecha de publicación del post. Por ejemplo, si usted marca "Actualizado" y la fecha de creación del post es hoy, la franja aparecerá solo por 2 semanas.', 'appyn' )); ?>
    <select name="datos_informacion[app_status]" id="app_status">
        <option value=""><?php echo __( 'Ninguno', 'appyn' ); ?></option>
        <option value="new" <?php selected( get_datos_info('app_status'), 'new' ); ?>>
            <?php echo __( 'Nuevo', 'appyn' ); ?></option>
        <option value="updated" <?php selected( get_datos_info('app_status'), 'updated' ); ?>>
            <?php echo __( 'Actualizado', 'appyn' ); ?></option>
    </select>
</div>

<p><?php echo __( 'Descripción', 'appyn' ); ?>:<br>
    <textarea class="widefat" name="datos_informacion[descripcion]"
        id="descripcion"><?php echo get_datos_info('descripcion'); ?></textarea>
</p>

<p><?php echo __( 'Versión', 'appyn' ); ?>:<br>
    <input type="text" class="widefat" name="datos_informacion[version]" id="version"
        value="<?php echo strip_tags(get_datos_info('version')); ?>">
</p>

<p><?php echo __( 'Tamaño', 'appyn' ); ?>:<br>
    <input type="text" class="widefat" name="datos_informacion[tamano]" id="tamano"
        value="<?php echo strip_tags(get_datos_info('tamano')); ?>">
</p>

<p><?php echo __( 'Última actualización', 'appyn' ); ?>:<br>
    <input type="text" class="widefat" name="datos_informacion[fecha_actualizacion]" id="fecha_actualizacion"
        value="<?php echo strip_tags(get_datos_info('fecha_actualizacion')); ?>">
</p>

<p><?php echo __( 'Requerimientos', 'appyn' ); ?>:<br>
    <input type="text" class="widefat" name="datos_informacion[requerimientos]" id="requerimientos"
        value="<?php echo strip_tags(get_datos_info('requerimientos')); ?>">
</p>

<p><?php echo __( 'Consíguelo en', 'appyn' ); ?>:<br>
    <input type="text" class="widefat" name="datos_informacion[consiguelo]" id="consiguelo"
        value="<?php echo get_datos_info('consiguelo'); ?>">
</p>

<?php	
	$new_rating_average = ( get_post_meta( $post->ID, 'new_rating_average', true ) ) ? get_post_meta( $post->ID, 'new_rating_average', true ) : 0;
	$new_rating_users = ( get_post_meta( $post->ID, 'new_rating_users', true ) ) ? get_post_meta( $post->ID, 'new_rating_users', true ) : 0;
	?>
<p><?php echo __( 'Rating', 'appyn' ); ?> (<?php echo __( 'Número de votos', 'appyn' ); ?>):<br>
    <input type="number" min="0" class="widefat" name="new_rating_users" id="new_rating_users"
        value="<?php echo @$new_rating_users; ?>">
</p>

<p><?php echo __( 'Rating', 'appyn' ); ?> (<?php echo __( 'Media', 'appyn' ); ?>):<br>
    <input type="number" min="0" step="0.1" class="widefat" name="new_rating_average" id="new_rating_average"
        value="<?php echo @$new_rating_average; ?>" placeholder="4.5">
</p>

<p><?php echo __( 'Tipo de aplicación (Categoría)', 'appyn' ); ?>:
    <select name="datos_informacion[categoria_app]">
        <?php
	$catsapp = array(
		'GameApplication' => __( 'Juegos', 'appyn' ), 
		'SocialNetworkingApplication' => __( 'Social', 'appyn' ), 
		'TravelApplication' => __( 'Viajes', 'appyn' ), 
		'ShoppingApplication' => __( 'Compras', 'appyn' ), 
		'SportsApplication' => __( 'Deportes', 'appyn' ), 
		'LifestyleApplication' => __( 'Estilo de vida', 'appyn' ), 
		'BusinessApplication' => __( 'Empresa', 'appyn' ), 
		'DesignApplication' => __( 'Arte y Diseño', 'appyn' ),
		'DriverApplication' => __( 'Automoción', 'appyn' ), 
		'EducationalApplication' => __( 'Educación', 'appyn' ), 
		'HealthApplication' => __( 'Salud', 'appyn' ), 
		'FinanceApplication' => __( 'Financias', 'appyn' ), 
		'SecurityApplication' => __( 'Seguridad', 'appyn' ),
		'CommunicationApplication' => __( 'Comuninación', 'appyn' ), 
		'EntertainmentApplication' => __( 'Entretenimiento', 'appyn' ), 
		'MultimediaApplication' => __( 'Multimedia', 'appyn' ), 
		'HomeApplication' => __( 'Casa y hogar', 'appyn' ), 
		'UtilitiesApplication' => __( 'Herramientas', 'appyn' ), 
		'ReferenceApplication' => __( 'Libros y referencia', 'appyn' )
	); 
	
	foreach( $catsapp as $key => $cat ) {
		echo '<option value="'.$key.'"'.selected( get_datos_info('categoria_app'), $key, false ).'>'.$cat.'</option>';
	} ?></select>
</p>

<p><?php echo __( 'Sistema operativo', 'appyn' ); ?>:
    <label><input type="radio" name="datos_informacion[os]" value="ANDROID"
            <?php checked( get_datos_info('os'), 'ANDROID' ); ?>
            <?php echo (!isset( $datos_informacion['os'] ) ? 'checked' : ''); ?>> Android</label>&nbsp;
    <label><input type="radio" name="datos_informacion[os]" value="iOS"
            <?php checked( get_datos_info('os'), 'iOS' ); ?>> iOS</label>&nbsp;
    <label><input type="radio" name="datos_informacion[os]" value="MAC"
            <?php checked( get_datos_info('os'), 'MAC' ); ?>> Mac</label>&nbsp;
    <label><input type="radio" name="datos_informacion[os]" value="WINDOWS"
            <?php checked( get_datos_info('os'), 'WINDOWS' ); ?>> Windows</label>
</p>

<p><label><input type="radio" name="datos_informacion[offer][price]" value="gratis"
            <?php echo ( (empty(get_datos_info('offer', 'price') || get_datos_info('offer', 'price') == "gratis") ) ? ' checked' : ''); ?>>
        <?php echo __( 'Gratis', 'appyn' ); ?></label> &nbsp;
    <label><input type="radio" name="datos_informacion[offer][price]" value="pago"
            <?php checked( get_datos_info('offer', 'price'), 'pago' ); ?>> <?php echo __( 'Pago', 'appyn' ); ?></label>
    <label><input type="text" name="datos_informacion[offer][amount]"
            value="<?php echo get_datos_info('offer', 'amount'); ?>" placeholder="1.00" style="width: 50px;"></label>
    <label><select name="datos_informacion[offer][currency]">
            <?php 
	$currencys = array( 'USD', 'EUR', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BTN', 'BWP', 'BYN', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'FJD', 'FKP', 'GBP', 'GEL', 'GGP', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'IMP', 'INR', 'IQD', 'IRR', 'ISK', 'JEP', 'JMD', 'JOD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRU', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'OMR', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDG', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'SSP', 'STN', 'SYP', 'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VES', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XDR', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW' );

	foreach( $currencys as $cur ) {
		echo '<option value="'.$cur.'"'.selected( get_datos_info('offer', 'currency'), $cur, true ).'>'.$cur.'</option>';
	} 
	?>
        </select>
</p>

<p><?php echo __( 'Novedades', 'appyn' ); ?>:<br>
    <?php wp_editor_fix( get_datos_info('novedades'), 'novedades', array('textarea_name' => 'datos_informacion[novedades]', 'textarea_rows' => 5)); ?>
</p>

<?php
}

function callback_video($post){
	$datos_video = get_post_meta($post->ID, 'datos_video', true);
?>
<p>ID YouTube:<br>
    <input type="text" class="widefat" id="id_video" name="datos_video[id]" placeholder="TkErUvyVlhA"
        value="<?php echo ( isset($datos_video['id']) ) ? $datos_video['id'] : ''; ?>">
</p>
<?php
}

function callback_imagenes($post){
	$datos_imagenes = get_post_meta($post->ID, 'datos_imagenes', true);
	$datos_imagenes = !empty($datos_imagenes) ? $datos_imagenes : array();
	$c = 4;
	$input_upload = '<input class="upload_image_button button" type="button" value="'.__( 'Subir', 'appyn' ).'" style="width:auto; vertical-align:middle; font-family:inherit">';
?>
<script>
jq1 = jQuery.noConflict();
jq1(function($) {
    var count = <?php echo $c; ?>;
    $(document).on('click', '.removeimage', function() {
        $(this).parents('p').remove();
        count--;
    });
    $(".addImg").on('click', function() {
        $(".ElementImagenes").append('<p><input type="text" name="datos_imagenes[' + count +
            ']" value="" class="regular-text upload"><?php echo @$input_upload; ?><a href="javascript:void(0)" class="removeimage">X</a></p>'
            );
        count++;
    });
});
</script>
<div class="ElementImagenes">
    <div class="download"></div>
    <?php 
	$n = 0;

	if(count($datos_imagenes)>10){

		foreach($datos_imagenes as $elemento) {
			echo '<p><input type="text" name="datos_imagenes['.$n.']" value="'.( ( !empty($datos_imagenes[$n])) ? $datos_imagenes[$n] : '').'"  id="imagenes'.$n.'" class="regular-text upload">'.$input_upload.'</p>';
			$n++; 
		}

    } else { 

		for($i=0;$i<10;$i++) {
			echo '<p><input type="text" name="datos_imagenes['.$i.']" value="'. ( (!empty($datos_imagenes[$i])) ? $datos_imagenes[$i] : '').'" id="imagenes'.$i.'" class="regular-text upload">'.$input_upload.'</p>';
		}  

	} 
    echo '</div>
    <p class="addImg button"><b>+ '.__( 'Añadir imágenes', 'appyn' ).'</b></p>';

	wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
}

function datos_download($post){
	$datos_download = get_datos_download();
?>
    <script type="text/javascript">
    jq1 = jQuery.noConflict();
    jq1(function($) {
        var count = $('.ElementLinks table tbody tr').length;
        $(document).on('click', '.removeLink', function() {
            $(this).parents('tr').remove();
            count--;
        });
        $(".addLink").on('click', function() {
            $(".ElementLinks table tbody").append('<tr><td><input type="text" name="datos_download[' +
                count +
                '][link]" value="" class="widefat"></td><td><input type="text" name="datos_download[' +
                count +
                '][texto]" value="" class="widefat"></td><td><label><input type="checkbox" value="1" name="datos_download[' +
                count +
                '][follow]"> Follow</label></td><td><a href="javascript:void(0)" class="removeLink button">x</a></td></tr>'
                );
            count++;
        });

        $('.dd-options li').on('click', function() {
            var option = $(this).data('option');
            $(this).parent().find('li').removeClass('active');
            $(this).addClass('active');
            $('.dd-content').hide();
            $('.dd-content[data-option="' + option + '"]').show();
        });
        $('.dd-options li.active').find('input[type=radio]').prop("checked", true);
    });
    </script>
    <div class="download-direct">
        <ul class="dd-options">
            <?php if(empty($datos_download['option'])) { ?>
				<li data-option="1" class="button active"><label><?php echo __( 'Enlaces de descarga', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="links" style="display:none;"></label></li>
				<li data-option="2" class="button"><label><?php echo __( 'Enlace directo / Redirección', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="direct-link" style="display:none;"></label>
				</li>
				<li data-option="3" class="button"><label><?php echo __( 'Descarga directa', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="direct-download" style="display:none;"></label></li>
            <?php } else { ?>
				<li data-option="1" class="button<?php echo (!$datos_download['option'] || $datos_download['option'] == "links") ? ' active': ''; ?>"><label><?php echo __( 'Enlaces de descarga', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="links" style="display:none;"></label></li>
				<li data-option="2" class="button<?php echo ($datos_download['option'] == "direct-link") ? ' active': ''; ?>"><label><?php echo __( 'Enlace directo / Redirección', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="direct-link" style="display:none;"></label></li>
				<li data-option="3" class="button<?php echo ($datos_download['option'] == "direct-download") ? ' active': ''; ?>"> <label><?php echo __( 'Descarga directa', 'appyn' ); ?><input type="radio" name="datos_download[option]" value="direct-download" style="display:none;"></label></li>
            <?php } ?>
        </ul>
    </div>
    <?php 	
	$ddf = (isset($datos_download['type'])) ? $datos_download['type'] : 'apk';
	?>
    <?php echo __( 'Tipo de archivos', 'appyn' ); ?>
    <?php echo px_label_help( sprintf( __( 'Marque qué tipo de archivo el usuario descargará. Gracias a esto podrá mostrar unos pasos según el tipo de opción escogida. <a href="%s">Ver/Editar los pasos</a>', 'appyn' ), admin_url('admin.php?page=appyn_panel#general') ) ); ?>

    <p>
        <input type="radio" name="datos_download[type]" value="apk" <?php echo checked($ddf, 'apk'); ?>>APK &nbsp;
        <input type="radio" name="datos_download[type]" value="apk_obb" <?php echo checked($ddf, 'apk_obb'); ?>>APK +
        OBB &nbsp;
        <input type="radio" name="datos_download[type]" value="zip" <?php echo checked($ddf, 'zip'); ?>>ZIP
    </p>
    <?php if(empty($datos_download['option'])) { ?>
    <div class="dd-content" data-option="1" style="display:block;">
        <?php } elseif(!$datos_download['option']) { ?>
        <div class="dd-content" data-option="1" style="display:block;">
            <?php } else { ?>
            <div class="dd-content" data-option="1"
                <?php echo ($datos_download['option'] == "links") ? ' style="display:block;"': ' style="display:none";'; ?>>
                <?php } ?>

                <p><em><?php echo __( 'Para eliminar un campo solo déjelo vacío', 'appyn' ); ?>.</em><br>
                    <em><?php echo __("Enlaces 'nofollow' por defecto", 'appyn'); ?>.</em>
                </p>
                <div class="ElementLinks">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:60%;"><?php echo __( 'Enlace', 'appyn' ); ?></th>
                                <th><?php echo __( 'Texto', 'appyn' ); ?></th>
                                <th><?php echo __( 'Atributo', 'appyn' ); ?></th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$list_count = !empty($datos_download['links_options']) ? count($datos_download['links_options']) : 3;

 							for( $i=0; $i<$list_count; $i++ ) {
								$link = isset($datos_download['links_options'][$i]['link']) ? $datos_download['links_options'][$i]['link'] : '';

								$text = isset($datos_download['links_options'][$i]['texto']) ? $datos_download['links_options'][$i]['texto'] : '';

								$follow = isset($datos_download['links_options'][$i]['follow']) ? $datos_download['links_options'][$i]['follow'] : '';
							?>
								<tr>
									<td><input type="text" name="datos_download[<?php echo $i; ?>][link]" value="<?php echo $link; ?>" class="widefat"></td>
									<td><input type="text" name="datos_download[<?php echo $i; ?>][texto]" value="<?php echo $text; ?>" class="widefat"></td>
									<td><label><input type="checkbox" value="1" name="datos_download[<?php echo $i; ?>][follow]" <?php checked($follow, '1'); ?>> Follow</label></td>
								</tr>
								<?php
							} ?>
                        </tbody>
                    </table>
                </div>
                <p class="addLink button"><b>+ <?php echo __( 'Añadir enlace', 'appyn' ); ?></b></p>
                <p><a href="https://themespixel.net/en/docs/appyn/posts/#doc4" target="_blank"><?php echo __( 'Ver en la documentación', 'appyn' ); ?></a></p>
            </div>
            <div class="dd-content" data-option="2"
                <?php echo (@$datos_download['option'] == "direct-link") ? '  style="display:block;"': ''; ?>>
                <p><?php echo __( 'Enlace directo / Redirección', 'appyn' ); ?><br>
                    <input type="text" placeholder="Link" class="widefat" name="datos_download[direct-link]" value="<?php echo @$datos_download['direct-link']; ?>">
                </p>
            </div>
            <div class="dd-content" data-option="3"
                <?php echo (@$datos_download['option'] == "direct-download") ? '  style="display:block;"': ''; ?>>
                <p><?php echo __( 'Descarga directa', 'appyn' ); ?><br>
                    <input type="text" placeholder="File link" name="datos_download[direct-download]" value="<?php echo @$datos_download['direct-download']; ?>" class="upload" style="width:500px;"><input class="upload_image_button button" type="button" value="<?php echo __( 'Subir', 'appyn' ); ?>" style="width: auto;vertical-align: middle;font-family: inherit;">
                </p>
            </div>
            <?php
}

add_action( 'save_post', 'px_quote_meta_save' );

function px_quote_meta_save( $id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	if( isset($_POST['dynamicMeta_noncename']) )
		if( ! wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ))) return;

	if( ! current_user_can( 'edit_post', $id ) ) return;
	
	$allowed = array(
		'p'	=> array()
	);
	
	if(isset($_POST['datos_informacion']))
		update_post_meta( $id, "datos_informacion", $_POST['datos_informacion'] );

	if(isset($_POST['datos_video']))
		update_post_meta( $id, "datos_video", $_POST['datos_video'] );

	if(isset($_POST['datos_imagenes']))
		update_post_meta( $id, "datos_imagenes", $_POST['datos_imagenes'] );

	if(isset($_POST['datos_download']))
		update_post_meta( $id, "datos_download", $_POST['datos_download'] );

	if(isset($_POST['custom_boxes'])) {
		update_post_meta( $id, "custom_boxes", $_POST['custom_boxes'] );
	} else {
		delete_post_meta( $id, "custom_boxes" );
	}

	if(isset($_POST['permanent_custom_boxes'])) {
		delete_option( "permanent_custom_boxes" );
		$pcb = $_POST['permanent_custom_boxes'];
		array_multisort($pcb);
		update_option( "permanent_custom_boxes", stripslashes_deep($pcb) );
		$oc = get_option( 'appyn_orden_cajas', null );
		if( $oc ) {
			$add = array();
			foreach( $pcb as $k => $p ) {
				if( !array_key_exists('permanent_custom_box_'.$k, $oc ) ) 
					$oc['permanent_custom_box_'.$k] = stripslashes_deep($pcb)[$k]['title'];
			}
			update_option( 'appyn_orden_cajas', $oc );
		}
	}
	
	if( isset($_POST['new_rating_users'])  || isset($_POST['new_rating_average']) ) {
		update_post_meta( $id, "new_rating_users", @$_POST['new_rating_users'] );
		update_post_meta( $id, "new_rating_average", @$_POST['new_rating_average'] );
		$nru = (empty($_POST['new_rating_users']) ? 0 : $_POST['new_rating_users'] );
		$nra = (empty($_POST['new_rating_average']) ? 0 : $_POST['new_rating_average'] );
		update_post_meta( $id, "new_rating_count", ceil($nru * $nra));
	}
	if( isset($_POST['appyn_ads_control']) ) {
		delete_post_meta( $id, "appyn_ads_control" );
		update_post_meta( $id, "appyn_ads_control", $_POST['appyn_ads_control'] );
	}
}

function custom_excerpt_length($length) {
	return 5;	
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more($more) {
	return '... <div class="readmore"><a href="'.get_permalink( get_the_ID() ).'" title="'.__( 'Seguir leyendo', 'appyn' ).'">'.__( 'Seguir leyendo', 'appyn' ).'</a></div>';
}

add_filter( 'excerpt_more', 'new_excerpt_more' );

add_filter( 'image_size_names_choose', 'px_image_sizes' );

function px_image_sizes($sizes) {
    $addsizes = array(
		"minimo" => "Mínimo",
		"medio" => "Medio"
    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}
add_filter( 'comment_text', 'div_comment_content' );

function div_comment_content( $comment_text ) {
	$comment_text = '<div class="comment-content">'.wpautop($comment_text).'</div>';
	return $comment_text;
}

require_once( TEMPLATEPATH . '/includes/template-functions.php' );
require_once( TEMPLATEPATH . '/includes/template-actions.php' );
require_once( TEMPLATEPATH . '/includes/template-tags.php' );
require_once( TEMPLATEPATH . '/includes/admin.php' );
require_once( TEMPLATEPATH . '/includes/ajax.php' );
require_once( TEMPLATEPATH . '/includes/widget-ultimos-posts.php' );
require_once( TEMPLATEPATH . '/includes/widget-mejor-calificados.php' );
require_once( TEMPLATEPATH . '/includes/widget-mas-vistos.php' );
require_once( TEMPLATEPATH . '/includes/widget-facebook.php' );
require_once( TEMPLATEPATH . '/includes/widget-twitter.php' );
require_once( TEMPLATEPATH . '/includes/widget-youtube.php' );
require_once( TEMPLATEPATH . '/includes/widget-ultimos-posts-blog.php' );
require_once( TEMPLATEPATH . '/includes/widget-mas-vistos-blog.php' );
require_once( TEMPLATEPATH . '/includes/widget-mas-calificados.php' );
require_once( TEMPLATEPATH . '/includes/class-upload-apk.php' );
require_once( TEMPLATEPATH . '/includes/class-google-drive.php' );
require_once( TEMPLATEPATH . '/includes/class-dropbox.php' );
require_once( TEMPLATEPATH . '/includes/class-ftp.php' );
require_once( TEMPLATEPATH . '/includes/class-1fichier.php' );
require_once( TEMPLATEPATH . '/includes/class-list-table-atul.php' );

add_action( 'wp_head', 'add_my_favicon' );
add_action( 'admin_head', 'add_my_favicon' ); 

function add_my_favicon() {
	global $post;
	$favicon = get_option( 'appyn_favicon' );
	$favicon = ( !empty($favicon) ) ? $favicon: get_bloginfo('template_url').'/images/favicon.ico';
	echo '<link rel="icon" href="'.$favicon.'">';
}

add_action( 'wp_head', 'add_head', 1 );

function add_head() {
	global $post;
	if(  wp_is_mobile() ) { 
		$styles = str_replace("url(images/", "url(".get_bloginfo('template_directory')."/images/", 
		file_get_contents( TEMPLATEPATH . '/style.min.css') );
		echo '<style>'.$styles.'</style>';
	} 	
	$color_theme_principal = str_replace('#', '',get_option( 'appyn_color_theme_principal' ));	
	if($color_theme_principal){
		echo '<meta name="theme-color" content="#'.$color_theme_principal.'">';
	} else {
		echo '<meta name="theme-color" content="#1d222d">';	
	}
	$script_loadfont = "
	<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" as=\"style\" crossorigin>
	<script>
	const loadFont = (url) => {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', url, true);
		xhr.onreadystatechange = () => {
		  if (xhr.readyState == 4 && xhr.status == 200) {
			const head = document.getElementsByTagName('head')[0];
			const style = document.createElement('style');
			style.appendChild(document.createTextNode(xhr.responseText));
			head.appendChild(style);
		  }
		};
		xhr.send();
	};
	loadFont('".get_template_directory_uri()."/assets/css/font-awesome.min.css');
	</script>
	";
	echo str_replace(array("\n", "\t"), "", str_replace("  ", " ", $script_loadfont));
	$header_codigos = stripslashes(get_option('appyn_header_codigos'));
	echo $header_codigos;
	
	// Estructura de datos
	px_data_structure();
}

function px_css_dark_theme() {
	$css = 'body, .wrapper-inside {
		color: #d8d2d2;
		background: #1d222d;
  	}
	table thead th,
	#versiones table tbody > tr:nth-child(odd) td {
		background: rgba(255,255,255,0.05);
	}
	table tbody td,
	table tfoot td,
	#versiones table tbody tr td {
		background: rgba(255,255,255,0.02);
	}
	#versiones table thead tr th,
	#versiones table tbody tr td {
		background: transparent;
	}
  	#header, #header menu .menu .sub-menu, #header menu .menu .sub-menu li a, #footer {
		background: #13161d;
  	}
	.section .title-section {
		border-color:#323232;
	}
	table td, table th, .aplication-single .box h2.box-title, .aplication-single .box #reply-title, .aplication-page .box #reply-title, .section.blog .bloques li, .section.blog .title-section, .aplication-page .box h1.box-title, .box .comments-title, #versiones table thead tr th, #slideimages .item img {
    	border-color: #232834;
  	}
	.section .bloque-app .px-postmeta {
    	border-top-color: #232834;
	}
	.section .bloque-app a, .section .bloque-app .px-postmeta, .section .bloque-app-second, .section a.more:hover,
   	#subheader.np #searchBox ul, .section .bloque-blog, .widget .widget-content ul li:hover a::before, .w75.bloque-imagen.bi_ll {
		background: #282d3a;
  	}		  
	table tr:nth-child(even), table tbody th {
		background: #1f2430;
	}
  	.section .bloque-app a,
	.section .bloque-app-second {
	  	box-shadow:2px 2px 2px 0px #1a1c1f;
  	}
  	.rating-loading {
	  	background-color:rgba(0,0,0,0.5);
  	}
  	a, a:hover, .section .bloque-app-second .title,
  	.section .bloque-app .title, .section .bloque-app .developer,
  	.aplication-single h1.box-title, .botones_sociales.v2 a i, 
  	.aplication-single #download.box ul li a,
  	#comments ol.comment-list .comment .comment-body > p,
  	.aplication-single .box h2.box-title, .aplication-single .box #reply-title, .aplication-page .box.box-title h1, .aplication-page .box h3 #reply-title,
  	#subheader.np #searchBox ul li a, .section.blog .bloques li a.title, .aplication-page .box h1.box-title, .section .bloque-blog a.title, .page-woocommerce, .page-woocommerce a, .page-woocommerce a:hover,
	.aplication-single .bx-download, .aplication-single .bx-download .bxt, .box .comments-title, .box #reply-title, #breadcrumbs a:hover, #main-site .error404 h1, #main-site .error404 h2, .aplication-single .data-app span b, .widget-title h2, .relacionados .bloque-app a:hover .title, .dl-verified, #comments ol.comment-list .trackback, #comments ol.comment-list .pingback {
		color: #FFF;
	}
	.px-carousel-nav .px-prev i, .px-carousel-nav .px-next i {
		color: #8a8a8a;
	}
  	.entry, .section.blog .bloques li .excerpt, .aplication-single .entry,
  	.aplication-single .box .box-content {
	  	color:#d4d4d4;
  	}
  	#comments ol.comment-list .comment .comment-body .reply a {
	  	color:#1bbc9b;  
  	}
  	.section .bloque-app-second .px-postmeta {
    	color: #78797c;
  	}
  	.aplication-single .box, #subheader.np, .section.blog, .aplication-page .box, .page-woocommerce {
	  	background: #282d3a;
	  	box-shadow: 2px 2px 2px 0px #1a1c1f;
  	}
	.aplication-single .entry.bx-info-install {
		background: #303542;
	}
  	.botones_sociales.v2 a, #comments textarea, #comments input[type=text], #comments input[type=email], #comments input[type=url], #comments textarea, .botones_sociales a {
	  	background: #1d222d;
	  	color: #FFF;
  	}
  	.pagination .page-numbers, .pagination .current, .section.blog .pagination .current, .section.blog .pagination .page-numbers {
	  	color:#FFF;
	  	background: #282d3a;
  	}
  	.relacionados .bloque-app .title, .widget .widget-content ul li .s2 .title, #comments ol.comment-list .comment .comment-body .comment-content p {
	  	color:#bfbfbf;
	}
  	.widget {
	  	background:transparent;
	  	box-shadow:none;
  	}
  	.widget .widget-title, .widget_block h2, .widget .widget-content ul li a,
	#slideimages .px-prev i, #slideimages .px-next i, .aplication-single .entry.bx-info-install {
	  	border-color: #282d3a;
  	}
  	.relacionados .bloque-app .developer, .widget .widget-content ul li .s2 .developer, .section .bloque-app-second .developer, .section .bloque-app .developer, .section .bloque-app-second .app-date, .section .bloque-app .app-date, .widget .widget-content ul li .s2 .app-date, .relacionados .bloque-app .app-date {
	  	color: #7a7a7a;  
  	}
  	main .error404  {
	  	color:#FFF;
  	}
  	main .error404 h1 {
	  	text-shadow: 10px 10px 8px rgba(0,0,0,0.4);
  	}
  	.entry blockquote {
	  	border-color: #4c5160;
  	}
  	.ratingBoxMovil .box-rating.movil {
      	background: #252935;
	}
	.link-report a {
		color: #bfbfbf;
	}
	.link-report a:hover, .px-carousel-nav .px-prev i:hover, .px-carousel-nav .px-next i:hover {
		color: #FFF;
	}
	#box-report > div {
		color: #4c4c4c;
	}
	.entry .wp-caption {
		background: rgba(0,0,0,0.1);
	}
	.aplication-single .entry.limit::before {
		background: -moz-linear-gradient(top,  rgba(0,0,0,0), rgba(40,45,58,1));
		background: -webkit-linear-gradient(top,  rgba(0,0,0,0),rgba(40,45,58,1));
		background: linear-gradient(to bottom,  rgba(40,45,58,0),rgba(40,45,58,1));
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#00ffffff", endColorstr="#282d3a",GradientType=0 );
	}
	.aplication-single .downloadAPK:not(.danv):hover, .aplication-single .downloadAPK.danv:hover, .aplication-single .s2 .meta-cats a:hover, .aplication-single .readmore:hover, .aplication-single .etiquetas a:hover, #comments input[type=submit]:hover, .section a.more:hover, #subheader #searchBox form button:hover, .widget.widget_tag_cloud a:hover, .bloque-imagen.bi_ll, #backtotop:hover, .botones_sociales.color a:hover, .widget .search-form input[type=submit]:hover, .widget .wp-block-search .wp-block-search__button:hover, #dl-telegram:hover {
		background: #41495d;
	}
	/*Woocommerce*/
	.select2-container {
		color:#000;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs::before,
	.woocommerce div.product .woocommerce-tabs ul.tabs li,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
	.woocommerce #reviews #comments ol.commentlist li .comment-text, 
	#add_payment_method #payment ul.payment_methods, 
	.woocommerce-cart #payment ul.payment_methods, 
	.woocommerce-checkout #payment ul.payment_methods,
	.page-woocommerce .woocommerce ul.order_details li,
	#add_payment_method .cart-collaterals .cart_totals tr td, 
	#add_payment_method .cart-collaterals .cart_totals tr th, 
	.woocommerce-cart .cart-collaterals .cart_totals tr td, 
	.woocommerce-cart .cart-collaterals .cart_totals tr th, 
	.woocommerce-checkout .cart-collaterals .cart_totals tr td, 
	.woocommerce-checkout .cart-collaterals .cart_totals tr th {
		border-color: rgba(255,255,255,0.1);
	}
	#subheader.np #searchBox ul li a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
	#add_payment_method #payment, 
	.woocommerce-cart #payment, 
	.woocommerce-checkout #payment,
	.page-woocommerce .order_details,
	fieldset {
		background: rgba(255,255,255,0.1);
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active, fieldset legend {
		background: #282d3a;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li a {
		color: rgba(255,255,255,0.3);
	}
	/**/
  	@media screen and (max-width:500px){
	  	.botones_sociales li {
			border:none;
	  	}
	  	.aplication-single .box-data-app {
		  	background:#1d222d;		  
	  	}
	  	.aplication-single .data-app span {
		  	border-bottom-color:#282d3a;  
	  	}
	}';
	
	$css = str_replace(array("\n", "\r", "\t", "  "), "", $css);
	return $css;
}

function is_dark_theme_active() {
	$option_color_theme_user_select = appyn_options( 'color_theme_user_select' );

	if( isset($_COOKIE['px_light_dark_option']) ) {

		return ($_COOKIE['px_light_dark_option'] == 1) ? true : false;

	} else {

		$color_theme = str_replace('#', '', get_option( 'appyn_color_theme' ));
		
		return ($color_theme == "oscuro") ? true : false;
	}
}

add_action( 'wp_head', 'add_color_theme', 99 );

function add_color_theme() {
	global $post;
	
	if( is_dark_theme_active() ) {
		if( !is_amp_px() ) echo '<style id="css-dark-theme">';

		echo px_css_dark_theme();
		 
		if( !is_amp_px() ) echo '</style>';
	 
	}
	if( !is_amp_px() ) {
		echo '<style>';
	}
	$css = '';
	$sidebar_ubicacion = get_option( 'appyn_sidebar_ubicacion' );
	if( $sidebar_ubicacion == "izquierda" ){
		$css .= '
		#sidebar {
			float:left;
		}
		.aplication-single, 
		.aplication-page, 
		.section.blog, 
		.page-woocommerce  {
			float:right;
		}
		html[dir="rtl"] #sidebar {
			float:right;
		}
		html[dir="rtl"] .aplication-single, 
		html[dir="rtl"] .aplication-page,
		html[dir="rtl"] .section.blog,
		html[dir="rtl"] .page-woocommerce {
			float:left;
		}';
	}
	$color_theme_principal = str_replace('#', '', get_option( 'appyn_color_theme_principal' ));
	if( $color_theme_principal ) {
		$css .= '
		html #header nav .menu > li.menu-item-has-children > .sub-menu::before,
		html .section .bloque-blog a.title:hover,
		html .section.blog .bloques li a.title:hover,
		html .aplication-single .box .entry a,
		html .aplication-single .box .box-content a,
		html .aplication-page .box .entry a,
		html .aplication-single .text-rating b, 
		html .ratingBoxMovil .text-rating b,
		html #comments ol.comment-list .comment .comment-body .reply a,
		html .aplication-single .data-app span a,
		html .section .bloque-app-second .title:hover,
		html #wp-calendar td a,
		html .relacionados .bloque-app a:hover .title,
		html .trackback a, 
		html .pingback a {
			color: #'.$color_theme_principal.';
		}';
		$css .= '
		html #header nav ul li.current-menu-item a,
		html #header nav .menu > li > a::before, 
		html #header nav .menu > li.beforeactive > a::before,
		html #menu-mobile ul li a:hover,
		html body.nav_res #header nav ul.menu.active li a:hover, 
		html body.nav_res #header nav ul.menu.active li a:hover i::before,
		html #subheader #searchBox form button,
		html #subheader.np #searchBox form button,
		html #subheader .np .social li a,
		html .pagination .page-numbers.current,
		html .pagination a.page-numbers:hover,
		html .section.blog .pagination .page-numbers.current,
		html .section.blog .pagination a.page-numbers:hover,
		html .section.blog .bloques li .excerpt .readmore a,
		html .section a.more,
		html .aplication-single .s2 .meta-cats a,
		html .aplication-single .downloadAPK:not(.danv),
		html .aplication-single .readmore,
		html .aplication-single .etiquetas a,
		html .aplication-single .box h2.box-title::after, 
		html .aplication-single .box h3.box-title::after,
		html .aplication-page .box h1.box-title::after, 
		html h1.box-title::after, 
		html .box #reply-title::after, 
		html .box .comments-title::after,
		html #slideimages .si-prev i, 
		html #slideimages .si-next i,
		html #comments input[type=submit],
		html .widget.widget_tag_cloud a,
		html .widget .search-form input[type=submit],
		html .widget .wp-block-search .wp-block-search__button,
		html main .error404 form button,
		html .ratingBoxMovil button,
		html #slideimages .px-prev i, 
		html #slideimages .px-next i,
		html .section.blog .pagination .current,
		html .section.blog .pagination a:hover,
		html #box-report input[type=submit], 
		#main-site .error404 form button,
		html .section .bloque-app a::after,
		html .bld_,
		html #backtotop {
			background: #'.$color_theme_principal.';
		}
		html ::-webkit-scrollbar-thumb {
			background: #'.$color_theme_principal.';
		}';
		$css .= '
		html #header,
		html #header nav .menu > li.menu-item-has-children > .sub-menu::before,
		html #subheader,
		html .section .bloque-app a::before,
		html .section .bloque-app-second,
		html #footer,
		html .bld_ico, 
		html .bloque-blog {
			border-color: #'.$color_theme_principal.';
		}
		html .loading {
			border-top-color: #'.$color_theme_principal.';
		} 
		html .section .bloque-app .px-postmeta {
			border-bottom-color: #'.$color_theme_principal.';
		}
		';
	}
	$css = str_replace(array("\n", "\r", "\t", "  "), "", $css);
	echo $css;
	if( !is_amp_px() ) {
		echo '</style>';
	}
}
function theme_scripts() {
	if( !wp_is_mobile() ) {
		wp_enqueue_style( 'style', get_bloginfo("template_directory").'/style.min.css', false, VERSIONPX, 'all' ); 
	}
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'px-js', get_bloginfo("template_directory").'/assets/js/js.min.js', array('jquery'), VERSIONPX, true );

	$readmore_single = stripslashes(get_option( 'appyn_readmore_single' ));
	$o = '';
	if( $readmore_single == 1 ) {
		$o .= 'var text_ = false;';
	} else {
		$o .= 'var text_ = true;';
	}
	$o .= '	
	var ajaxurl = "' . admin_url('admin-ajax.php') . '";
	var text_votar = "'.__( 'Votar', 'appyn' ).'";
	var text_votos = "'.__( 'Votos', 'appyn' ).'";
	var text_leer_mas = "'.__( 'Leer más', 'appyn' ).'";
	var text_leer_menos = "'.__( 'Leer menos', 'appyn' ).'";
	var text_de = "'.__( 'de', 'appyn' ).'";
	var text_reporte_gracias = "'.__( 'Gracias por enviarnos su reporte.', 'appyn' ).'";';

	wp_add_inline_script( 'px-js', $o, 'before' );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		add_action('wp_footer', function(){
			echo '<script>window.addComment=function(s){var u,f,v,y=s.document,p={commentReplyClass:"comment-reply-link",cancelReplyId:"cancel-comment-reply-link",commentFormId:"commentform",temporaryFormId:"wp-temp-form-div",parentIdFieldId:"comment_parent",postIdFieldId:"comment_post_ID"},e=s.MutationObserver||s.WebKitMutationObserver||s.MozMutationObserver,i="querySelector"in y&&"addEventListener"in s,n=!!y.documentElement.dataset;function t(){r(),function(){if(!e)return;new e(d).observe(y.body,{childList:!0,subtree:!0})}()}function r(e){if(i&&(u=I(p.cancelReplyId),f=I(p.commentFormId),u)){u.addEventListener("touchstart",a,{passive: true}),u.addEventListener("click",a);var t=function(e){if((e.metaKey||e.ctrlKey)&&13===e.keyCode)return f.removeEventListener("keydown",t),e.preventDefault(),f.submit.click(),!1};f&&f.addEventListener("keydown",t);for(var n,r=function(e){var t,n=p.commentReplyClass;e&&e.childNodes||(e=y);t=y.getElementsByClassName?e.getElementsByClassName(n):e.querySelectorAll("."+n);return t}(e),d=0,o=r.length;d<o;d++)(n=r[d]).addEventListener("touchstart",l,{passive: true}),n.addEventListener("click",l)}}function a(e){var t=I(p.temporaryFormId);t&&v&&(I(p.parentIdFieldId).value="0",t.parentNode.replaceChild(v,t),this.style.display="none",e.preventDefault())}function l(e){var t=this,n=m(t,"belowelement"),r=m(t,"commentid"),d=m(t,"respondelement"),o=m(t,"postid");n&&r&&d&&o&&!1===s.addComment.moveForm(n,r,d,o)&&e.preventDefault()}function d(e){for(var t=e.length;t--;)if(e[t].addedNodes.length)return void r()}function m(e,t){return n?e.dataset[t]:e.getAttribute("data-"+t)}function I(e){return y.getElementById(e)}return i&&"loading"!==y.readyState?t():i&&s.addEventListener("DOMContentLoaded",t,!1),{init:r,moveForm:function(e,t,n,r){var d=I(e);v=I(n);var o,i,a,l=I(p.parentIdFieldId),m=I(p.postIdFieldId);if(d&&v&&l){!function(e){var t=p.temporaryFormId,n=I(t);if(n)return;(n=y.createElement("div")).id=t,n.style.display="none",e.parentNode.insertBefore(n,e)}(v),r&&m&&(m.value=r),l.value=t,u.style.display="",d.parentNode.insertBefore(v,d.nextSibling),u.onclick=function(){return!1};try{for(var c=0;c<f.elements.length;c++)if(o=f.elements[c],i=!1,"getComputedStyle"in s?a=s.getComputedStyle(o):y.documentElement.currentStyle&&(a=o.currentStyle),(o.offsetWidth<=0&&o.offsetHeight<=0||"hidden"===a.visibility)&&(i=!0),"hidden"!==o.type&&!o.disabled&&!i){o.focus();break}}catch(e){}return!1}}}}(window);</script>';
		});
	} 
}

add_action( 'wp_enqueue_scripts', 'theme_scripts' );

add_action( 'wp_footer', 'add_footer' );

function add_footer() {
	
	$footer_codigos = stripslashes(get_option( 'appyn_footer_codigos' ));

	echo $footer_codigos;

	$recaptcha_site = get_option( 'appyn_recaptcha_site' );
	$recaptcha_secret = get_option( 'appyn_recaptcha_secret' );	
	if( $recaptcha_site && $recaptcha_secret ) {
	?>
	<script>
	var recaptcha_site = '<?php echo $recaptcha_site; ?>';
	</script>
	<?php } 
}

function paginador($query = false, $num = false, $args = null) {
	if( !empty($query) ) {
		$numposts = $query->found_posts;
		$max_page = $query->max_num_pages;
		$posts_per_page = intval($num);
	} else {
		global $wp_query;
		$max_page = $wp_query->max_num_pages;
	}

	$big = 999999999;

	$pages = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $max_page,
        'type'  => 'array',
	) );
	if( is_array( $pages ) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<div class="pagination-wrap"><ul class="pagination">';
        foreach ( $pages as $page ) {
			echo "<li>".str_replace('page-numbers dots', 'dots', $page)."</li>";
        }
       echo '</ul></div>';
    }
}

function function_pregetposts($query) {
  	if ( !is_admin() && $query->is_main_query() ) {
		if( $query->is_post_type_archive('blog') ) {
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$blog_posts_limite = get_option( 'appyn_blog_posts_limite' );
			$blog_posts_limite = (empty($blog_posts_limite)) ? '10' : $blog_posts_limite;
			$query->set('post_type', 'blog');
			$query->set('posts_per_page', $blog_posts_limite);
			$query->set('paged', $paged);
		}
		if( $query->is_search() ) {
			$query->set('post_type', 'post');
			if( get_option( 'appyn_versiones_mostrar_buscador') == 1 ) {
				$query->set('post_parent', 0);
			} 
		}
		if( $query->is_tax('dev') ) {
			if( get_option( 'appyn_versiones_mostrar_tax_desarrollador') == 1 ) {
				$query->set('post_parent', 0);
			} 
		}
		if( $query->is_tax('cblog') ) {
			$query->set('post_type', 'blog');
		}
		if( $query->is_category() ) {
			if( get_option( 'appyn_versiones_mostrar_categorias') == 1 ) {
				$query->set('post_parent', 0);
			} 
		}
		if( $query->is_tag() ) {
			if( get_option( 'appyn_versiones_mostrar_tags') == 1 ) {
				$query->set('post_parent', 0);
			} 
		}
		if( $query->is_home() ) {
			$home_limite = get_option( 'appyn_home_limite' );
			$home_limite = ( empty( $home_limite ) ) ? '12' : $home_limite;
			$query->set('posts_per_page', $home_limite);
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

			$query->set('paged', $paged);
			$home_posts_orden = get_option( 'appyn_home_posts_orden' );
			$home_posts_versiones = get_option( 'appyn_versiones_mostrar_inicio', 0 );
			if( $home_posts_orden == 'modified' ){
				$query->set('orderby', 'modified');
			}
			elseif( $home_posts_orden == 'rand' ){
				$query->set('orderby', 'rand');
			}		
			if( $home_posts_versiones == 1 ){
				$query->set('post_parent', 0);
			}
		}
	}
	if(is_admin()){
		$query->set('orderby', '');
		$query->set('order', '');    
	}
}
add_action( 'pre_get_posts', 'function_pregetposts' );
function add_query_vars_filter( $vars ){
	$vars[] = "download";
	$vars[] = "download_link";
	$vars[] = "opt";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

define('ALLOW_UNFILTERED_UPLOADS', true);

function download_opts() {
	if( !is_single() ) return;

	global $post;
	$download_links = get_option( 'appyn_download_links' );
	$redirect_timer = get_option( 'appyn_redirect_timer' );
	$get_download = get_query_var( 'download', null );
	$datos_download = get_post_meta($post->ID, 'datos_download', true);

	if( $download_links == 1 || $download_links == 2 ) {
		$error_script = "<script>function alert_download() { alert('".__( 'No hay archivo para descargar.', 'appyn' )."'); }</script>";

		if( $get_download == "redirect" ) {
			if( strlen($datos_download['direct-link']) > 0 ) {
				echo '<meta http-equiv="refresh" content="'.$redirect_timer.';url='.$datos_download['direct-link'].'">';
			} else {
				echo $error_script;	
			}
		} 
		elseif( $get_download == "true" ) {
			if( strlen($datos_download['direct-download']) > 0 ) {
				echo '<meta http-equiv="refresh" content="'.$redirect_timer.';url='.esc_url( add_query_arg( 'download', 'file' ) ).'">'; 
			} else {
				echo $error_script;	
			}
		}
	}
}

add_action( 'wp_head', 'download_opts' );

function download_file(){
	if( !is_single() ) return;
		global $post;
		$get_download = get_query_var( 'download', null );

	if( $get_download == "file") {
		$post_id = $post->ID;
		$datos_download = get_post_meta($post_id, 'datos_download', true);
		$url = $datos_download['direct-download'];
		header("Location: $url");
		exit();
	}
}
add_action( 'template_redirect', 'download_file' );
add_action('registered_post_type', 'igy2411_make_posts_hierarchical', 10, 2 );

function igy2411_make_posts_hierarchical($post_type, $pto){
    if ($post_type != 'post') return;
    global $wp_post_types;
    $wp_post_types['post']->hierarchical = 1;
    add_post_type_support( 'post', 'page-attributes' );
}

function modify_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
	$appyn_lazy_loading = ( get_option('appyn_lazy_loading') ) ? get_option('appyn_lazy_loading') : NULL;
	if( $appyn_lazy_loading == 1 ) {
		$id = get_post_thumbnail_id();
		$src = wp_get_attachment_image_src($id, $size);
		$alt = get_the_title($id);
		$class = '';
		if( !empty($attr['class']) ) {
			$class = $attr['class'];
		}
		$image_blank = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAI4AAACNAQMAAABbp9DlAAAAA1BMVEX///+nxBvIAAAAGUlEQVRIx+3BMQEAAADCIPunNsU+YAAA0DsKdwABBBTMnAAAAABJRU5ErkJggg==";
		$color_theme = str_replace('#', '', get_option( 'appyn_color_theme' ));
		$color_theme_principal = str_replace('#', '', get_option( 'appyn_color_theme_principal' ));
		if($color_theme == "oscuro") {
			$image_blank = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAI4AAACNAQMAAABbp9DlAAAAA1BMVEUUHCkYkPNHAAAAGUlEQVRIx+3BMQEAAADCIPunNsU+YAAA0DsKdwABBBTMnAAAAABJRU5ErkJggg==";
		}
		$html = '<img src="'.$image_blank.'" data-src="' . $src[0] . '" alt="' . $alt . '" class="' . $class . ' lazyload" />';
	}	
	return $html;
}
add_filter('post_thumbnail_html', 'modify_post_thumbnail_html', 99, 5);

add_filter('upload_mimes', 'allow_custom_mimes');

function allow_custom_mimes ( $existing_mimes=array() ) {
	$existing_mimes['apk'] = '<code>application/vnd.android.package-archive</code>';
	return $existing_mimes;
}

add_rewrite_endpoint( AMP_QUERY_VAR, EP_PERMALINK );

add_filter( 'template_include', 'amp_page_template', 99 );
function amp_page_template( $template ) {
	$section = get_query_var( 'section' );

    if( is_amp_px() ) {
		$template = $template;
		if( $section == 'versions' ) {
			$template = get_template_directory() .  '/amp/single-versions.php';
		} else {
			if ( is_singular('post') ) {
				$template = get_template_directory() .  '/amp/single.php';
			} 
			if ( is_home() ) {
				$template = get_template_directory() .  '/amp/index.php';
			} 
		}
	} else {
		if( $section == 'versions' ) {
			$template = get_template_directory() .  '/amp/single-versions.php';
		}
	}
    return $template;
}

add_action('get_header', function($name){
	return "header-amp";
});

add_action('wp_head', function(){
	global $wp_query;
	if( is_404() || !appyn_options( 'amp' ) ) return;

	if( is_home() || is_single() || is_archive() ) {
		if( is_home() ) { 
			echo '<link rel="amphtml" href="'.get_bloginfo('url').'/?amp">';
		} elseif( is_single() ) {
			global $post;
			echo '<link rel="amphtml" href="'.get_the_permalink().'?amp">';
		} elseif( is_archive() ) {
			$obj = get_queried_object();
			if( isset($obj->rewrite['slug']) ) {
				$l = get_post_type_archive_link($obj->rewrite['slug']);
				echo '<link rel="amphtml" href="'.($l).'?amp">';
			}
		} else {
			$obj = get_queried_object();
			if( !empty($obj->term_id) ) echo '<link rel="amphtml" href="'.get_term_link($obj->term_id).'?amp">';
		}
	}
});

add_filter('post_link', 'wpse230567_filter_post_link', 1, 2);

function wpse230567_filter_post_link($link, $post = 0){
	if( is_amp_px() ) {
    	return $link.'?amp';
	}
	return $link;
}

function modify_post_thumbnail_amp($html, $post_id, $post_thumbnail_id, $size, $attr) {
	if( is_amp_px() ) { 
		$id = get_post_thumbnail_id();
		$src = wp_get_attachment_image_src($id, $size);
		$alt = get_the_title($id);
		$class = '';
		if( !empty($attr['class']) ) {
			$class = $attr['class'];
		}

		$html = '<amp-img src="'.$src[0].'" width="128" height="128" alt="' . $alt . '" class="' . $class . '" layout="responsive"></amp-img>';
	}
	return $html;
}
add_filter('post_thumbnail_html', 'modify_post_thumbnail_amp', 99, 5);

add_filter( 'comment_reply_link', function($args_before_link_args_after){
	if( is_amp_px() ) {
		return false;
	} else {
		return $args_before_link_args_after;
	}
} );

add_filter( 'get_avatar_url', 'wpua_get_avatar_url', 50, 3 );

function wpua_get_avatar_url( $url, $id_or_email, $args ){
	if( class_exists('WP_User_Avatar_Functions') && $id_or_email != 'unknown@gravatar.com' ) {
		global $wpua_functions;
		$url = $wpua_functions->get_wp_user_avatar_src( $id_or_email, $args['size'] );	
	}
	return $url;
}

add_filter( 'locale_stylesheet_uri', function ($localized_stylesheet_uri) {
	if( strpos($localized_stylesheet_uri, 'rtl.css') !== false ) {
    	return add_query_arg( array('ver' => VERSIONPX), $localized_stylesheet_uri );
	}
});

add_action( 'wp_head', function(){
	echo '<style>';
	include __DIR__."/../../../wp-includes/css/dist/block-library/style.min.css";
	echo '</style>';
});

add_action( 'wp_enqueue_scripts', 'dequeue_gutenberg_theme_css', 100);

function dequeue_gutenberg_theme_css() {
    wp_dequeue_style( 'wp-block-library' );
}

add_action( 'wp_footer', 'px_js_dark_theme', 999 );

function px_js_dark_theme() {
	echo "
	<script type='text/javascript'>
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = \"expires=\"+ d.toUTCString();
        document.cookie = cname + \"=\" + cvalue + \";\" + expires + \";path=/\";
    }
    
    function getCookie(cname) {
        var name = cname + \"=\";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return '';
	}
	(function($) {
		$(document).on('click', '#button_light_dark', function(){
			if( !$(this).hasClass('active') ) {
				setCookie('px_light_dark_option', 1, 365);
				if( !$('#css-dark-theme').length ) {
					$('footer').after('<style id=\"css-dark-theme\">".px_css_dark_theme()."</style>');
				}
			} else {
				setCookie('px_light_dark_option', 0, 365);
				$('#css-dark-theme').remove();
			}
			$(this).toggleClass('active');  
			$('body').toggleClass('theme-dark');    
		}); 
	})(jQuery);
	</script>";
}

add_filter('request', 'px_change_term_request', 1, 1 );
 
function px_change_term_request($query){
 
	$tax_name = 'cblog';
 
	if( isset($query['attachment']) ) :
		$include_children = true;
		$name = $query['attachment'];
	else:
		$include_children = false;
		$name = isset($query['name']) ? $query['name'] : '';
	endif;
 
 
	$term = get_term_by('slug', $name, $tax_name);
 
	if (isset($name) && $term && !is_wp_error($term)):
 
		if( $include_children ) {
			unset($query['attachment']);
			$parent = $term->parent;
			while( $parent ) {
				$parent_term = get_term( $parent, $tax_name);
				$name = $parent_term->slug . '/' . $name;
				$parent = $parent_term->parent;
			}
		} else {
			unset($query['name']);
		}
 
		switch( $tax_name ):
			case 'category':{
				$query['category_name'] = $name;
				break;
			}
			case 'post_tag':{
				$query['tag'] = $name;
				break;
			}
			default:{
				$query[$tax_name] = $name;
				break;
			}
		endswitch;
 
	endif;
 
	return $query;
 
}
 
add_filter( 'term_link', 'px_term_permalink', 10, 3 );
 
function px_term_permalink( $url, $term, $taxonomy ){
 
	$taxonomy_name = 'cblog';
	$taxonomy_slug = 'cblog';
 
	if ( strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name ) return $url;
 
	$url = str_replace('/' . $taxonomy_slug, '', $url);
 
	return $url;
}

add_filter( 'manage_post_posts_columns', 'set_custom_edit_version_columns' );

function set_custom_edit_version_columns($columns) {
	
	$new = array();
	foreach($columns as $key => $title) {
		if( $key == 'author' ) {
			$new['version'] = __( 'Versión', 'appyn' );
		}
		$new[$key] = $title;
	}
    return $new;
}

add_action( 'manage_post_posts_custom_column' , 'custom_book_column', 10, 2 );

function custom_book_column( $column, $post_id ) {
	global $wpdb;
    switch ( $column ) {

		case 'version' :
			$datos_informacion = get_post_meta( $post_id, 'datos_informacion', true );
			echo ( isset($datos_informacion['version']) ) ? $datos_informacion['version'] : '--';
            break;

    }
}

add_filter( 'body_class', function( $classes ) {
	$add_class = array();

	if( is_dark_theme_active() ) {
		$add_class[] = 'theme-dark';
	}
    if( appyn_options( 'sidebar_active' ) == 1 ) {
		$add_class[] = 'no-sidebar';
	}

	if( count($add_class) > 0 )
		return array_merge( $classes, $add_class );	
	else
		return $classes;
} );

function disabled_lazyload() {
	if( is_amp_px() )
		return false;
}

add_filter( 'wp_lazy_loading_enabled', 'disabled_lazyload' );

function wp_editor_fix($content, $editor_id, $settings = array() ){      
    ob_start();
    wp_editor($content, $editor_id, $settings);
    $out = ob_get_contents();
    $js = json_encode($out);
    $id_editor_ctn  = $editor_id.'-ctn';
    ob_clean(); ?>
    <div id="<?php echo $id_editor_ctn?>"></div>
    <script>
    setTimeout(function() {
		var id_ctn = '#<?php echo $id_editor_ctn?>';
		jQuery(id_ctn).append(<?php echo $js?>); 
		setTimeout(function() {
			jQuery('#<?php echo $editor_id ?>-tmce').trigger('click');
		}, 500);
    }, 3000);
    </script>
    <?php
    $out = ob_get_contents();
    ob_end_clean();
    echo $out;
}

add_action( 'rank_math/vars/register_extra_replacements', function(){
	rank_math_register_var_replacement(
	   'px_rms_get_version',
	   [
	   'name'        => __( 'Versión', 'appyn' ),
	   'variable'    => 'px_rms_get_version',
	   'description' => '',
	   'example'     => px_rms_callback(),
	   ],
	   'px_rms_callback'
   );
});
