<?php 

include_once('../lib/fetch_values.php');

$obj = new FetchValues();

include_once ("../include/pagination_function.php");//include of paginat page

$hotel_id = $_GET['hotel_id'];
setcookie("hotel_id",$hotel_id, time() + (86400 * 30),"/");
$hotels = $obj->getHotelDetailsById($hotel_id); 

$all_hotels = $obj->getAllHotelDetails(); 



include_once ("../include/pagination_function.php");//include of paginat page

include('is_login.php');


if(!empty($_GET['re_checkin_id'])){

  $re_checkin_id = $_GET['re_checkin_id'];

  $result_recheckin = $obj->getDataForRecheckin($re_checkin_id, $hotel_id);

}



if(isset($_GET["page"]))

  $page = (int)$_GET["page"];

  else

  $page = 1;

  $setLimit = 50;

  $pageLimit = ($page * $setLimit) - $setLimit;

  $booking_list = $obj->getTotalArrivalBookingList($setLimit, $pageLimit, $hotel_id);

?>

<?php echo '

<link rel="stylesheet" href="css/pagination.css">

<div id="tablewrapper">

  <div id="tablesearch_top">

  <section>

    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">

      <thead>

         <tr>
          <th><h3>S.N.</h3></th>
          
          <th><h3>ID</h3></th>

          <th><h3>Name</h3></th>

          <th><h3>Phone</h3></th>

          <th><h3>Email</h3></th>

          <th><h3>N. Of Guest</h3></th>

          <th><h3>N. Of Room</h3></th>

          <th><h3>Country</h3></th>

          <th><h3>Room Category</h3></th>

          <th><h3>Booking Mode</h3></th>

          <th><h3>Checkin Date</h3></th>

          <th><h3>Checkout Date</h3></th>

          <th><h3>Booking Date</h3></th>

          <th><h3>&nbsp;</h3></th>

          <th><h3>&nbsp;</h3></th>

         

        </tr>

      </thead>

      <tbody>';?>

        <?php

        if(!empty($booking_list)){ 
        //for ($i=0; $i <$count ; $i++) { 
          $i = 1;
          foreach ($booking_list as $booking) { 
        ?>

        <?php echo '<tr>
          <td class="name" style="width:10px;overflow:hidden;">';?><?php echo $i++;?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:10px;overflow:hidden;" >';?><?php echo $booking['booking_id'];?><?php echo '</td>

          <td class="name"  style="width:150px;overflow:hidden;">';?><?php echo $booking['guest_name'];?><?php echo '</td>

          <td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['guest_phone'];?><?php echo '</td>

          <td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="';?><?php echo $booking['guest_email'];?><?php echo '" title="';?><?php echo $booking['guest_email'];?><?php echo '">';?><?php echo $booking['guest_email'];?><?php echo '</a></td>

          <td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['no_of_guest'];?><?php echo '</td>

          <td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['noof_room'];?><?php echo '</td>

          <td class="name" style="width:25px;overflow:hidden;">';?><?php echo $booking['country'] ;?><?php echo '</td>

          <td class="name" style="width:25px;overflow:hidden;">';?><?php echo $booking['room_category'];?><?php echo '</td>

          <td class="name"  style="width:50px;overflow:hidden;">';?><?php echo $booking['booking_mode'];?><?php echo '</td>';?>

          <?php if(isset($booking['checkin_date']) && $booking['checkin_date'] == CURR_DATE && $booking['booking_status'] != 'checkedin'){ ?>

          <?php echo '<td class="name" style="width:60px;overflow:hidden;background-color:#FF4646!important;color:#ffffff!important;">';?><?php echo $booking['checkin_date'];?><?php echo '</td>';?>

          <?php } elseif(!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin') { ?>
          <?php echo '<td class="name" style="width:60px;overflow:hidden;background-color:#499f4d!important;color:#ffffff!important;">';?><?php echo $booking['checkin_date'];?><?php echo '</td>';?>
          <?php } else { ?>

          <?php echo '<td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['checkin_date'];?><?php echo '</td>';?>

          <?php } ?>

          

          <?php echo '<td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['checkout_date'];?><?php echo '</td>

          <td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['inserted_date'];?><?php echo '</td>

          <td class="name" style="width:10px;overflow:hidden;"><a href="view_arrival_booking_list.php?arrival_b_id=';?><?php echo $booking['arrival_b_id'];?><?php echo '" class="btn">View</a></td>';?>

          <?php if(!empty($booking['booking_status']) && $booking['booking_status'] == 'confirmed' && $booking['checkin_date'] == CURR_DATE){ ?>

          <?php echo '<td class="name" style="width:20px;overflow:hidden!important;"><a style="color:#fff!important;background-color:#ECBC0D!important;width:99px;"href="#empty" data-toggle="modal_quick_checkin" class="btn"';?><?php echo $booking['arrival_b_id'];?><?php echo '>Check-In</a></td>';?>
          
          <?php } elseif(!empty($booking['booking_status']) && $booking['booking_status'] == 'confirmed'){ ?>
          
          <?php echo '<td class="name" style="width:20px;overflow:hidden!important;"><a style="color:#fff!important;background-color:#ECBC0D!important;"href="#empty" data-toggle="modal_quick_checkin" class="btn" disabled>Check-In</a></td>';?>
          <?php } elseif (!empty($booking['booking_status']) && $booking['booking_status'] == 'checkedin') { ?>

          <?php echo '<td class="name" style="width:10px;overflow:hidden!important;"><a class="btn">Checked-In</a>';?>

          <?php }elseif (!empty($booking['booking_status']) && $booking['booking_status'] == 'cancelled') { ?>
          <?php echo '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking">Cancelled</a></td>';?> 

          <?php }elseif (!empty($booking['booking_status']) && $booking['booking_status'] == 'transfered') { ?>
          <?php echo '<td class="name" style="width:10px;overflow:hidden!important;"><a class="rejected_booking" style="width:99px;">Transferred</a></td>';?> 
          <?php } ?>

        <?php echo '</tr>';?>

      <?php } } else { ?>
        <tr>
          <td colspan="16" style="color:#31708F;"><h3>No record found.</h3></td>
        </tr>
      <?php } ?>

      <?php echo '</tbody>

    </table>

  </section>

  </div>

  </div>'

  ;?>

  <?php

    // Call the Pagination Function to load Pagination.

    echo displayBookingListPagination($setLimit, $page, $hotel_id);

  ?>

<!--- Pannel Contact-->

<?php echo '<div id="modal">

	<div id="heading" class="heading-color">

		For more info send an email

	</div>

	<div id="content">

  <div class="txt-subject">

    <p style="margin-left:10px;">Subject: </p>

  </div> 

  <div class="content-subject">

    <input type="text" id="subject"/>

  </div>

  <div class="txt-email">

    <p style="margin-left:10px;">Email: </p>

  </div> 



  <div class="content-email">

    <p id="email" style=" color:#464747; font:12px;"></p>

  </div>

  <div class="txt-message"><p>Message: </p></div> 



  <div class="content-message">

    <textarea style="width:310px;background-color:#f7fbfe; margin-left:10px; height:100px;border-radius:4px;" id="message"></textarea>

  </div>

  <div class="contact-img"><img src="images/email.png" class="img-contact" alt=""/>

  </div>

  <div style="margin: 0 0 0 10px;"><a href="#" id="send" class="button blue position">Send</a>

  </div>



</div>

</div>';?>



<!-- recheckin modal-->

<?php echo '<a href="#checkin" class="overlay" id="checkin"></a>

<div class="popup1"> 

</div>';?>

<?php echo '<script type="text/javascript">

  $("a[data-toggle=modalcheckin]").click(function(){

    var arrival_b_id = $(this).attr("id");

    $.ajax({

      url : "checkin.php?arrival_b_id="+arrival_b_id,

      success:function(data){

        $(".popup1").show().html(data);

      }

    });

  });



</script>';?>



<?php echo '<script type="text/javascript">

$("#send").click(function(){

  var subject = $("#subject").val();

  var email = $(this).attr("id");

  var message = $("#message").val();

  alert(email);

  $.ajax({



    url:"insert_data.php",

    method : "POST",

    data:"subject = "+ subject + "email = " + email +"message = " + message,

    type : "sendmail",

    success:function(data){

      alert(data);

    }

  });

});

</script>';?>



<?php echo '<script type="text/javascript">

  $(document).ready(function() {

    $("#tablesearch").hide();

    $("input#name").keyup(function(){

      var query_value = $("input#name").val();

      if(query_value !== ""){

        $.ajax({

          type: "POST",

          url: "searching_arrival_booking.php",

          data: { query: query_value },

          cache: false,

          success: function(html){

            $("table#resultTable tbody").html(html);

          }

        });

      }return false;

    });



    $("input#name").on("keyup", function(e) {

     

        var search_string = $(this).val();

        if (search_string == "") {

          $("#tablesearch_top").show();

          $("#tablesearch").hide();

        }else{

          $("#tablesearch_top").hide();

          $("#tablesearch").show();

        }

    });

  });

</script>';?>



<?php echo '<script>



$(document).ready(function(){var touch=$("#touch-menu");var menu=$(".menu");$(touch).on("click",function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(":hidden")){menu.removeAttr("style");}});});



</script>';?>



<?php echo '</body>

</html>';?>