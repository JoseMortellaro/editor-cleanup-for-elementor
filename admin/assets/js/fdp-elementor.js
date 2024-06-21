jQuery(document).ready(function($){
  $(".eos-dp-save-eos_dp_ecfe_" + fdp_elementor.page).on("click", function () {
    $('.eos-dp-opts-msg').addClass('eos-hidden');
    var chk,str = '';
    $('.eos-dp-elementor').each(function(){
      chk = $(this);
      str += !chk.is(':checked') ? ',' + $(this).attr('data-path') : ',';
    });
    eos_dp_send_ajax($(this),{
      "nonce" : $("#eos_dp_elementor_" + fdp_elementor.page + "_setts").val(),
      "eos_dp_elementor_data" : str,
      "page" : fdp_elementor.page,
      "action" : 'eos_dp_save_elementor_' + fdp_elementor.page + '_settings'
    });
    return false;
  });
});
