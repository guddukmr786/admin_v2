
$(document).on('change','.hotel'function(){
	var hotel_id = $(this).attr("value");
	$.ajax({
		url : "room_view_byhotel.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
		success:function(data){
			//$(".content_wrapper").hide();
			//$("#show_data").show().html(data);
			window.location.href='room_view.php';
		}
	});
});


