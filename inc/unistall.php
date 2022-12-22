<?php
function sw_deactivate_plugin() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'chatzalosw';
  $wpdb->query("DROP TABLE IF EXISTS $table_name");
  print_r("unistall");
}


