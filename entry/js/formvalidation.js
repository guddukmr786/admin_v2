$(document).ready(function () {

	$('#fname,.gender,#email,#phone,.fkcountry,.idname,.purpose,.ideal-file-filename,#address,#arrival_date,#arrlocation,#passport,#passportexp,#visa,#visa_valid,.booking_via,.bookingid,#checkin,#checkout,#edays,#roomno,.adult,.child,#booking_id,.category,.mode,#pickup,#flight,#noofguest,.exp_type,.receive,#exp_by,#amount,#description,.depart,#room_charge,#h_tax,#comm_inc_gst,#pay_hotel,#gst_18,#g_comm').click(function () {
		$('#fname').css("border", "");
		$('.gender').css("border", "");
		$('#email').css("border", "");
		$('#phone').css("border", "");
		$('.fkcountry').css("border", "");
		$('.idname').css("border", "");
		$('.purpose').css("border", "");
		$('.ideal-file-filename').css("border", "");
		/*$('#address').css("border", "");
		$('#arrival_date').css("border", "");
		$('#arrlocation').css("border", "");
		$('#passport').css("border", "");
		$('#passportexp').css("border", "");
		$('#visa').css("border", "");
		$('#visa_valid').css("border", "");*/
		$('.booking_via').css("border", "");
		$('#bookingid').css("border", "");
		$('#checkin').css("border", "");
		$('#checkout').css("border", "");
		$('#edays').css("border", "");
		$('#roomno').css("border", "");
		$('.adult').css("border", "");
		$('.child').css("border", "");
		$('#booking_id').css("border", "");
		$('.category').css("border", "");
		$('.mode').css("border", "");
		$('#noofguest').css("border", "");
		$('#pickup').css("border", "");
		$('#flight').css("border", "");
		$('.exp_type').css("border", "");
		$('.receive').css("border", "");
		$('#exp_by').css("border", "");
		$('#amount').css("border", "");
		$('#description').css("border", "");
		$('.depart').css("border", "");
		$('#room_charge').css("border", "");
		$('#h_tax').css("border", "");
		$('#g_comm').css("border", "");
		$('#gst_18').css("border", "");
		$('#comm_inc_gst').css("border", "");
		$('#pay_hotel').css("border", "");

	})

});

$('#next').on('click', function (e) {
	var fname = $('#fname');
	var gender = $('.gender');
	var email = $('#email');
	var phone = $('#phone');
	var fkcountry = $('.fkcountry');
	var idname = $('.idname');
	var purpose = $('.purpose');
	var picture = $('#picture');
	/*var address = $('#address');
	var arrival_date = $('#arrival_date');
	var arrlocation = $('#arrlocation');
	var passport = $('#passport');
	var passportexp = $('#passportexp');
	var visa = $('#visa');
	var visa_valid = $('#visa_valid');*/
	if (!fname.val()) {
		$('#fname').css("border", "1px solid red");
		$('#fname').focus();
		e.preventDefault();
		//return false;
	}

	if (!gender.val()) {
		$('.gender').css("border", "1px solid red");
		$('.gender').focus();
		e.preventDefault();
		//return false;
	}

	if (!email.val()) {
		$('#email').css("border", "1px solid red");
		$('#email').focus();
		e.preventDefault();
		//return false;
	}

	if (!phone.val()) {
		$('#phone').css("border", "1px solid red");
		$('#phone').focus();
		e.preventDefault();
		//return false;
	}

	if (!fkcountry.val()) {
		$('.fkcountry').css("border", "1px solid red");
		$('.fkcountry').focus();
		e.preventDefault();
		//return false;
	}

	if (!idname.val()) {
		$('.idname').css("border", "1px solid red");
		$('.idname').focus();
		e.preventDefault();
		//return false;
	}


	if (!purpose.val()) {
		$('.purpose').css("border", "1px solid red");
		$('.purpose').focus();
		e.preventDefault();
		//return false;
	}

	if (!picture.val()) {
		$('.ideal-file-filename').css("border", "1px solid red");
		$('ideal-file-filename').focus();
		e.preventDefault();
		//return false;
	}

	/*if(!address.val()) {
		$('#address').css("border", "1px solid red");
		$('#address').focus();
		e.preventDefault();
		//return false;
	}*/

	if (fname.val()) {
		$('#fname').css("border", "");
	}

	if (gender.val()) {
		$('.gender').css("border", "");
	}

	if (email.val()) {
		$('#email').css("border", "");
	}

	if (phone.val()) {
		$('#phone').css("border", "");
	}

	if (fkcountry.val()) {
		$('.fkcountry').css("border", "");
	}

	if (idname.val()) {
		$('.idname').css("border", "");
	}

	if (purpose.val()) {
		$('#purpose').css("border", "");
	}

	if (picture.val()) {
		$('.ideal-file-filename').css("border", "");
	}
	/*if(address.val()) {
		$('#address').css("border", "");
	}*/

});


//next button 2

$('#preview').on('click', function (e) {
	var booking_via = $('.booking_via');
	var bookingid = $('#bookingid');
	var checkin = $('#checkin');
	var checkout = $('#checkout');
	var roomno = $('#roomno');
	var adult = $('.adult');

	var fname = $('#fname');
	var email = $('#email');
	var phone = $('#phone');
	var fkcountry = $('.fkcountry');

	if (!booking_via.val()) {
		$('.booking_via').css("border", "1px solid red");
		$('.booking_via').focus();
		e.preventDefault();
		//return false;
	}

	if (!bookingid.val()) {
		$('#bookingid').css("border", "1px solid red");
		$('#bookingid').focus();
		e.preventDefault();
		//return false;
	}

	if (!checkin.val()) {
		$('#checkin').css("border", "1px solid red");
		$('#checkin').focus();
		e.preventDefault();
		//return false;
	}

	if (!checkout.val()) {
		$('#checkout').css("border", "1px solid red");
		$('#checkout').focus();
		e.preventDefault();
		//return false;
	}

	if (!roomno.val()) {
		$('#roomno').css("border", "1px solid red");
		$('#roomno').focus();
		e.preventDefault();
		//return false;
	}

	if (!fname.val()) {
		$('#fname').css("border", "1px solid red");
		$('#fname').focus();
		e.preventDefault();
		//return false;
	}

	if (!email.val()) {
		$('#email').css("border", "1px solid red");
		$('#email').focus();
		e.preventDefault();
		//return false;
	}

	if (!phone.val()) {
		$('#phone').css("border", "1px solid red");
		$('#phone').focus();
		e.preventDefault();
		//return false;
	}

	if (!fkcountry.val()) {
		$('.fkcountry').css("border", "1px solid red");
		$('.fkcountry').focus();
		e.preventDefault();
		//return false;
	}



	if (booking_via.val()) {
		$('.booking_via').css("border", "");
	}

	if (bookingid.val()) {
		$('#bookingid').css("border", "");
	}

	if (checkin.val()) {
		$('#checkin').css("border", "");
	}

	if (checkout.val()) {
		$('#checkout').css("border", "");
	}

	if (roomno.val()) {
		$('#roomno').css("border", "");
	}

	if (fname.val()) {
		$('#fname').css("border", "");
	}

	if (email.val()) {
		$('#email').css("border", "");
	}

	if (phone.val()) {
		$('#phone').css("border", "");
	}

	if (fkcountry.val()) {
		$('.fkcountry').css("border", "");
	}

});

$('#submit_arr_booking').on('click', function (e) {

	var fname = $('#fname');
	var phone = $('#phone');
	var fkcountry = $('.fkcountry');
	var booking_via = $('.booking_via');
	var checkin = $('#checkin');
	var checkout = $('#checkout');
	var category = $('.category');
	var noofguest = $('#noofguest');
	var flight = $('#flight');
	var room_charge = $('#room_charge');
	var h_tax = $('#h_tax');
	var g_comm = $('#g_comm');
	var gst_18 = $('#gst_18');
	/*var a_charge = $('#a_charge');*/
	var comm_inc_gst = $('#comm_inc_gst');
	var pay_hotel = $('#pay_hotel');

	if (!fname.val()) {
		$('#fname').css("border", "1px solid red");
		$('#fname').focus();
		e.preventDefault();
	}

	if (!phone.val()) {
		$('#phone').css("border", "1px solid red");
		$('#phone').focus();
		e.preventDefault();
	}
	if (!fkcountry.val()) {
		$('.fkcountry').css("border", "1px solid red");
		$('.fkcountry').focus();
		e.preventDefault();
	}

	if (!booking_via.val()) {
		$('.booking_via').css("border", "1px solid red");
		$('.booking_via').focus();
		e.preventDefault();
	}

	if (!checkin.val()) {
		$('#checkin').css("border", "1px solid red");
		$('#checkin').focus();
		e.preventDefault();
	}

	if (!checkout.val()) {
		$('#checkout').css("border", "1px solid red");
		$('#checkout').focus();
		e.preventDefault();
	}

	if (!category.val()) {
		$('.category').css("border", "1px solid red");
		$('.category').focus();
		e.preventDefault();
	}

	if (!noofguest.val()) {
		$('#noofguest').css("border", "1px solid red");
		$('#noofguest').focus();
		e.preventDefault();
	}

	if (!flight.val()) {
		$('#flight').css("border", "1px solid red");
		$('#flight').focus();
		e.preventDefault();
	}

	if (!room_charge.val()) {
		$('#room_charge').css("border", "1px solid red");
		$('#room_charge').focus();
		e.preventDefault();
	}
	if (!h_tax.val()) {
		$('#h_tax').css("border", "1px solid red");
		$('#h_tax').focus();
		e.preventDefault();
	}
	if (!g_comm.val()) {
		$('#g_comm').css("border", "1px solid red");
		$('#g_comm').focus();
		e.preventDefault();
	}

	if (!gst_18.val()) {
		$('#gst_18').css("border", "1px solid red");
		$('#gst_18').focus();
		e.preventDefault();
	}

	/*if(!a_charge.val()) {
	$('#a_charge').css("border", "1px solid red");
	$('#a_charge').focus();
	e.preventDefault();
}*/


	if (!comm_inc_gst.val()) {
		$('#comm_inc_gst').css("border", "1px solid red");
		$('#comm_inc_gst').focus();
		e.preventDefault();
	}

	if (!pay_hotel.val()) {
		$('#pay_hotel').css("border", "1px solid red");
		$('#pay_hotel').focus();
		e.preventDefault();
	}

});

$("#day_book").click(function (e) {
	var fname = $('#fname');
	var father_name = $('#father_name');
	var home_contact = $('#home_contact');
	var salary = $('#salary');
	var convenience = $('#convenience');
	var total = $('#total');
	var ref_contact = $('#ref_contact');
	var current_address = $('#current_address');
	var exp_type = $('.exp_type');
	var receive = $('.receive');
	var exp_by = $('#exp_by');
	var amount = $('#amount');
	var checkin = $('#checkin');
	var depart = $('.depart');
	var phone = $('#phone');

	if (!fname.val()) {
		$('#fname').css("border", "1px solid red");
		$('#fname').focus();
		e.preventDefault();
	}

	if (!father_name.val()) {
		$('#father_name').css("border", "1px solid red");
		$('#father_name').focus();
		e.preventDefault();
	}

	if (!home_contact.val()) {
		$('#home_contact').css("border", "1px solid red");
		$('#home_contact').focus();
		e.preventDefault();
	}

	if (!salary.val()) {
		$('#salary').css("border", "1px solid red");
		$('#salary').focus();
		e.preventDefault();
	}

	if (!convenience.val()) {
		$('#convenience').css("border", "1px solid red");
		$('#convenience').focus();
		e.preventDefault();
	}

	if (!total.val()) {
		$('#total').val("border", "1px solid red");
		$('#total').focus();
		e.preventDefault();
	}

	if (!ref_contact.val()) {
		$('#ref_contact').css("border", "1px solid red");
		$('#ref_contact').focus();
		e.preventDefault();
	}

	if (!current_address.val()) {
		$('.current_address').css("border", "1px solid red");
		$('.current_address').focus();
		e.preventDefault();
	}

	if (!exp_type.val()) {
		$('.exp_type').css("border", "1px solid red");
		$('.exp_type').focus();
		e.preventDefault();
	}
	if (!receive.val()) {
		$('.receive').css("border", "1px solid red");
		$('.receive').focus();
		e.preventDefault();
	}

	if (!exp_by.val()) {
		$('#exp_by').css("border", "1px solid red");
		$('#exp_by').focus();
		e.preventDefault();
	}

	if (!amount.val()) {
		$('#amount').css("border", "1px solid red");
		$('#amount').focus();
		e.preventDefault();
	}

	if (!checkin.val()) {
		$('#checkin').css("border", "1px solid red");
		$('#checkin').focus();
		e.preventDefault();
	}
	if (!depart.val()) {
		$('.depart').css("border", "1px solid red");
		$('.depart').focus();
		e.preventDefault();
	}

	if (!phone.val()) {
		$('#phone').css("border", "1px solid red");
		$('#phone').focus();
		e.preventDefault();
		//return false;
	}

});


//next button 2