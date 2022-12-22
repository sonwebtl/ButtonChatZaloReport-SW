<?php
/**
 * Plugin Name: Button Chat Zalo Report SW
 * Plugin URI: sonweb.net
 * Description: Display button Chat Zalo and call phone and report click Zalo in day,change color button chat...
 * Version: 1
 * Author: SonWeb
 * Author URI: sonweb.net
 * License: GPLv2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Setup
define( 'CHATZALO_PLUGIN_URL', __FILE__ );
define('CZR_VERSION','1.0.0');
$phonecall_title = apply_filters('pcb_plugin_title','Chat Zalo Report SW');
// Includes
include( 'inc/activate.php' );
include( 'inc/unistall.php' );
include( 'inc/enqueue.php' );
include( 'inc/frontend.php' );
include( 'inc/process.php' );

/* create menu & page dashboard */
add_action('admin_menu','register_pcbsw_page');
function register_pcbsw_page(){
	global $phonecall_title;
	add_submenu_page('options-general.php',$phonecall_title,$phonecall_title,'manage_options','phone-call-zalo','phone_callsw_setting_page');
	add_action('admin_init','register_pcnsw__settings');
}
function register_pcnsw__settings(){
	//register our settings
	register_setting( 'wtlsw_options', 'wtlswPhone' );
	register_setting( 'wtlsw_options', 'wtlswZalo' );
	register_setting( 'wtlsw_options', 'wtl_swcolor' );
}

// Add Page into menu
function phone_callsw_setting_page() {
	//Get the active tab from the $_GET param
	$default_tab = null;
	$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
	?>
		<div class="wrap">
			<h2>Chat Zalo Button <span class="version">v<?php echo CZR_VERSION;?></span></h2>
			<nav class="nav-tab-wrapper">
				<a href="?page=phone-call-zalo&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif;?>">Zalo Contact</a>
				<a href="?page=phone-call-zalo&tab=report" class="nav-tab <?php if($tab==='report'):?>nav-tab-active<?php endif; ?>">Zalo Report</a>
			</nav>
			<div class="zalopage tab-content">
			<?php switch($tab) :
				case 'settings':
					?>
						<form method="post" action="options.php" class="cnb-container">
							<?php settings_fields('wtlsw_options'); ?>
							
								<table class="form-table">
									<tr valign="top">
										<th scope="row">Số điện thoại:</th>
										<td><input type="text" name="wtlswPhone" value="<?php echo get_option('wtlswPhone');?>" /></td>
									</tr>
									<tr valign="top">
										<th scope="row">Chat Zalo:</th>
										<td><input type="text" name="wtlswZalo" value="<?php echo get_option('wtlswZalo');?>" /></td>
									</tr>
									<tr valign="top">
										<th scope="row">Background Color:</th>
										<td><input type="text" name="wtl_swcolor" class="cpa-color-picker" value="<?php echo get_option('wtlswZalo');?>" data-default-color="#0088cc" /></td>
									</tr>
								</table>
								<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
						</form>
					<?php
					break;
				case 'report':
					?>
						<h3> Thống kê click zalo </h3>
						<table class="reportzalo">
						<?php 
							global $wpdb;
							$table_name = $wpdb->prefix . 'chatzalosw';
							//$myrows = $wpdb->get_results("select * from $table_name");
							$items_per_page = 15;
							$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
							$offset = ( $page * $items_per_page ) - $items_per_page;

							$query = 'SELECT * FROM '.$table_name;

							$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
							$total = $wpdb->get_var( $total_query );
							/* tong click */
							$sqlc = "select sum(click) from $table_name";
							$totalc = $wpdb->get_var($sqlc);
						?>
						<caption style="text-align:right"><span>Tổng Click: <?php echo $totalc;?></span> </caption>
							<thead>
								<tr>
									<th>#</th>
									<th> Click </th>
									<th> Date </th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$results = $wpdb->get_results( $query.' ORDER BY clickdate DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );
									foreach ($results as $key=>$row) : 
								?>
									<tr>
										<td> <?php echo $key+1;?> </td>
										<td> <?php echo $row->click; ?> </td>
										<td> <?php echo date("d/m/Y", strtotime($row->clickdate));?> </td>
									</tr>
								<?php endforeach;?>
						</tbody>
					</table>
					<div class="zalo-pagi">
						<?php 
							echo paginate_links( array(
									'base' => add_query_arg( 'cpage', '%#%' ),
									'format' => '',
									'prev_text' => __('&laquo;'),
									'next_text' => __('&raquo;'),
									'total' => ceil($total / $items_per_page),
									'current' => $page
							));
						?>
					</div>
					
					<?php
					break;
				default:
					?>
						<form method="post" action="options.php" class="cnb-container">
							<?php settings_fields('wtlsw_options'); ?>
							
								<table class="form-table">
									<tr valign="top">
										<th scope="row">Số điện thoại:</th>
										<td><input type="text" name="wtlswPhone" value="<?php echo get_option('wtlswPhone');?>" /></td>
									</tr>
									<tr valign="top">
										<th scope="row">Chat Zalo:</th>
										<td><input type="text" name="wtlswZalo" value="<?php echo get_option('wtlswPhone');?>" /></td>
									</tr>
									<tr valign="top">
										<th scope="row">Background Color:</th>
										<td><input type="text" name="wtl_swcolor" class="cpa-color-picker" value="<?php echo get_option('wtlswZalo');?>" data-default-color="#0088cc" /></td>
									</tr>
								</table>
								<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
						</form>
					<?php
					break;
				endswitch; 
			?>
				
			</div><!--end chat-zalo-->
			
		</div><!--end wrap-->
		<style>
			.reportzalo {
				border-collapse: collapse;
    			color: #7f868d;
				min-width: 300px;
    			border-bottom: 1px solid #dadfe4;
				box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
			}
			.reportzalo thead tr {
				background-color: #009879;
				color: #ffffff;
				text-align: left;
			}
			.reportzalo tr:first-child {
				border-bottom: 1px solid #dadfe4;
			}
			.reportzalo tbody tr:nth-of-type(even) {
				background-color: #f3f3f3;
			}
			.reportzalo tbody tr:last-of-type {
				border-bottom: 2px solid #009879;
			}
			.reportzalo tr {
				transition: .25s background ease-in-out;
				border-bottom: 1px solid #dadfe4;
			}
			.reportzalo tr td,.reportzalo tr th {
				box-sizing: border-box;
				padding: 0.25rem 0.825rem;
				border-bottom-width: 1px;
   				 box-shadow: inset 0 0 0 9999px transparent;
			}
			.zalo-pagi {
				margin: 6px 10px 0;
				color: #aaa;
			}
			.zalo-pagi .page-numbers {
				border: 1px solid;
				margin-left: -1px;
				padding: 0.3rem 0.5rem;
				display: inline-block;
				line-height: 1.1;
				text-decoration: none;
				text-align: center;
			}
			.zalo-pagi .current {
				background-color: #0088cc;
				color: #fff;
			}
			.reportzalo caption span {
				color: #0088cc;
			}
		</style>
	<?php 
}

//Hooks js & css
add_action('wp_enqueue_scripts','wtl2_enqueue_scripts',100);
add_action('admin_enqueue_scripts','swenqueue_admin_js',100);

// Display Button Zalo frontend web
add_action('wp_footer','wtl_pcnButton');

add_action( 'wp_ajax_zaloprocess', 'zaloprocess_init' );
add_action( 'wp_ajax_nopriv_zaloprocess', 'zaloprocess_init' );

// Hooks
register_activation_hook( __FILE__, 'sw_activate_plugin' );
register_deactivation_hook(__FILE__, 'sw_deactivate_plugin');

// test 
/*
add_action('wp_footer','testsw');
function testsw() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'chatzalosw';
	$sql = "select sum(click) from $table_name";
	$totalc = $wpdb->get_var($sql);
	echo $totalc;
}
*/
?>