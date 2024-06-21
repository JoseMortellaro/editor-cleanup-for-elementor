<?php
/*
  Plugin Name: Editor Cleanup For Elementor [ecfe]
  Description: mu-plugin automatically installed by Editor CLeanup For Elementor
  Version: 0.0.6
  Plugin URI: https://freesoul-deactivate-plugins.com/
  Author: Jose Mortellaro
  Author URI: https://josemortellaro.com/
  License: GPLv2
*/

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

define( 'FDP_ECFE_MU_VERSION','0.0.6' );

$elementor_actions = array(
  'elementor_ajax'
);

if( is_admin() && ! wp_doing_ajax() && isset( $_GET['action'] ) && 'elementor' === $_GET['action'] ){
  add_filter( 'option_active_plugins', 'eos_ecfe_outer' );
}
if( ! is_admin() && isset( $_GET['elementor-preview'] ) && absint( $_GET['elementor-preview'] ) > 0 ){
  add_filter( 'option_active_plugins', 'eos_ecfe_inner' );
}
if( 
  isset( $_SERVER['REQUEST_URI'] ) && false !== strpos( $_SERVER['REQUEST_URI'],'wp-json/elementor' )
  || isset( $_REQUEST['action'] ) && in_array( sanitize_text_field( $_REQUEST['action'] ),$elementor_actions )
){
  add_filter( 'option_active_plugins', 'eos_ecfe_loading' );
}



add_filter( 'option_active_plugins', 'eos_ecfe_saving_settings_filter' );

function eos_ecfe_loading( $plugins ){
  return eos_dp_ecfe_plugins( $plugins,'loading' );
}

function eos_ecfe_inner( $plugins ){
  return eos_dp_ecfe_plugins( $plugins,'inner' );
}

function eos_ecfe_outer( $plugins ) {
  return eos_dp_ecfe_plugins( $plugins,'outer' );
}

function eos_ecfe_saving_settings_filter( $plugins ){
  if( isset( $_REQUEST['action'] ) && in_array( sanitize_text_field( $_REQUEST['action'] ),array( 'eos_dp_save_elementor_outer_settings','eos_dp_save_elementor_inner_settings','eos_dp_save_elementor_loading_settings' ) ) ){
    return array_merge( array( 'elementor/elementor.php' ),fdp_ecfe_plugins( $plugins ) );
  }
  return $plugins;
}

function eos_dp_ecfe_plugins( $plugins,$page ){
  $opts = eos_dp_get_option( 'fdp_elementor' );
  $elementor_plugins = isset( $opts[$page] ) ? $opts[$page] : array();
  $fdp_plugins = fdp_ecfe_plugins( $plugins );
  $elementor_plugins = $elementor_plugins && is_array( $elementor_plugins ) ? array_merge( $elementor_plugins,$fdp_plugins ) : $fdp_plugins;
  foreach( $elementor_plugins as $plugin ){
    if( in_array( $plugin,$plugins ) || in_array( $plugin,$fdp_plugins ) ){
      unset( $plugins[array_search( $plugin,$plugins )] );
    }
  }
  return array_values( $plugins );
}

function fdp_ecfe_plugins( $plugins ){
  $arr = array(
    'freesoul-deactivate-plugins/freesoul-deactivate-plugins.php',
    'editor-cleanup-for-elementor/editor-cleanup-for-elementor.php'
  );
  if( in_array( 'freesoul-deactivate-plugins-pro/freesoul-deactivate-plugins-pro.php',$plugins ) ){
    $arr[] = 'freesoul-deactivate-plugins-pro/freesoul-deactivate-plugins-pro.php';
  }
  return $arr;
}


add_action( 'plugins_loaded','eos_ecfe_remove_filters',9999 );
add_action( 'activate_plugin','eos_ecfe_remove_filters',9999 );
add_action( 'deactivated_plugin','eos_ecfe_remove_filters',9999 );

function eos_ecfe_remove_filters() {
	foreach( apply_filters( 'ecfe_deactivation_callbacks', 
		array(
			'eos_ecfe_outer' => 0,
			'eos_ecfe_inner' => 0,
			'eos_ecfe_loading' => 0,
			'eos_ecfe_saving_settings_filter' => 0
		)
	) as $callback => $priority ) {
		remove_filter( 'option_active_plugins', $callback, $priority );	
	}  
}