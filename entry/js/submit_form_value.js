$("#day_book").click(function(){
	var formData = $("#day_book_form").serialize();
	$.ajax({
		url : 'insert_data.php?type=day_book',
		type : 'post',
		data : formData,
		beforeSend: function () {
		    $(".modallodar").show();
		},
		success : function(data){
			$(".modallodar").hide();
			if(data == 0){
				//$("#day_book_form")[0].reset();
				$("#message").html("<div style='color:green;margin-left:25px;'>Your data has been successfully saved.<div>");
				$("#amount").val("");
				$("#description").val("");
				
			}else if(data == 1){
				$("#message").html("<div style='color:red;margin-left:25px;'>Please fill in all required fields marked with an asterisk.<div>");
			}
		}
	});
});