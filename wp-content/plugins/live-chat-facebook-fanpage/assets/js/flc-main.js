jQuery(document).ready(function($) {
    // fare cose jQuery quando DOM � pronto
	$(function(){
	$("#addClass").click(function () {
			$('#qnimate').addClass('popup-box-on');
		});
		
			$("#removeClass").click(function () {
			$('#qnimate').removeClass('popup-box-on');
		});
	  })
	  
});