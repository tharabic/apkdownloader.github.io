<?php 
if( !is_amp_px() ) { 
    if( appyn_options( 'sidebar_active' ) == 0 ) {
        echo '<div id="sidebar">';
        
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar')) : 
        endif;
        echo '</div>';
    }
} 
?>