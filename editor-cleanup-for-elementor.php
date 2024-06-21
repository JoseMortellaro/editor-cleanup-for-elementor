<?php
/*
Plugin Name: Editor Cleanup For Elementor
Description: An FDP add-on to speed up Elementor in the backend
Author: Jose Mortellaro
Author URI: https://josemortellaro.com/
Text Domain: editor-cleanup-for-elementor
Domain Path: /languages/
Version: 0.0.6
Requires Plugins: freesoul-deactivate-plugins, elementor
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

define( 'FDP_ECFE_PLUGIN_VERSION','0.0.6' );
define( 'FDP_ECFE_PLUGIN_FILE', untrailingslashit( plugin_basename( __FILE__ ) ) );
define( 'FDP_ECFE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

if( is_admin() ){
  define( 'FDP_ECFE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
  add_action( 'plugins_loaded',function(){
    define( 'FDP_ECFE_PLUGINS_DIR', untrailingslashit( dirname( __DIR__ ) ) );
    if( wp_doing_ajax() && isset( $_REQUEST['action'] ) && false !== strpos( $_REQUEST['action'],'eos_dp' ) ){
      require_once FDP_ECFE_PLUGIN_DIR.'/admin/ecfe-ajax.php';
    }
    if( defined( 'EOS_DP_VERSION' ) && defined( 'EOS_DP_PLUGIN_DIR' ) && defined( 'ELEMENTOR__FILE__' ) ){
      if( version_compare( '2.1.6',EOS_DP_VERSION ) < 0 ){
        define( 'FDP_ELEMENTOR_PLUGIN_FILE', untrailingslashit( plugin_basename( ELEMENTOR__FILE__ ) ) );
        require_once FDP_ECFE_PLUGIN_DIR.'/admin/ecfe-admin.php';
      }
    }
    elseif( defined( 'EOS_DP_VERSION' ) && !defined( 'ELEMENTOR__FILE__' ) ){
      require_once FDP_ECFE_PLUGIN_DIR.'/admin/ecfe-elementor-inactive.php';
    }
    elseif( !defined( 'EOS_DP_VERSION' ) && !defined( 'ELEMENTOR__FILE__' ) ){
      require_once FDP_ECFE_PLUGIN_DIR.'/admin/ecfe-fdp-elementor-inactive.php';
    }
    elseif( !defined( 'EOS_DP_VERSION' ) && defined( 'ELEMENTOR__FILE__' ) ){
      require_once FDP_ECFE_PLUGIN_DIR.'/admin/ecfe-fdp-inactive.php';
    }
  } );
}

//Actions triggered after plugin activation or after a new site of a multisite installation is created
function eos_dp_ecfe_initialize_plugin( $networkwide ){
    if( is_multisite() && $networkwide ){
		wp_die( sprintf( esc_html__( "Editor Cleanup For Elementor can't be activated networkwide, but only on each single site. %s%s%s","editor-cleanup-for-elementor" ),'<div><a class="button" href="'.admin_url( 'network/plugins.php' ).'">',esc_html__( 'Back to plugins','editor-cleanup-for-elementor' ),'</a></div>' ) );
	}
	require FDP_ECFE_PLUGIN_DIR.'/plugin-activation.php';
}

register_activation_hook( __FILE__, 'eos_dp_ecfe_initialize_plugin' );

//Actions triggered after plugin deaactivation
function eos_dp_ecfe_deactivate_plugin(){
	if( !is_multisite() && file_exists( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' ) ){
		unlink( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' );
	}
}

register_deactivation_hook( __FILE__, 'eos_dp_ecfe_deactivate_plugin' );

add_action( 'upgrader_process_complete', 'eos_dp_ecfe_after_upgrade',10,2 );
//Update mu-plugin after upgrade
function eos_dp_ecfe_after_upgrade( $upgrader_object, $options ) {
    $update_mu = false;
    if( isset( $options['plugins'] ) && is_array( $options['plugins'] ) && !empty( $options['plugins'] ) && isset( $options['action'] ) && 'update' === $options['action'] && isset( $options['type'] ) && 'plugin' === $options['type'] ) {
       foreach( $options['plugins'] as $plugin ) {
          if( FDP_ECFE_PLUGIN_FILE === $plugin  ){
            $update_mu = true;
            break;
          }
       }
    }
    elseif( isset( $upgrader_object->new_plugin_data ) ){
      $new_plugin_data = $upgrader_object->new_plugin_data;
      if( isset( $new_plugin_data['TextDomain'] ) && 'editor-cleanup-for-elementor' === $new_plugin_data['TextDomain'] ){
        $update_mu = true;
      }
    }
    if( $update_mu ){
      if( file_exists( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' ) ){
        unlink( WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php' );
      }
      eos_dp_ecfe_write_file( FDP_ECFE_PLUGIN_DIR.'/mu-plugins/fdp-mu-elementor.php',WPMU_PLUGIN_DIR,WPMU_PLUGIN_DIR.'/fdp-mu-elementor.php',true );
    }
}

//Helper function to write file
function eos_dp_ecfe_write_file( $source,$destination_dir,$destination,$update_info = false ){
	$writeAccess = false;
	$access_type = get_filesystem_method();
	if( $access_type === 'direct' ){
		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials( admin_url(), '', false, false, array() );
		/* initialize the API */
		if ( ! WP_Filesystem( $creds ) ) {
			/* any problems and we exit */
			return false;
		}
		global $wp_filesystem;
		$writeAccess = true;
		if( empty( $wp_filesystem ) ){
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		if( !$wp_filesystem->is_dir( $destination_dir ) ){
			/* directory didn't exist, so let's create it */
			$wp_filesystem->mkdir( $destination_dir );
		}

		$copied = @$wp_filesystem->copy( $source,$destination );
		if ( !$copied ) {
			printf( esc_html__( 'Failed to create %s','editor-cleanup-for-elementor' ),$destination );
		}
		else{
			if( $update_info ){
				set_transient( 'fdp-elementor-notice-succ', true, 5 );
			}
		}
	}
	else{
		if( $update_info ){
			set_transient( 'fdp-elementor-notice-fail', true, 5 ); /* don't have direct write access. Prompt user with our notice */
		}
	}
}
