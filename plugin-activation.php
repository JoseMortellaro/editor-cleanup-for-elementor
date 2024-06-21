<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

if( file_exists( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' ) ){
  unlink( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' );
}
eos_dp_ecfe_write_file( FDP_ECFE_PLUGIN_DIR.'/mu-plugins/fdp-mu-elementor.php',WPMU_PLUGIN_DIR,WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php',true );
