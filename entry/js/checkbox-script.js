//hide and show all sub menu of previlage
$(document).ready(function(){
	$(".glyphicon-plus").click(function(){
	   $(this).closest('li').find('ul.chil-ul').slideToggle();
	});

});


$("#xnode-0-1").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-1-1").prop("checked",true);
		$("#xnode-0-1-2").prop("checked",true);
	}else{
		$("#xnode-0-1-1").prop("checked",false);
		$("#xnode-0-1-2").prop("checked",false);
	}
});

$("#xnode-0-1-1,#xnode-0-1-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-1-1").is(":checked") || $("#xnode-0-1-2").is(":checked") ){
		$("#xnode-0-1").prop("checked",true);
	}else{
		$("#xnode-0-1").prop("checked",false);
	}
});

$("#xnode-0-2").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-2-1").prop("checked",true);
		$("#xnode-0-2-2").prop("checked",true);
	}else{
		$("#xnode-0-2-1").prop("checked",false);
		$("#xnode-0-2-2").prop("checked",false);
	}
});
$("#xnode-0-2-1,#xnode-0-2-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-2-1").is(":checked") || $("#xnode-0-2-1").is(":checked") ){
		$("#xnode-0-2").prop("checked",true);
	}else{
		$("#xnode-0-2").prop("checked",false);
	}
});


$("#xnode-0-3").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-3-1").prop("checked",true);
		$("#xnode-0-3-2").prop("checked",true);
	}else{
		$("#xnode-0-3-1").prop("checked",false);
		$("#xnode-0-3-2").prop("checked",false);
	}
});
$("#xnode-0-3-1,#xnode-0-3-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-3-1").is(":checked") || $("#xnode-0-3-2").is(":checked") ){
		$("#xnode-0-3").prop("checked",true);
	}else{
		$("#xnode-0-3").prop("checked",false);
	}
});

$("#xnode-0-4").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-4-1").prop("checked",true);
		$("#xnode-0-4-2").prop("checked",true);
	}else{
		$("#xnode-0-4-1").prop("checked",false);
		$("#xnode-0-4-2").prop("checked",false);
	}
});
$("#xnode-0-4-1,#xnode-0-4-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-4-1").is(":checked") || $("#xnode-0-4-2").is(":checked") ){
		$("#xnode-0-4").prop("checked",true);
	}else{
		$("#xnode-0-4").prop("checked",false);
	}
});

$("#xnode-0-5").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-5-1").prop("checked",true);
		$("#xnode-0-5-2").prop("checked",true);
	}else{
		$("#xnode-0-5-1").prop("checked",false);
		$("#xnode-0-5-2").prop("checked",false);
	}
});
$("#xnode-0-5-1,#xnode-0-5-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-5-1").is(":checked") || $("#xnode-0-5-2").is(":checked") ){
		$("#xnode-0-5").prop("checked",true);
	}else{
		$("#xnode-0-5").prop("checked",false);
	}
});


$("#xnode-0-6").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-6-1").prop("checked",true);
		$("#xnode-0-6-2").prop("checked",true);
		$("#xnode-0-6-3").prop("checked",true);
		$("#xnode-0-6-4").prop("checked",true);
		$("#xnode-0-6-5").prop("checked",true);
		$("#xnode-0-6-6").prop("checked",true);
		$("#xnode-0-6-7").prop("checked",true);
	}else{
		$("#xnode-0-6-1").prop("checked",false);
		$("#xnode-0-6-2").prop("checked",false);
		$("#xnode-0-6-3").prop("checked",false);
		$("#xnode-0-6-4").prop("checked",false);
		$("#xnode-0-6-5").prop("checked",false);
		$("#xnode-0-6-6").prop("checked",false);
		$("#xnode-0-6-7").prop("checked",false);

	}
});
$("#xnode-0-6-1,#xnode-0-6-2,#xnode-0-6-3,#xnode-0-6-3,#xnode-0-6-5,#xnode-0-6-6,#xnode-0-6-7").click(function(){
	var $this = $(this);
	if($("#xnode-0-6-1").is(":checked") || $("#xnode-0-6-2").is(":checked") || $("#xnode-0-6-3").is(":checked") || $("#xnode-0-6-4").is(":checked") || $("#xnode-0-6-5").is(":checked") || $("#xnode-0-6-6").is(":checked") || $("#xnode-0-6-7").is(":checked")){

		$("#xnode-0-6").prop("checked",true);
	}else{
		$("#xnode-0-6").prop("checked",false);
	}
});

$("#xnode-0-7").click(function(){
	var $this = $(this);
	if($this.is(":checked")){
		$("#xnode-0-7-1").prop("checked",true);
		$("#xnode-0-7-2").prop("checked",true);
	}else{
		$("#xnode-0-7-1").prop("checked",false);
		$("#xnode-0-7-2").prop("checked",false);
	}
});
$("#xnode-0-7-1,#xnode-0-7-2").click(function(){
	var $this = $(this);
	if($("#xnode-0-7-1").is(":checked") || $("#xnode-0-7-2").is(":checked") ){
		$("#xnode-0-7").prop("checked",true);
	}else{
		$("#xnode-0-7").prop("checked",false);
	}
});
