<script src="../entry/js/jquery.min.js"></script>
<script src="../entry/js/jquery-ui.min.js" defer></script>
<script src="../entry/js/jquery.idealforms.js" defer></script>
<script src="../entry/js/jquery.session.js" defer></script>
<script src="js/quantity-bt.js" defer></script>
<script src="js/bootstrap-datepicker.js" defer></script>
<script type="text/javascript" src="js/save_entry_fromdata.js" defer></script>
<!--<script src="js/out/jquery.idealforms.min.js"></script>-->
<script type="text/javascript">
	$(document).ready(function() {
		$('.button-email').click(function(e) { // Button which will activate our modal

			var title = $(this).attr('title');
			var title2 = $('.name').attr('title');
			document.getElementById("email").innerHTML = title.toString();
			$('#modal').reveal({ // The item which will be opened with reveal
				animation: 'fade', // fade, fadeAndPop, none
				animationspeed: 600, // how fast animtions are
				closeonbackgroundclick: true, // if you click background will modal close?
				dismissmodalclass: 'close' // the class of a button or element that will close an open modal
			});
			return false;
		});
	});
</script>