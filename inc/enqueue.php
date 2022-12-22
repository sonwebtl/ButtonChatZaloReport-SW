<?php

function wtl2_enqueue_scripts() {
	wp_enqueue_style('wtl_phonecall', plugins_url('/phonecall.css',CHATZALO_PLUGIN_URL) );

	wp_register_script( 
        'r_main', plugins_url( '/js/main.js', CHATZALO_PLUGIN_URL ), ['jquery'], '1.0.0', true 
    );

    wp_localize_script( 'r_main', 'zalo_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' )
    ]);

	wp_enqueue_script( 'r_main' );
	
}

function swenqueue_admin_js() {
	wp_enqueue_style( 'wp-color-picker' );
	 // Make sure to add the wp-color-picker dependecy to js file
	wp_enqueue_script( 'jscolorpck', plugins_url( '/js/jscolorpk.js', CHATZALO_PLUGIN_URL ), array( 'jquery', 'wp-color-picker' ), '', true  );
    
	 
}

?>