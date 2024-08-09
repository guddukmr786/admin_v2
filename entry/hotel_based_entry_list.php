<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
include_once ("../include/pagination_function.php");//include of paginat page
$hotel_id  = $_GET['hotel_id'];
setcookie("hotel_id",$hotel_id, time() + (86400 * 30),"/");
$hotels = $obj->getHotelDetailsById($hotel_id); 
$all_hotels = $obj->getAllHotelDetails(); 

include('is_login.php');
if(!empty($_GET['re_checkin_id'])){
  $re_checkin_id = $_GET['re_checkin_id'];
  $result_recheckin = $obj->getDataForRecheckin($re_checkin_id, $hotel_id);
}
if(isset($_GET["page"]))
  $page = (int)$_GET["page"];
  else
  $page = 1;
  $setLimit = 100;
  $pageLimit = ($page * $setLimit) - $setLimit;
  $entry_list = $obj->getTotalEntryList($setLimit, $pageLimit, $hotel_id);
?>
<?php echo '
  <div id="tablesearch_top">';?>
    <?php if(!empty($result_recheckin)){ ?>
    <?php } else { ?>
    <?php echo '<section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
          <tr>
            <th><h3>S.N.</h3></th>
            <th><h3>ID</h3></th>
            <th><h3>Name</h3></th>
            <th><h3>Phone</h3></th>
            <th><h3>Email</h3></th>
            <th><h3>Room No.</h3></th>
            <th><h3>Amount</h3></th>
            <th><h3>Country</h3></th>
            <th><h3>Booking Via</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
          </tr>
        </thead>
        <tbody>';?>
          <?php
            $i = 1;
            foreach ($entry_list as $list) { 
            $date1 = CURR_DATE;
            $date2 = $list['date_of_birth'];
            $date_diff = abs(strtotime($date1) - strtotime($date2));
            $age = floor($date_diff/(360*60*60*24));
          ?>
          <?php echo '<tr>
            <td class="name" style="width:10px;overflow:hidden;">';?><?php echo $i++;?><?php echo '</td>';?>
            <?php echo '<td class="name" style="width:10px;overflow:hidden;" >';?><?php echo $list['booking_id'];?><?php echo '</td>';?>
            <?php if(isset($list['checkout_date']) && $list['checkout_date'] == CURR_DATE){ ?>
            <?php echo '<td class="name"  style="width:150px;overflow:hidden;">';?><?php echo $list['name'];?><?php echo '</td>';?>
            <?php } else { ?>
            <?php echo '<td class="name"  style="width:150px;overflow:hidden;">';?><?php echo $list['name'];?><?php echo '</td>';?>
            <?php } ?>
            <?php echo '<td class="name" style="width:100px;overflow:hidden;">';?><?php echo $list['phone'];?><?php echo '</td>
            <td class="name" style="width:100px;overflow:hidden;"><a href="#" class="button-email" id="';?><?php echo $list['email'];?><?php echo '" title="';?><?php echo $list['email'];?><?php echo '">';?><?php echo $list['email'];?><?php echo '</a></td>
            <td class="name" style="width:25px;overflow:hidden;">';?><?php echo $list['room_number'] ;?><?php echo '</td>
            <td class="name" style="width:25px;overflow:hidden;">';?><?php echo $list['booking_amount'];?><?php echo '</td>
            <td class="name"  style="width:50px;overflow:hidden;">';?><?php echo $list['country'];?><?php echo '</td>
            <td class="name" style="width:100px;overflow:hidden;">';?><?php echo $list['booking_via'];?><?php echo '</td>
            <td class="name" style="width:40px;"><a href="view.php?checkin_id=';?><?php echo $list['checkin_id'];?><?php echo '" class="btn">View</a></td>';?>
            <?php if(isset($list['final_checkout_date']) && $list['final_checkout_date']!= '0000-00-00 00:00:00' && $list['status'] == 1){ ?>
            <?php echo '<td class="name" style="width:80px;"><a href="#recheckin" data-toggle="modalrecheckin"  id="';?><?php echo $list['checkin_id'];?><?php echo '" class="btn">Re-Checkin</a></td>';?>
            <?php } else { ?>
            <?php echo '<td class="name" style="width:80px;"><a href="bill.php?checkin_id=';?><?php echo $list['checkin_id'];?><?php echo '" class="btn_r">Checkout</a></td>';?>
            <?php } ?>
            <?php echo '<td class="name" style="width:95px;"><a href="add_summary.php?checkin_id=';?><?php echo $list['checkin_id'];?><?php echo '" class="btn">Add Summary</a></td>
          </tr>';?>
        <?php } ?>
        <?php echo '</tbody>
      </table>
    </section>';?>
    <?php
    }
      // Call the Pagination Function to load Pagination.
      echo displayPaginationBelow($setLimit, $page, $hotel_id);
      ?>
  <?php echo '
  </div>
</div>';?>
<!--- Pannel Contact-->
<?php echo '
<div id="modal">
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
<?php echo '<a href="#recheckin" class="overlay" id="recheckin"></a>
<div class="popup1"> 
</div>';?>

<?php echo '<script type="text/javascript">
  $("a[data-toggle=modalrecheckin]").click(function(){
  var checkin_id = $(this).attr("id");
    $.ajax({
      url : "recheckin.php?checkin_id="+checkin_id,
      success:function(data){
        $(".popup1").show().html(data);
      }
    });
  });

</script>';?>
