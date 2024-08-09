$('#serial,.nametitle,#fname,.gender,#relation,#email,#phone,.fkcountry,#city,#pin,.day,.month,.year,.idname,#idno,#lastlocation,#nextlocation,.purpose,#address,#arrival_date,#arrlocation,#passport,#passportexp,#visa,#visa_valid,#next,.booking_via,.bookingid,#checkin,#checkout,#nights,#b_amount,#edays,#roomno,.adult,.child,ex_ad_charges,.meal_plan,#booking_id,.category,.mode,#company,#pickup,#name,#noofguest,#noofroom,.exp_type,.receive,#exp_by,#amount,#description').click(function () {
	var formData = $("#checkin_form").serialize();
	$.ajax({
		type: "POST",
		url: 'insert_data.php?type=save_entry_formdata',
		data: formData,
		success: function (data) {
		}
	});
})

//save day book data in session
$('.exp_type,.receive,#exp_by,#amount,#description').click(function () {
	var formData = $("#day_book_form").serialize();
	$.ajax({
		type: "POST",
		url: 'insert_data.php?type=save_day_book_data',
		data: formData,
		success: function (data) {
		}
	});
})

$("#reset_day_book").click(function () {
	if (confirm("Are you sure you want to Cleare all field data?")) {
		$.ajax({
			url: 'insert_data.php?type=reset_day_book',
			success: function (data) {
				if (data == 'success') {
					location.reload();
				} else {

				}
			}
		});
	}
	else {
		return false;
	}

});


$("#reset").click(function () {
	if (confirm("Are you sure you want to Cleare all field data?")) {
		$.ajax({
			url: 'insert_data.php?type=reset',
			success: function (data) {
				if (data == 'success') {
					location.reload();
				} else {

				}
			}
		});
	}
	else {
		return false;
	}

});

$("#reset_room").click(function () {
	if (confirm("Are you sure you want to Cleare all field data?")) {
		$.ajax({
			url: 'insert_data.php?type=reset',
			success: function (data) {
				if (data == 'success') {
					window.location.href = "room_view.php";
				} else {

				}
			}
		});
	}
	else {
		return false;
	}

});

$("#reset_arrival").click(function () {
	if (confirm("Are you sure you want to Cleare all field data?")) {
		$.ajax({
			url: 'insert_data.php?type=reset',
			success: function (data) {
				if (data == 'success') {
					window.location.href = "arrival_booking_list.php";
				} else {

				}
			}
		});
	}
	else {
		return false;
	}

});

