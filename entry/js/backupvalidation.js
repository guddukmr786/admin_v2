$(document).ready(function(){ 
	$('#fname,.gender,#email,#phone,.fkcountry,#city,.day,.month,.year,.idname,#idno,.purpose,#picture,#address,#arrival_date,#arrlocation,#passport,#passportexp,#visa,#visa_valid,.booking_via,.bookingid,#checkin,#checkout,#edays,#roomno,.adult,.child,#b_amount').click(function(){
		$('#fname').css("border", "");
		//$('#lname').css("border", "");
		$('.gender').css("border", "");
		//$('#relation').css("border", "");
		$('#email').css("border", "");
		$('#phone').css("border", "");
		$('.fkcountry').css("border", "");
		$('#city').css("border", "");
		//$('#pin').css("border", "");
		$('.day').css("border", "");
		$('.month').css("border", "");
		$('.year').css("border", "");
		$('.idname').css("border", "");
		$('#idno').css("border", "");
		//$('#lastlocation').css("border", "");
		//$('#nextlocation').css("border", "");
		$('.purpose').css("border", "");
		$('#picture').css("border", "");
		$('#address').css("border", "");
		$('#arrival_date').css("border", "");
		$('#arrlocation').css("border", "");
		$('#passport').css("border", "");
		$('#passportexp').css("border", "");
		$('#visa').css("border", "");
		$('#visa_valid').css("border", "");
		$('.booking_via').css("border", "");
		$('#bookingid').css("border", "");
		$('#checkin').css("border", "");
		$('#checkout').css("border", "");
		$('#edays').css("border", "");
		$('#roomno').css("border", "");
		$('.adult').css("border", "");
		$('.child').css("border", "");
		$('#b_amount').css("border", "");
		//$('#ex_ad_charges').css("border", "");
		//$('.meal_plan').css("border", "");
	})
});
$('#next').on('click', function(e) {
	var fname = $('#fname');
	//var lname = $('#lname');
	var gender = $('.gender');
	//var relation = $('#relation');
	var email = $('#email');
	var phone = $('#phone');
	var fkcountry = $('.fkcountry');
	var city = $('#city');
	//var pin = $('#pin');
	var day = $('.day');
	var month = $('.month');
	var year = $('.year');
	var idname = $('.idname');
	var idno = $('#idno');
	//var lastlocation = $('#lastlocation');
	//var nextlocation = $('#nextlocation');
	var purpose = $('.purpose');
	var picture = $('#picture');
	var address = $('#address');
	var arrival_date = $('#arrival_date');
	var arrlocation = $('#arrlocation');
	var passport = $('#passport');
	var passportexp = $('#passportexp');
	var visa = $('#visa');
	var visa_valid = $('#visa_valid');
	/*var booking_via = $('.booking_via');
	var bookingid = $('#bookingid');
	var checkin = $('#checkin');
	var checkout = $('#checkout');
	var edays = $('#edays');
	var roomno = $('#roomno');
	var adult = $('.adult');
	var child = $('.child');
	var b_amount = $('#b_amount');
	//var ex_ad_charges = $('#ex_ad_charges');
	//var meal_plan = $('.meal_plan');*/
	if(!fname.val()) {
		$('#fname').css("border", "1px solid red");
		$('#fname').focus();
		e.preventDefault();
		return false;
	}

	//if(!lname.val()) {
		//$('#lname').css("border", "1px solid red");
		//e.preventDefault();
        //return false;
	//}

	if(!gender.val()) {
		$('.gender').css("border", "1px solid red");
		$('.gender').focus();
		e.preventDefault();
		return false;
	}

	/*if(!relation.val()) {
		$('#relation').css("border", "1px solid red");
		$('#relation').focus();
		e.preventDefault();
		return false;
	}*/

	if(!email.val()) {
		$('#email').css("border", "1px solid red");
		$('#email').focus();
		e.preventDefault();
		return false;
	}

	if(!phone.val()) {
		$('#phone').css("border", "1px solid red");
		$('#phone').focus();
		e.preventDefault();
		return false;
	}

	if(!fkcountry.val()) {
		$('.fkcountry').css("border", "1px solid red");
		$('.fkcountry').focus();
		e.preventDefault();
		return false;
	}

	if(!city.val()) {
		$('#city').css("border", "1px solid red");
		$('#city').focus();
		e.preventDefault();
		return false;
	}
	if(!day.val()) {
		$('.day').css("border", "1px solid red");
		$('.day').focus();
		e.preventDefault();
		return false;
	}
	if(!month.val()) {
		$('.month').css("border", "1px solid red");
		$('.month').focus();
		e.preventDefault();
		return false;
	}
	if(!year.val()) {
		$('.year').css("border", "1px solid red");
		$('.year').focus();
		e.preventDefault();
		return false;
	}

	if(!idname.val()) {
		$('.idname').css("border", "1px solid red");
		$('.idname').focus();
		e.preventDefault();
		return false;
	}

	if(!idno.val()) {
		$('#idno').css("border", "1px solid red");
		$('#idno').focus();
		e.preventDefault();
		return false;
	}
      
	if(!purpose.val()) {
		$('.purpose').css("border", "1px solid red");
		$('.purpose').focus();
		e.preventDefault();
		return false;
	}
	if(!picture.val()) {
		$('#picture').css("border", "1px solid red");
		//alert("Please select ID's");
		$('#picture').focus();
		e.preventDefault();
		return false;
	}

	if(!address.val()) {
		$('#address').css("border", "1px solid red");
		$('#address').focus();
		e.preventDefault();
		return false;
	}

	if(!arrival_date.val()) {
		$('#arrival_date').css("border", "1px solid red");
		$('#arrival_date').focus();
		e.preventDefault();
		return false;
	}

	if(!arrlocation.val()) {
		$('#arrlocation').css("border", "1px solid red");
		$('#arrlocation').focus();
		e.preventDefault();
		return false;
	}
	if(!passport.val()) {
		$('#passport').css("border", "1px solid red");
		$('#passport').focus();
		e.preventDefault();
		return false;
	}

	if(!passportexp.val()) {
		$('#passportexp').css("border", "1px solid red");
		$('#passportexp').focus();
		e.preventDefault();
		return false;
	}

	if(!visa.val()) {
		$('#visa').css("border", "1px solid red");
		$('#visa').focus();
		e.preventDefault();
		return false;
	}

	if(!visa_valid.val()) {
		$('#visa_valid').css("border", "1px solid red");
		$('#visa_valid').focus();
		e.preventDefault();
		return false;
	}
      
  	/*if(!booking_via.val()) {
		$('.booking_via').css("border", "1px solid red");
		$('.booking_via').focus();
		e.preventDefault();
		return false;
	}

	if(!bookingid.val()) {
		$('#bookingid').css("border", "1px solid red");
		$('#bookingid').focus();
		e.preventDefault();
		return false;
	}

	if(!checkin.val()) {
		$('#checkin').css("border", "1px solid red");
		$('#checkin').focus();
		e.preventDefault();
      return false;
	}

	if(!checkout.val()) {
		$('#checkout').css("border", "1px solid red");
		$('#checkout').focus();
		e.preventDefault();
        return false;
	}    
	if(!edays.val()) {
		$('#edays').css("border", "1px solid red");
		$('#edays').focus();
		e.preventDefault();
        return false;
	}

	if(!roomno.val()) {
		$('#roomno').css("border", "1px solid red");
		$('#roomno').focus();
		e.preventDefault();
        return false;
	}

	if(!adult.val()) {
		$('.adult').css("border", "1px solid red");
		$('.adult').focus();
		e.preventDefault();
        return false;
	}

	if(!child.val()) {
		$('.child').css("border", "1px solid red");
		$('.child').focus();
		e.preventDefault();
        return false;
	}
	if(!b_amount.val()) {
		$('.b_amount').css("border", "1px solid red");
		$('.b_amount').focus();
		e.preventDefault();
        return false;
	}*/

	if(fname.val()) {
		$('#fname').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(gender.val()) {
		$('.gender').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	/*if(relation.val()) {
		$('.relation').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}*/
	if(email.val()) {
		$('#email').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(phone.val()) {
		$('#phone').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(fkcountry.val()) {
		$('.fkcountry').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(city.val()) {
		$('#city').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(day.val()) {
		$('.day').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(month.val()) {
		$('.month').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(year.val()) {
		$('.year').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(idname.val()) {
		$('.idname').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(idno.val()) {
		$('#idno').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(purpose.val()) {
		$('#purpose').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(picture.val()) {
		$('#picture').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(address.val()) {
		$('#address').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(arrival_date.val()) {
		$('#arrival_date').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(arrlocation.val()) {
		$('#arrlocation').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(passport.val()) {
		$('#passport').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(passportexp.val()) {
		$('#passportexp').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(visa.val()) {
		$('#visa').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(visa_valid.val()) {
		$('#visa_valid').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}


	/*if(booking_via.val()) {
		$('.booking_via').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(bookingid.val()) {
		$('#bookingid').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(checkin.val()) {
		$('#checkin').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(checkout.val()) {
		$('#checkout').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(edays.val()) {
		$('#edays').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(roomno.val()) {
		$('#roomno').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(adult.val()) {
		$('.adult').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(child.val()) {
		$('.child').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(b_amount.val()) {
		$('#b_amount').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}*/

});

//next button 2
$('#next1').on('click', function(e) {
	var booking_via = $('.booking_via');
	var bookingid = $('#bookingid');
	var checkin = $('#checkin');
	var checkout = $('#checkout');
	var edays = $('#edays');
	var roomno = $('#roomno');
	var adult = $('.adult');
	//var child = $('.child');
	var b_amount = $('#b_amount');
	//var ex_ad_charges = $('#ex_ad_charges');
	//var meal_plan = $('.meal_plan');
	
  	if(!booking_via.val()) {
		$('.booking_via').css("border", "1px solid red");
		$('.booking_via').focus();
		e.preventDefault();
		return false;
	}

	if(!bookingid.val()) {
		$('#bookingid').css("border", "1px solid red");
		$('#bookingid').focus();
		e.preventDefault();
		return false;
	}

	if(!checkin.val()) {
		$('#checkin').css("border", "1px solid red");
		$('#checkin').focus();
		e.preventDefault();
      return false;
	}

	if(!checkout.val()) {
		$('#checkout').css("border", "1px solid red");
		$('#checkout').focus();
		e.preventDefault();
        return false;
	}    
	if(!edays.val()) {
		$('#edays').css("border", "1px solid red");
		$('#edays').focus();
		e.preventDefault();
        return false;
	}

	if(!roomno.val()) {
		$('#roomno').css("border", "1px solid red");
		$('#roomno').focus();
		e.preventDefault();
        return false;
	}

	if(!adult.val()) {
		$('.adult').css("border", "1px solid red");
		$('.adult').focus();
		e.preventDefault();
        return false;
	}

	/*if(!child.val()) {
		$('.child').css("border", "1px solid red");
		$('.child').focus();
		e.preventDefault();
        return false;
	}*/
	if(!b_amount.val()) {
		$('.b_amount').css("border", "1px solid red");
		$('.b_amount').focus();
		e.preventDefault();
        return false;
	}


	if(booking_via.val()) {
		$('.booking_via').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(bookingid.val()) {
		$('#bookingid').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(checkin.val()) {
		$('#checkin').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(checkout.val()) {
		$('#checkout').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(edays.val()) {
		$('#edays').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	if(roomno.val()) {
		$('#roomno').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

	if(adult.val()) {
		$('.adult').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}
	/*if(child.val()) {
		$('.child').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}*/
	if(b_amount.val()) {
		$('#b_amount').css("border", "");
		$('.next').click(function(){
			$('.next').show();
			$('form.idealforms').idealforms('nextStep');
		});
	}

});

