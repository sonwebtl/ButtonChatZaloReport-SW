<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action('wp_footer','swtest');
function swtest() {
    $today = date("Y-m-d");
    echo $today;
    global $wpdb;
		//$last_id = 1;
	$table_name = $wpdb->prefix . 'chatzalosw';
	$sql = "select * from $table_name where clickdate = '$today' order by id desc limit 1 ";
	$objzalo = $wpdb->get_row($sql);
    if ( empty($objzalo) ) {
        echo 'rong';
    }else {
        echo 'ko rong';
    }
}
?>