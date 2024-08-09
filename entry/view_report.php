<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

include_once ("../include/pagination_function.php");//include of paginat page

include('is_login.php');

if($_POST['hotel'] && $_POST['category'] && $_POST['start_date'] && $_POST['end_date']){
  $hotel_id = $_POST['hotel'];
  $category = $_POST['category'];
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  if(isset($_POST['company'])){
    $company = $_POST['company'] ;
  } else {
    $company = "";
  }
  if($category == 'Email'){
    $guest_details = $obj->downloadDateWiseGuestEmail($hotel_id, $date1, $date2, $company);
  }
  if($category == 'Phone'){
    $guest_details = $obj->downloadDateWiseGuestPhone($hotel_id, $date1, $date2, $company);
  }
  if($category == 'All Detials'){
    $guest_details = $obj->downloadTotalGuestDetailsDateWise($hotel_id, $date1, $date2, $company);
  }
  //$entry_list = $obj->getTotalEntryList($hotel_id);
  ?>

  <link rel="stylesheet" href="css/pagination.css">
  <div id="tablewrapper">
    <div id="tableheader">
      <?php if($category == 'All Detials'){ ?>
      <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
        <div class="search">
          <input id="name" name="name" type="text" placeholder="Search by /name/phone/email" autocomplete="off"/>
          <button id="search_gks" type="button" class="btn btn-default" style="padding-top: 10px;padding-bottom: 10px;border: #499f4d 1px solid;background-color:#499f4d!important;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
          </button>
          <img class="modallodar2" style="display: none" alt="" src="images/ajax-loader-search.gif" />
        </div>
      </form>
      <?php } ?>
  </div>
  <div id="show_data"></div>
  <div id="tablesearch_top">
    <?php if ( $category == 'All Detials' ) { ?>
      <section>
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
          <thead>
            <tr>
              <th class="sort"><h3>ID</h3></th>
              <th><h3>Name</h3></th>
              <th><h3>Phone</h3></th>
              <th><h3>Email</h3></th>
              <th><h3>Room No.</h3></th>
              <th><h3>Nights</h3></th>
              <th><h3>Amount</h3></th>
              <th><h3>Country</h3></th>
              <th><h3>Booking Via</h3></th>
              <th><h3>Checkin Date</h3></th>
              <th><h3>Checkout Date</h3></th>
              <th><h3>&nbsp;</h3></th>
            </tr>
          </thead>
          <tbody>
            <?php
              //$i=1;
              $Total = count($guest_details);
              foreach ($guest_details as $list) { 

              $checkin_id = $list['checkin_id'];
              $ext_amount = $obj->getExtendedBookingAmountByCheckinID($checkin_id);
             
              $date1 = CURR_DATE;
              $date2 = $list['date_of_birth'];
              $date_diff = abs(strtotime($date1) - strtotime($date2));
              $age = floor($date_diff/(360*60*60*24));

              $no_of_night = $list['booking_nights'] + $list['extended_days'];

              if(!empty($ext_amount['sum_ext_amount'])){
                $amout_ext = $list['booking_amount'] + $ext_amount['sum_ext_amount'];
              }else{
                $amout_ext = $list['booking_amount'];
              }
              
              $nights = 0;
              $amount = 0;
              $nights += $no_of_night;
              $amount += $amout_ext; 

            ?>
            <tr>
              <!--<td class="name">CIR <?php //if($i < 10) echo '0'.$i++; else echo $i;?></td>-->
              <td style="width:10px;overflow:hidden;" ><?php echo $list['booking_id'];?></td>
              <?php if(isset($list['checkout_date']) && $list['checkout_date'] == CURR_DATE){ ?>
              <td style="width:150px;overflow:hidden;"><?php echo $list['name'];?></td>
              <?php } else { ?>
              <td style="width:150px;overflow:hidden;"><?php echo $list['name'];?></td>
              <?php } ?>
              
              <td style="width:100px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $list['email'];?>" title="<?php echo $list['email'];?>"><?php echo $list['email'];?></a></td>
              <td style="width:100px;overflow:hidden;"><?php echo $list['phone'];?></td>
              <td style="width:25px;overflow:hidden;"><?php echo $list['room_number'] ;?></td>
              <td style="width:25px;overflow:hidden;"><?php echo $no_of_night ;?></td>
              <td style="width:25px;overflow:hidden;"><?php echo $amout_ext;?></td>
              <td style="width:50px;overflow:hidden;"><?php echo $list['country'];?></td>
              <td style="width:100px;overflow:hidden;"><?php echo $list['compnay_name'];?></td>
              <td style="width:50px;overflow:hidden;"><?php echo $list['current_ci_date'];?></td>
              <td style="width:100px;overflow:hidden;"><?php echo $list['final_checkout_date'];?></td>
              <td style="width:40px;"><a target="_blank" href="view.php?checkin_id=<?php echo $list['checkin_id'];?>" class="btn">View</a></td>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="3" style="color:#499F4D;font-size: 15px;"><p>Total Number of records found : <strong><?php echo $Total;?></p></strong></td>
            <td colspan="3" style="color:#499F4D;font-size: 15px;"><p>Total Nights : <strong><?php echo $nights;?></p></strong></td>
            <td colspan="6" style="color:#499F4D;font-size: 15px;"><p>Total Amount : <strong><?php echo $amount;?></p></strong></td>
          </tr>
          </tbody>

        </table>
        
      </section>
    <?php } elseif ( $category == 'Email' ) { ?>
      <section>
        <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
          <thead>
            <tr>
              <th><h3>Email</h3></th>
            </tr>
          </thead>
           <tbody>
            <tr>
              <td >
                <p style="font-size : 15px;">
                <?php
                  $count_email = count($guest_details);
                  foreach ($guest_details as $list) { 

                    echo '<span style="background-color:#EAECEE;color:#000000;">'.$list['email'].'</span>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' ; 
                  } 
                ?>
                </p>
              </td>
              <!--<td style="width:40px;"><a target="_blank" href="view.php?checkin_id=<?php //echo $list['checkin_id'];?>" class="btn">View</a></td>-->
            </tr>
          </tbody>
        </table>
        <p><strong>Total number of records found - </strong><?php echo $count_email;?></p>
      </section>
    <?php } elseif ( $category == 'Phone' ) { ?>
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
          <tr>
            <th><h3>Phone</h3></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p style="font-size : 15px;">
              <?php
                $count_phone = count($guest_details);
                foreach ($guest_details as $list) {
                  echo $list['phone'].", ";
                } 
              ?>
              </p>
            </td>
          </tr>
        </tbody>
      </table>
      <p><strong>Total number of records found - </strong><?php echo $count_phone;?></p>
    </section>
    <?php } ?>
  </div>
    <div id="tablesearch">
      <section>
        <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
          <thead>
            <tr>
              <th class="sort"><h3>ID</h3></th>
              <th><h3>Name</h3></th>
              <th><h3>Phone</h3></th>
              <th><h3>Email</h3></th>
              <th><h3>Room No.</h3></th>
              <th><h3>Nights</h3></th>
              <th><h3>Amount</h3></th>
              <th><h3>Country</h3></th>
              <th><h3>Booking Via</h3></th>
              <th><h3>Checkin Date</h3></th>
              <th><h3>Checkout Date</h3></th>
              <th><h3>&nbsp;</h3></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </section>
    </div>
  </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <!-- recheckin modal-->
  <?php include_once('../include/footer.php');?>
  <script type="text/javascript">
    /*$(".hotel").change(function(){
      var hotel_id = $(this).attr("value");
      $.ajax({
        url : "hotel_based_entry_list.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
        success:function(data){
          $("#tablesearch_top").hide();
          $("#tablesearch").hide();
          $("#show_data").show().html(data);
        }
      });
    });*/
  </script>
  <!--End Script Open Pannel-->
  <!--script for this page-->
  <script type="text/javascript" src="js/triggers_report.js"></script>
  <script>
  $(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});
  </script>
<?php } ?>
</body>

</html>