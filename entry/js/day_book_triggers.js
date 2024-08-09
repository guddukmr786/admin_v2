$(document).ready(function() {  
$("#tablesearch").hide();
// Search
$("#search_gks").on('click',function(){
	var query_value = $('input#name').val();
	if(query_value !== ''){
		$.ajax({
			type: "POST",
			url: "search_day_book.php",
			data: { query: query_value },
			cache: false,
			beforeSend: function () {
		       $(".modallodar1").show();
		    },
			success: function(html){
				$(".modallodar1").hide();
				$("table#resultTable tbody").html(html);
				$("#tablesearch_top").hide();
				$("#tablesearch").show();
			}
		});
	}return false;
});


});	 