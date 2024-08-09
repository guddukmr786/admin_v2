<?php 
include_once('../include/header.php');

include_once ("../include/pagination_function.php");//include of paginat page
$pg_obj = new PaginationFunction();
include('is_login.php');
if(!empty($_GET['re_checkin_id'])){

  $re_checkin_id = $_GET['re_checkin_id'];

  $result_recheckin = $obj->getDataForRecheckin($re_checkin_id);
}

if(isset($_GET["page"]))

  $page = (int)$_GET["page"];

  else

  $page = 1;

  $setLimit = 40;

  $pageLimit = ($page * $setLimit) - $setLimit;

  $entry_list = $obj->getTotalEntryList($setLimit, $pageLimit, $hotel_id);
?>
<style type="text/css">
  .btn-default:hover{
    background-color: #499f4d!important;
  }

</style>
<link rel="stylesheet" href="css/pagination.css">
<div id="tablewrapper">
  <div id="tableheader">
    <form class="form-horizontal" name="search" role="form" method="POST" onkeypress="return event.keyCode != 13;">
      <div class="search">
        <input id="name" name="name" type="text" placeholder="Search by booking id/name/email/phone" autocomplete="off"/>
        <button type="button" id="search_gks" class="btn btn-default" style="padding-top: 10px;padding-bottom: 11px;border: #499f4d 1px solid;border-radius: 0px;">
          <span class="glyphicon glyphicon-search"></span> Search
        </button>
        <img class="modallodar1" style="display: none" alt="" src="images/ajax-loader-search.gif" />
      </div>
    </form>
</div>
<div id="show_data"></div>

<div class="modallodar" style="display: none">
  <div class="center">
    <img alt="" src="ajax-loader1.gif" />
  </div>
</div>

<div id="tablesearch_top">
  <!-- This code for recheckin-->
  <?php if(!empty($result_recheckin)){ ?>
  <section>
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
      <tbody>
        <?php
          $i=1;
          //foreach ($result_recheckin as $list) { 
          $date1 = CURR_DATE;
          $date2 = $result_recheckin['date_of_birth'];
          $date_diff = abs(strtotime($date1) - strtotime($date2));
          $age = floor($date_diff/(360*60*60*24));
        ?>
        <tr>
          <td style="width:10px!important;"><?php echo $i++;?></td>
          <td class="name" style="width:10px;overflow:hidden;" ><?php echo $result_recheckin['booking_id'];?></td>
          <td class="name"  style="width:150px;overflow:hidden;"><?php echo $result_recheckin['name'];?></td>
          <td class="name" style="width:100px;overflow:hidden;"><?php echo $result_recheckin['phone'];?></td>
          <td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $result_recheckin['email'];?>" title="<?php echo $result_recheckin['email'];?>"><?php echo $result_recheckin['email'];?></a></td>
          <td class="name" style="width:25px;overflow:hidden;"><?php echo $result_recheckin['room_number'] ;?></td>
          <td class="name" style="width:25px;overflow:hidden;"><?php echo $result_recheckin['booking_amount'];?></td>
          <td class="name"  style="width:50px;overflow:hidden;"><?php echo $result_recheckin['country'];?></td>
          <td class="name" style="width:100px;overflow:hidden;"><?php echo $result_recheckin['compnay_name'];?></td>
          <td class="name" style="width:40px;"><a href="view.php?checkin_id=<?php echo $result_recheckin['checkin_id'];?>" class="btn">View</a></td>
          <?php if(isset($result_recheckin['final_checkout_date']) && $result_recheckin['final_checkout_date']!= '0000-00-00 00:00:00' || $result_recheckin['status'] == 1){ ?>
          <td class="name" style="width:80px;"><a href="#recheckin" data-toggle="modalrecheckin"  id="<?php echo $result_recheckin['checkin_id'];?>" class="btn">Re-Checkin</a></td>
          <?php } else { ?>
          <td class="name" style="width:80px;"><a href="bill.php?checkin_id=<?php echo $result_recheckin['checkin_id'];?>" class="btn_r">Checkout</a></td>
          <?php } ?>
          <td class="name" style="width:95px;"><a href="add_summary.php?checkin_id=<?php echo $result_recheckin['checkin_id'];?>" class="btn">Add Summary</a></td>
        </tr>
      <?php //} ?>
      </tbody>
    </table>
  </section>
  <!-- end of recheckin code-->
  <?php } else { ?>
  <section>
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
      <tbody>
        <?php
          $i=1;
          foreach ($entry_list as $list) { 
          $date1 = CURR_DATE;
          $date2 = $list['date_of_birth'];
          $date_diff = abs(strtotime($date1) - strtotime($date2));
          $age = floor($date_diff/(360*60*60*24));
        ?>
        <tr>
          <td style="width:10px!important;"><?php echo $i++;?></td>
          <td style="width:10px;overflow:hidden;" ><?php echo $list['booking_id'];?></td>
          <?php if(isset($list['checkout_date']) && $list['checkout_date'] == CURR_DATE){ ?>
          <td style="width:150px;overflow:hidden;"><?php echo $list['name'];?></td>
          <?php } else { ?>
          <td style="width:150px;overflow:hidden;"><?php echo $list['name'];?></td>
          <?php } ?>
          <td style="width:100px;overflow:hidden;"><?php echo $list['phone'];?></td>
          <td style="width:100px;overflow:hidden;"><a href="#" class="button-email" id="<?php echo $list['email'];?>" title="<?php echo $list['email'];?>"><?php echo $list['email'];?></a></td>
          <td style="width:25px;overflow:hidden;"><?php echo $list['room_number'] ;?></td>
          <td style="width:25px;overflow:hidden;"><?php echo $list['booking_amount'];?></td>
          <td style="width:50px;overflow:hidden;"><?php echo $list['country'];?></td>
          <td style="width:100px;overflow:hidden;"><?php echo $list['compnay_name'];?></td>
          <td style="width:40px;"><a href="view.php?checkin_id=<?php echo $list['checkin_id'];?>" class="btn">View</a></td>
          <?php if(isset($list['final_checkout_date']) && $list['final_checkout_date']!= '0000-00-00 00:00:00' && $list['status'] == 1){ ?>
          <td style="width:80px;"><a href="#recheckin" data-toggle="modalrecheckin"  id="<?php echo $list['checkin_id'];?>" class="btn">Re-Checkin</a></td>
          <?php } else { ?>
          <td style="width:80px;"><a href="bill.php?checkin_id=<?php echo $list['checkin_id'];?>" class="btn_r">Checkout</a></td>
          <?php } ?>
          <td style="width:95px;"><a href="add_summary.php?checkin_id=<?php echo $list['checkin_id'];?>" class="btn">Add Summary</a></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </section>
  <?php
  }
    echo $pg_obj->displayPaginationBelow($setLimit, $page, $hotel_id);
    //echo "text";
    //echo $displayPaginationBelow;
    //print_r($displayPaginationBelow);die;
    
  ?>
</div>
  <div id="tablesearch">
    <section>
      <table cellpadding="0" cellspacing="0" border="0" id="resultTable" class="tinytable">
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
            <th><h3>Hotel Name</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </div>
</div>
<!--- Pannel Contact-->
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
</div>

<!-- recheckin modal-->
<a href="#recheckin" class="overlay" id="recheckin"></a>
<div class="popup1"> 
</div>
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


  $(".hotel").change(function(event){
    event.preventDefault();
    var hotel_id = $(this).attr("value");
    $.ajax({
      url : "hotel_based_entry_list.php?type=Save_hotel_id_in_session&hotel_id="+hotel_id,
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
         $(".modallodar").show();
      },
      success:function(data){
        $(".modallodar").hide();
        $("#tablesearch_top").hide();
        $("#tablesearch").hide();
        $("#show_data").show().html(data);
      }
    });
  });

</script>

<script type="text/javascript">
  $('a[data-toggle="modalrecheckin"]').click(function(){
  var checkin_id = $(this).attr('id');
    $.ajax({
      url : 'recheckin.php?checkin_id='+checkin_id,
      success:function(data){
        $(".popup1").show().html(data);
      }
    });
  });

</script>
<script type="text/javascript">
$(document).ready(function () {
  $('.button-email').click(function (e) { // Button which will activate our modal
    var title = $(this).attr('title');
    var title2 = $('.name').attr('title');
    document.getElementById("email").innerHTML = title.toString();
      $('#modal').reveal({ // The item which will be opened with reveal
          animation: 'fade',                   // fade, fadeAndPop, none
          animationspeed: 600,                       // how fast animtions are
          closeonbackgroundclick: true,              // if you click background will modal close?
          dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
        });
      return false;
    });
});
</script> 

<script type="text/javascript">
$("#send").click(function(){
  var subject = $("#subject").val();
  var email = $(this).attr('id');
  var message = $("#message").val();
  alert(email);
  $.ajax({

    url:'insert_data.php',
    method : 'POST',
    data:'subject = '+ subject + 'email = ' + email + 'message = ' + message,
    type : 'sendmail',
    success:function(data){
      alert(data);
    }
  });
});
</script>
<script type="text/javascript">
  $(window).load(function(){
    $('.article-preview h1 a').hover(function(){
      $(this).animate({
          color: '#ffffff',
      }, 1500);
    });
  });
</script>

<!--End Script Open Pannel-->


<!-- searching script here-->
<script type="text/javascript" src="js/triggers.js"></script>
<!--searching script end here-->
<script>

$(document).ready(function(){var touch=$('#touch-menu');var menu=$('.menu');$(touch).on('click',function(e){e.preventDefault();menu.slideToggle();});$(window).resize(function(){var w=$(window).width();if(w>767&&menu.is(':hidden')){menu.removeAttr('style');}});});

</script>

</body>

</html>