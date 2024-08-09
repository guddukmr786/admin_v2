<?php 

echo '<div class="field"> 
		<label class="main">Fligt Details : </label>';?>
			<?php if(isset($_SESSION['flight'])){ ?>
			<?php echo '<textarea id="flight" name="flight" type="text" placeholder="Flight Details" >';?><?php echo $_SESSION["flight"];?><?php echo '</textarea>';?>
			<?php }else{ ?>
			<?php echo '<textarea id="flight" name="flight"  type="text" placeholder="Flight Details" ></textarea>';?>
			<?php } ?>
	<?php echo '</div>';?>

<?php echo '<script>
		$(document).ready(function(){ 
			$("#flight").click(function(){
				$("#flight").css("border", " ");
			})
		});
		$("#preview").on("click", function(e) {
			var flight = $("#flight");
			if(!flight.val()) {
				$("#flight").css("border", "1px solid red");
				$("#flight").focus();
				e.preventDefault();
			}
			if(flight.val()) {
				$("#flight").css("border", "");
			}
	});
	</script>';
?>