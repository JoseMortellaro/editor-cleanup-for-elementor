<?php
defined( 'ABSPATH' ) || exit;

foreach( array( 'outer','inner','loading' ) as $page ){
	add_action( 'wp_ajax_eos_dp_save_elementor_'.$page.'_settings','eos_dp_save_elementor_'.$page.'_settings' );
}
//Saves activation/deactivation settings for elementor outer editor
function eos_dp_save_elementor_outer_settings(){
	eos_dp_save_elementor_settings( 'outer' );
}
//Saves activation/deactivation settings for elementor inner editor
function eos_dp_save_elementor_inner_settings(){
	eos_dp_save_elementor_settings( 'inner' );
}
//Saves activation/deactivation settings for elementor loading editor
function eos_dp_save_elementor_loading_settings(){
	eos_dp_save_elementor_settings( 'loading' );
}
//Callback for saving elementor editor settings
function eos_dp_save_elementor_settings( $page ){
	eos_dp_check_intentions_and_rights( 'eos_dp_elementor_'.$page.'_setts' );
	if( isset( $_POST['eos_dp_elementor_data'] ) && !empty( $_POST['eos_dp_elementor_data'] ) && isset( $_POST['page'] ) && !empty( $_POST['page'] ) ){
		$opts = eos_dp_get_option( 'fdp_elementor' );
		$opts[sanitize_key( $_POST['page'] )] = array_filter( explode( ',',sanitize_text_field( $_POST['eos_dp_elementor_data'] ) ) );
		eos_dp_update_option( 'fdp_elementor',$opts,false );
		echo 1;
		die();
	}
	echo 0;
	die();
}
