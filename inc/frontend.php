<?php 
function wtl_pcnButton() {
	?>
		<div class="fix_chatZalo">
			<a class="btn_chatZalo" target="_blank" href="https://zalo.me/<?php echo get_option('wtlswPhone')?>">
				<span> Chat Zalo </span>
			</a>
		</div><!--end fix-chatZalo-->
		
		
		<div class="fix_tel">
			<div class="ring-alo-phone ring-alo-green ring-alo-show">
				<div class="ring-alo-ph-circle"></div>
				<div class="ring-alo-ph-circle-fill"></div>
				<div class="ring-alo-ph-img-circle">
					<a href="tel:<?php echo get_option('wtlswPhone')?>">
						<img class="" src="<?php echo plugins_url( '/phone-ring.png', CHATZALO_PLUGIN_URL  )?>" />
					</a>
				</div>
				
			</div>
			<div class="tel">
				<p class="fone"><?php echo get_option('wtlswPhone');?></p>
				 
			</div>
		</div><!--end fix_tel-->

		<!-- css admin All in one -->
		<style type="text/css">
			.btn_chatZalo {
				background-color: <?php echo get_option('wtl_swcolor');?> !important;
			}
			.ring-alo-phone.ring-alo-green .ring-alo-ph-img-circle {
				background-color: <?php echo get_option('wtl_swcolor');?> !important;
			}
		</style>
		
	<?php
}


?>