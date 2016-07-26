$(document).ready(function(){
	$("#btn_direct").click(function(){
		$("#direct").show();
		$("#remote").hide();
		return false;
	});

	$("#btn_remote").click(function(){
		$("#direct").hide();
		$("#remote").show();
		return false;
	});

});