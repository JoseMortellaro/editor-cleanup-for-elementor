<?php
defined( 'FDP_ECFE_PLUGIN_DIR' ) || exit;

$titles = eos_dp_ecfe_titles();
$left = is_rtl() ? 'right' : 'left';
$kses = array( 'a' => array( 'href' => array(),'class' => array() ) );
?>
<style id="fdp-elementor-index-css">
.fdp-descriptions .button,
#fdp-elementor-index-section .button {
  background: #000 !important;
  color: #fff !important
}
.fdp-descriptions .button:hover,
#fdp-elementor-index-section .button:hover {
  background: #fff !important;
  color: #000 !important
}
#dolly{display:none}
#fdp-elementor-outer-setts-wrp {
  <?php echo esc_attr( $left ); ?>: 0;
  margin-<?php echo esc_attr( $left ); ?>: 8px;
  top:50%
}
#fdp-elementor-inner-setts-wrp,#fdp-elementor-loading-setts-wrp {
  <?php echo esc_attr( $left ); ?>: 60%;
  -o-transform:translateX(-50%);
  -ms-transform:translateX(-50%);
  -moz-transform:translateX(-50%);
  -webkit-transform:translateX(-50%);
  transform:translateX(-50%);
  top:50%
}
#fdp-elementor-loading-setts-wrp{
  top:52%;
  top:calc(50% + 64px)
}
#fdp-elementor-loading-setts-url:after {
  content: "\f111";
  position: absolute;
  top:0;
  <?php echo esc_attr( $left ); ?>:50%;
  z-index: 99999999;
  font-family: dashicons;
  margin-left: -20px;
  font-size: 40px;
}
</style>
<h2><?php esc_html_e( 'Editor Cleanup For Elementor.','editor-cleanup-for-elementor' ); ?></h2>
<section id="fdp-elementor-index-section" style="position:relative;width:99%;width:calc(100% - 20px);margin:32px auto 0 auto;height:0;padding-bottom:60%;background-repeat:no-repeat;background-image:url(<?php echo FDP_ECFE_PLUGIN_URL; ?>/admin/assets/img/elementor-editor-screen.png);background-size:contain">
  <?php foreach( $titles as $k => $title ){ ?>
  <div id="fdp-elementor-<?php echo esc_attr( $k ); ?>-setts-wrp" class="fdp-elementor-setts-wrp" style="background:#fff;position:absolute">
    <a id="fdp-elementor-<?php echo esc_attr( $k ); ?>-setts-url" class="button" href="<?php echo esc_attr( esc_url( admin_url( 'admin.php?page=eos_dp_ecfe_'.esc_attr( $k ) ) ) ); ?>"><?php echo esc_html( $title ); ?></a>
  </div>
  <?php } ?>
</section>
<div class="fdp-descriptions" style="margin-top:64px">
  <p><?php echo wp_kses( sprintf( __( 'Click on %sOuter editor cleanup%s to disable the plugins that are not needed in the outer editor (usually no plugin needed)','editor-cleanup-for-elementor' ),'<a href="'.admin_url( 'admin.php?page=eos_dp_ecfe_outer' ).'" class="button">','</a>' ),$kses ); ?></p>
  <p><?php echo wp_kses( sprintf( __( 'Click on %sInner editor cleanup%s to disable the plugins that are not needed in the inner editor does\'t need (the inner editor is like the page on frontend, but loaded inside the Elementor editor)','editor-cleanup-for-elementor' ),'<a href="'.admin_url( 'admin.php?page=eos_dp_ecfe_inner' ).'" class="button">','</a>' ),$kses ); ?></p>
  <p><?php echo wp_kses( sprintf( __( 'Click on %sEditor loading cleanup%s to disable the plugins that are called during the loading of the editor (usually no plugin needed, disabling plugins here can solve conflicts with other plugins)','editor-cleanup-for-elementor' ),'<a href="'.admin_url( 'admin.php?page=eos_dp_ecfe_loading' ).'" class="button">','</a>' ),$kses ); ?></p>
</div>
