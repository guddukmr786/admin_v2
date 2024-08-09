<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

include('is_login.php');

$hotel_id = $_COOKIE['hotel_id'];
if(empty($_POST['start_date']) && empty($_POST['end_date']) && !empty($_POST['depart'])){
  $dept = $_POST['depart'];
  $day_books = $obj->getDayBookEntryByDepartment($hotel_id, $dept);
}

if(!empty($_POST['start_date']) && empty($_POST['end_date']) && empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $day_books = $obj->getDayBookEntryByStartDate($hotel_id,$start_date);
}

if(!empty($_POST['start_date']) && !empty($_POST['end_date']) && empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $day_books = $obj->getDayBookEntryByDateToDate($hotel_id,$start_date,$end_date);
}
if(!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $dept = $_POST['depart'];
  $day_books = $obj->getDayBookEntryByDepartmentAndDate($hotel_id,$start_date,$end_date, $dept);
}
if(!empty($_POST['start_date']) && empty($_POST['end_date']) && !empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $dept = $_POST['depart'];
  $day_books = $obj->getDayBookEntryByDepartmentAndStartDate($hotel_id,$start_date,$dept);
}
if(empty($_POST['start_date']) && empty($_POST['end_date']) && empty($_POST['depart'])){
  $day_books = "";
  echo 1;die;
}
if(isset($_POST['start_date'])){
  $start_date = $_POST['start_date'];
}
$opening_balance = $obj->getClosingBalanceDateWise($hotel_id, $start_date);

$receive_value = 0;
$pay_value = 0;
foreach ($day_books as $day_book) {
  if($day_book['receive_pay'] == 'Receive'){
    $receive_value += $day_book['amount'];
  }elseif ($day_book['receive_pay'] == 'Pay') {
    $pay_value += $day_book['amount'];
  }
}
//$avi_balance = $receive_value - $pay_value;
?>
<?php echo '
  <div id="tablesearch_top">';?>
    <?php echo '<section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
          <tr>
            <th><h3>S.No.</h3></th>
            <th><h3>Date</h3></th>
            <th><h3>Name</h3></th>
            <th><h3>Receive Amount</h3></th>
            <th><h3>Pay Amount</h3></th>
            <th><h3>Description</h3></th>
            <th><h3>Department</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
          </tr>
        </thead>
        <tbody>';?>
          <?php
            $i=1;
            if(!empty($day_books)){ 
            foreach ($day_books as $day_book) { 
            $inserted_date = date_format(new DateTime($day_book['date_of_expense']), 'd M Y , D');
            $rec_pay = $day_book['receive_pay'];
          ?>
          <?php echo '<tr id="'?><?php echo $day_book['day_b_id'];?><?php echo '">';?>
            <?php echo '<td class="name" >';?><?php echo $i++;?><?php echo '</td>
            <td class="name">';?><?php echo $inserted_date;?><?php echo '</td>
            <td class="name">';?><?php echo $day_book['expense_by'];?><?php echo '</td>
            <td class="name">';?><?php if($rec_pay == 'Receive') echo $day_book['amount'];?><?php echo '</td>
            <td class="name">';?><?php if($rec_pay == 'Pay') echo $day_book['amount'];?><?php echo '</td>
            <td class="name">';?><?php echo $day_book['description'];?><?php echo '</td>
            <td class="name">';?><?php echo $day_book['department'];?><?php echo '</td>';?>
            <?php if($day_book['expense_type'] == 'Cash balance') { ?>
            <?php echo '<td class="name" style="width:80px;"><a disabled href="#edit_day_book" data-toggle="modaldaybook"  id="';?><?php echo $day_book['day_b_id'];?><?php echo '" class="btn">Edit</a></td>';?>
            <?php } else { ?>
            <?php echo '<td class="name" style="width:80px;"><a href="#edit_day_book" data-toggle="modaldaybook"  id="';?><?php echo $day_book['day_b_id'];?><?php echo '" class="btn">Edit</a></td>';?>
            <?php } ?>
            <?php echo '<td class="name" style="width:80px;"><a href="#" class="delete" title="';?><?php echo $day_book['day_b_id'];?><?php echo '" id="btn_r1">Delete</a></td></tr>';?>
          <?php }
          $current_balance = $receive_value - $pay_value;
          echo '<tr>
            <td colspan="5" style="text-align:right;padding-right:70px;font-size:16px;">Total : '.$receive_value.'</td>
            <td  style="font-size:16px;">Total : '.$pay_value.'</td>
            <td colspan="5" style="text-align:left;padding-left:70px;font-size:14px;"> Currnet Balance : <span style="font-size:16px;">'.$current_balance.'</span>Rs.</td>
          </tr>';
          echo '<tr>';
            if($current_balance <= 0) { 
            echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;"><span style="color:red;">Closing Balance '.$current_balance.' Rs</span></td>';
            } else {
            echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;color:#30C8FF;">Closing Balance  : ' . $current_balance . ' Rs</td>';
            }
          echo '</tr>';
        } else { ?>
        <?php echo '<tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>';?>
        <?php } ?>
        <?php echo '</tbody>
      </table>
    </section>';?>
  <?php echo '
  </div>
</div>';?>
<?php 
  echo '
  <script type="text/javascript">

    $(".delete").click(function(){
      var id = $(this).attr("title");
      if(confirm("Are you sure you want to delete this?")){
        $.ajax({
          url : "delete.php?type=delete_daybook&id="+id,
          type : "POST",
          success:function(res){
            if(res == 0){
              $("#error").hide();
              $("tr#"+id).css("background-color","#ccc");
              $("tr#"+id).fadeOut("slow");
            }else{
              $("#error").show().html("<div class=alert alert-danger>Error! Please try again later.</div>");
            }
          }
        });
      }else{
        return false;
      }
    });


    $("a[data-toggle=modaldaybook]").click(function(){
    var d_book_id = $(this).attr("id");
      $.ajax({
        url : "edit_day_book.php?d_book_id="+d_book_id,
        success:function(data){
          $(".popup1").show().html(data);
        }
      });
    });
  </script>';
?>