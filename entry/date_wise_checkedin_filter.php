<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

$hotel_id = $_COOKIE['hotel_id'];

if(isset($_POST['start_date'])){
  $start_date = str_replace('/','-',$_POST['start_date']);
  $date1 = date('Y-m-d',strtotime($start_date));

}
if(isset($_POST['end_date'])){
  $end_date = str_replace('/','-',$_POST['end_date']);
  $date2 = date('Y-m-d',strtotime($end_date));
}

$dt_wi_details = $obj->getDateWiseCheckedinDetailsFilter($hotel_id,$date1,$date2);

?>
<?php echo '<div id="tablesearch_top">
<section>
  <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
    <thead>
       <tr>
        <th><h5>S. N.</h5></th>
        <th><h5>Booking Id.</h5></th>
        <th><h5>Name</h5></th>
        <th><h5>Phone</h5></th>
        <th><h5>Email</h5></th>
        <th><h5>Room</h5></th>
        <th><h5>Country</h5></th>
        <th><h5>Amount</h5></th>
        <th><h5>Checkin</h5></th>
        <th><h5>Checkout</h5></th>
        <th><h5>Check In By</h5></th>
        <th><h5>&nbsp;</h5></th>
        
      </tr>
    </thead>
    <tbody>';?>
      <?php
      
      if(!empty($dt_wi_details)){ 
        
        $i=1;
          foreach ($dt_wi_details as $booking) { 
        ?>
        <?php echo '<tr>';?>
          <?php echo '<td class="name" style="width:30px;overflow:hidden;">';?><?php echo $i++;?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:10px;overflow:hidden;" >';?><?php echo $booking['booking_id'];?><?php echo '</td>';?>
          <?php echo '<td class="name"  style="width:150px;overflow:hidden;">';?><?php echo $booking['name'];?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:100px;overflow:hidden;">';?><?php echo $booking['phone'];?><?php  echo '</td>';?>
          <?php echo '<td class="name" style="width:200px;overflow:hidden;"><a href="#" class="button-email" id="';?><?php echo $booking['guest_email'];?>" title="<?php echo $booking['email'];?>"><?php echo $booking['email'];?><?php echo '</a></td>';?>
          <?php echo '<td class="name" style="width:20px;overflow:hidden;">';?><?php echo $booking['room_number'];?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:20px;overflow:hidden;">';?><?php echo $booking['country'];?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:20px;overflow:hidden;">';?><?php echo $booking['booking_amount'];?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:25px;overflow:hidden;">';?><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$booking['checkin_date']))) ;?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:85px;overflow:hidden;">';?><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$booking['checkout_date']))) ;?><?php echo '</td>';?>
          <?php echo '<td class="name"  style="width:80px;overflow:hidden;">';?><?php echo $booking['inserted_by'];?><?php echo '</td>';?>
          <?php echo '<td class="name" style="width:10px;overflow:hidden;"><a href="view_date_wise_checkin_details.php?checkin_id=';?><?php echo $booking['checkin_history_id'];?><?php echo '" class="btn">View</a></td>';?>
        <?php echo '</tr>';?>
      <?php } } else { ?>
        <?php echo '<tr>';?>
          <?php echo '<td colspan="13" style="color:#31708F;"><h3>No record found.</h3></td>';?>
        <?php echo '</tr>';?>
      <?php } ?>
    <?php echo '</tbody>';?>
  <?php echo '</table>';?>
<?php echo '</section>';?>

<?php echo '</div>';?>



<?php /*echo '
  <div id="tablesearch_top">';?>
    <?php echo '<section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
          <tr>
            <th><h5>S. N.</h5></th>
            <th><h5>B.Id.</h5></th>
            <th><h5>Name</h5></th>
            <th><h5>Phone</h5></th>
            <th><h5>Email</h5></th>
            <th><h5>Room</h5></th>
            <th><h5>Country</h5></th>
            <th><h5>Amount</h5></th>
            <th><h5>Checkin</h5></th>
            <th><h5>Checkout</h5></th>
            <th><h5>Check In By</h5></th>
            <th><h5>&nbsp;</h5></th>
          </tr>
        </thead>
        <tbody>';?>
          <?php
            $i=1;
            if(!empty($emp_details)){ 
            foreach ($emp_details as $emp_detail) { 
            $inserted_date = date_format(new DateTime($emp_detail['date_of_join']), 'd M Y , D');
            $employee_id = $emp_detail['employee_id'];
            $id_proof = $obj->getEmployeesIds($employee_id, $hotel_id);

          ?>
            <?php echo '<td class="name" >';?><?php echo $i++;?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['booking_id'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['name'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['phone'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['email'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['room_number'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['country'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['booking_amount'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-',$emp_detail['checkin_date'])));?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo date('d-M-Y, D',strtotime(str_replace('/', '-', $emp_detail['checkout_date'])));?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['inserted_by'];?><?php echo '</td>';?>

        <?php } else { ?>
        <?php echo '<tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>';?>
        <?php } ?>
        <?php echo '</tbody>
      </table>
    </section>';?>
  <?php echo '
  </div>
</div>';*/

?>
