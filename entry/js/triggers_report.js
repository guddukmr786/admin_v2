
$(document).ready(function() {  
$("#tablesearch").hide();
// Search
$("#search_gks").on('click',function(){
	var query_value = $('input#name').val();
	if(query_value !== ''){
		$.ajax({
			type: "POST",
			url: "search_report.php",
			data: { query: query_value },
			cache: false,
			beforeSend: function () {
		       $(".modallodar2").show();
		    },
			success: function(html){
				$(".modallodar2").hide();
				$("table#resultTable tbody").html(html);
				$("#tablesearch_top").hide();
				$("#tablesearch").show();
			}
		});
	}return false;
});

$("input#name").on("keyup", function(e) {
	var search_string = $(this).val();
	// Do Search
	if (search_string == '') {
		$("#tablesearch_top").show();
		$("#tablesearch").hide();
	}
});
});	    
