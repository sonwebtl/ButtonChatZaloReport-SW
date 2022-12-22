<?php
function zaloprocess_init() {
    //do bên js để dạng json nên giá trị trả về dùng phải encode
	
	$today = date("Y-m-d");
	global $wpdb;
	//$last_id = 1;
	$table_name = $wpdb->prefix . 'chatzalosw';
	$sql = "select * from $table_name where clickdate = '2022-12-22' order by id desc limit 1 ";
	$objzalo = $wpdb->get_row($sql);
	if ( empty($objzalo) ) {
		$wpdb->insert( 
			$table_name, 
			array( 
				'clickdate' => $today, 
				'click' => 1, 
			) 
		);
		$last_id = $wpdb->insert_id;
	} else {
		$last_id = $objzalo->id;
		$wpdb->update($table_name,array('click' =>$objzalo->click + 1,'clickdate'	=>$today ), array('id' => $last_id));
	}
	
    wp_send_json_success('Chào mừng bạn đến với '. $last_id);
	
    die();//bắt buộc phải có khi kết thúc
}
?>