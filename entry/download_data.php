<?php

include_once('../lib/fetch_values.php');

$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
if(isset($_GET['type']) && $_GET['type'] == 'all'){
  $guest_details = $obj->downloadTotalGuestDetails($hotel_id);
  header("Content-type: application/vnd.ms-excel");
  $fileName = "cir_guest_details";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Guest Name</th>
      <th>Gender</th>
      <th>S/O,D/O,W/O</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>State</th>
      <th>Pincode</th>
      <th>D.O.B</th>
      <th>Id Name</th>
      <th>Id Number</th>
      <th>Last Location</th>
      <th>Next Location</th>
      <th>Purpouse</th>
      <th>Address</th>
      <th>Arrival Date</th>
      <th>Arrival Location</th>
      <th>Passport No.</th>
      <th>Passport exp.</th>
      <th>Visa No.</th>
      <th>Visa exp.</th>
      <th>Booking via</th>
      <th>Booking Id</th>
      <th>Chcecin Date</th>
      <th>Checkout Date</th>
      <th>Final Checkout Date</th>
      <th>Booking Night</th>
      <th>Room No.</th>
      <th>No. of Person</th>
      <th>Booking Amount</th>
      <th>Extra Charge per Adult</th>
      <th>Meal Plan</th>
      <th>Status</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        if($guest_detail['status'] == 0){
          $status = 'checkin';
        }else{
          $status = 'checkedout';
        }
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['name'].'</td>
          <td>'.$guest_detail['gender'].'</td>
          <td>'.$guest_detail['son_of'].'</td>
          <td>'.$guest_detail['email'].'</td>
          <td>'.$guest_detail['phone'].'</td>
          <td>'.$guest_detail['country'].'</td>
          <td>'.$guest_detail['state'].'</td>
          <td>'.$guest_detail['pincode'].'</td>
          <td>'.$guest_detail['date_of_birth'].'</td>
          <td>'.$guest_detail['id_name'].'</td>
          <td>'.$guest_detail['id_number'].'</td>
          <td>'.$guest_detail['last_location'].'</td>
          <td>'.$guest_detail['next_location'].'</td>
          <td>'.$guest_detail['purpouse'].'</td>
          <td>'.$guest_detail['address'].'</td>
          <td>'.$guest_detail['arrival_date'].'</td>
          <td>'.$guest_detail['arrival_location'].'</td>
          <td>'.$guest_detail['passport_number'].'</td>
          <td>'.$guest_detail['pass_expiry_date'].'</td>
          <td>'.$guest_detail['visa_number'].'</td>
          <td>'.$guest_detail['visa_expiry_date'].'</td>
          <td>'.$guest_detail['compnay_name'].'</td>
          <td>'.$guest_detail['booking_id'].'</td>
          <td>'.$guest_detail['checkin_date'].'</td>
          <td>'.$guest_detail['checkout_date'].'</td>
          <td>'.$guest_detail['final_checkout_date'].'</td>
          <td>'.$guest_detail['booking_nights'].'</td>
          <td>'.$guest_detail['room_number'].'</td>
          <td>'.$guest_detail['no_of_person'].'</td>
          <td>'.$guest_detail['booking_amount'].'</td>
          <td>'.$guest_detail['charge_per_adult'].'</td>
          <td>'.$guest_detail['meal_plan'].'</td>
          <td>'.$status.'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if (isset($_GET['type']) && $_GET['type'] == 'allbooking') {
  $guest_details = $obj->downloadTotalGuestBookingDetails($hotel_id);
  header("Content-type: application/vnd.ms-excel");
  $fileName = "cir_guest_details";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Guest Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>Room Category</th>
      <th>Booking Mode</th>
      <th>Pickup</th>
      <th>Flight Details</th>
      <th>Booking via</th>
      <th>Booking Id</th>
      <th>Chcecin Date</th>
      <th>Checkout Date</th>
      <th>Booking Night</th>
      <th>No. of Person</th>
      <th>Status</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        $date1=str_replace('/', '-', $guest_detail['checkin_date']);
        $date2=str_replace('/', '-', $guest_detail['checkout_date']);
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['guest_name'].'</td>
          <td>'.$guest_detail['guest_email'].'</td>
          <td>'.$guest_detail['guest_phone'].'</td>
          <td>'.$guest_detail['country'].'</td>
          <td>'.$guest_detail['room_category'].'</td>
          <td>'.$guest_detail['booking_mode'].'</td>
          <td>'.$guest_detail['pickup'].'</td>
          <td>'.$guest_detail['flight_details'].'</td>
          <td>'.$guest_detail['booking_via'].'</td>
          <td>'.$guest_detail['booking_id'].'</td>
          <td>'.$guest_detail['checkin_date'].'</td>
          <td>'.$guest_detail['checkout_date'].'</td>
          <td>'.$days.'</td>
          <td>'.$guest_detail['no_of_guest'].'</td>
          <td>'.$guest_detail['booking_status'].'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if (isset($_GET['type']) && $_GET['type'] == 'booking') {
  $guest_details = $obj->downloadDailyGuestBookingDetails($hotel_id);
  header("Content-type: application/vnd-ms-excel");
  $fileName = "cir_guest_details";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Guest Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>Room Category</th>
      <th>Booking Mode</th>
      <th>Pickup</th>
      <th>Flight Details</th>
      <th>Booking via</th>
      <th>Booking Id</th>
      <th>Chcecin Date</th>
      <th>Checkout Date</th>
      <th>Booking Night</th>
      <th>No. of Person</th>
      <th>Status</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        $date1=str_replace('/', '-', $guest_detail['checkin_date']);
        $date2=str_replace('/', '-', $guest_detail['checkout_date']);
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['guest_name'].'</td>
          <td>'.$guest_detail['guest_email'].'</td>
          <td>'.$guest_detail['guest_phone'].'</td>
          <td>'.$guest_detail['country'].'</td>
          <td>'.$guest_detail['room_category'].'</td>
          <td>'.$guest_detail['booking_mode'].'</td>
          <td>'.$guest_detail['pickup'].'</td>
          <td>'.$guest_detail['flight_details'].'</td>
          <td>'.$guest_detail['booking_via'].'</td>
          <td>'.$guest_detail['booking_id'].'</td>
          <td>'.$guest_detail['checkin_date'].'</td>
          <td>'.$guest_detail['checkout_date'].'</td>
          <td>'.$days.'</td>
          <td>'.$guest_detail['no_of_guest'].'</td>
          <td>'.$guest_detail['booking_status'].'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if(isset($_GET['type']) && $_GET['type'] == 'dailydata') {
  $guest_details = $obj->downloadDailyGuestDetails($hotel_id);
  header("Content-type: application/vnd-ms-excel");
  $fileName = "cir_guest_details";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Guest Name</th>
      <th>Gender</th>
      <th>S/O,D/O,W/O</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>State</th>
      <th>Pincode</th>
      <th>D.O.B</th>
      <th>Id Name</th>
      <th>Id Number</th>
      <th>Last Location</th>
      <th>Next Location</th>
      <th>Purpouse</th>
      <th>Address</th>
      <th>Arrival Date</th>
      <th>Arrival Location</th>
      <th>Passport No.</th>
      <th>Passport exp.</th>
      <th>Visa No.</th>
      <th>Visa exp.</th>
      <th>Booking via</th>
      <th>Booking Id</th>
      <th>Chcecin Date</th>
      <th>Checkout Date</th>
      <th>Final Checkout Date</th>
      <th>Booking Night</th>
      <th>Room No.</th>
      <th>No. of Person</th>
      <th>Booking Amount</th>
      <th>Extra Charge per Adult</th>
      <th>Meal Plan</th>
      <th>Status</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        if($guest_detail['status'] == 0){
          $status = 'checkin';
        }else{
          $status = 'checkedout';
        }
        echo '

        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['name'].'</td>
          <td>'.$guest_detail['gender'].'</td>
          <td>'.$guest_detail['son_of'].'</td>
          <td>'.$guest_detail['email'].'</td>
          <td>'.$guest_detail['phone'].'</td>
          <td>'.$guest_detail['country'].'</td>
          <td>'.$guest_detail['state'].'</td>
          <td>'.$guest_detail['pincode'].'</td>
          <td>'.$guest_detail['date_of_birth'].'</td>
          <td>'.$guest_detail['id_name'].'</td>
          <td>'.$guest_detail['id_number'].'</td>
          <td>'.$guest_detail['last_location'].'</td>
          <td>'.$guest_detail['next_location'].'</td>
          <td>'.$guest_detail['purpouse'].'</td>
          <td>'.$guest_detail['address'].'</td>
          <td>'.$guest_detail['arrival_date'].'</td>
          <td>'.$guest_detail['arrival_location'].'</td>
          <td>'.$guest_detail['passport_number'].'</td>
          <td>'.$guest_detail['pass_expiry_date'].'</td>
          <td>'.$guest_detail['visa_number'].'</td>
          <td>'.$guest_detail['visa_expiry_date'].'</td>
          <td>'.$guest_detail['booking_via'].'</td>
          <td>'.$guest_detail['booking_id'].'</td>
          <td>'.$guest_detail['checkin_date'].'</td>
          <td>'.$guest_detail['checkout_date'].'</td>
          <td>'.$guest_detail['final_checkout_date'].'</td>
          <td>'.$guest_detail['booking_nights'].'</td>
          <td>'.$guest_detail['room_number'].'</td>
          <td>'.$guest_detail['no_of_person'].'</td>
          <td>'.$guest_detail['booking_amount'].'</td>
          <td>'.$guest_detail['charge_per_adult'].'</td>
          <td>'.$guest_detail['meal_plan'].'</td>
          <td>'.$status.'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if(isset($_GET['type']) && $_GET['type'] == 'download_email/phone') {
  header("Content-type: application/vnd-ms-excel");
  $fileName = "cir_guest_emials";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  $guest_details = $obj->downloadGuestEmail($hotel_id);
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Email</th>
      <th>Phone</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['email'].'</td>
          <td>'.$guest_detail['phone'].'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if(isset($_REQUEST['download']) && isset($_POST['category']) && $_POST['category'] == 'Email') {
  
  if(isset($_POST['hotel'])){
    $hotel_id = $_POST['hotel'];
  }
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  if(isset($_POST['company'])){
    $company = $_POST['company'] ;
  } else {
    $company = "";
  }
  $guest_details = $obj->downloadDateWiseGuestEmail($hotel_id, $date1, $date2, $company);

  header("Content-type: application/vnd-ms-excel");
  $fileName = "cir_guest_emials_".$guest_details[0]['hotel_name'];
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
  	<tr>
  	  <th>S.N.</th>
  	  <th>Email</th>
  	</tr>
    <?php 
      $i=1;
      foreach ($guest_details as $guest_detail) {
      	echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['email'].'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php 
} if(isset($_REQUEST['download']) && isset($_POST['category']) && $_POST['category'] == 'Phone') {
  
  if(isset($_POST['hotel'])){
    $hotel_id = $_POST['hotel'];
  }
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  if(isset($_POST['company'])){
    $company = $_POST['company'] ;
  } else {
    $company = "";
  }
  $guest_details = $obj->downloadDateWiseGuestPhone($hotel_id, $date1, $date2, $company);

  header("Content-type: application/vnd-ms-excel");
  $fileName = "cir_guest_emials";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
 <table border="1px">
    <?php 
      $i=1;
      foreach ($guest_details as $guest_detail) {
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['phone'].'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php 

} if(isset($_REQUEST['download']) && isset($_POST['category']) && $_POST['category'] == 'All Detials') {
  if(isset($_POST['hotel'])){
    $hotel_id = $_POST['hotel'];
  }
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  
  if(isset($_POST['company'])){
    $company = $_POST['company'] ;
  } else {
    $company = "";
  }
  $guest_details = $obj->downloadTotalGuestDetailsDateWise($hotel_id, $date1, $date2, $company);
  
  //print_r($guest_details);die;

  header("Content-type: application/vnd.ms-excel");
  $fileName = "cir_guest_details";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Guest Name</th>
      <th>Gender</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Country</th>
      <th>State</th>
      <th>Id Name</th>
      <th>Id Number</th>
      <th>Last Location</th>
      <th>Next Location</th>
      <th>Purpouse</th>
      <th>Booking via</th>
      <th>Booking Id</th>
      <th>Chcecin Date</th>
      <th>Final Checkout Date</th>
      <th>Booking Night</th>
      <th>Room No.</th>
      <th>No. of Person</th>
      <th>Booking Amount</th>
      <th>Extra Charge per Adult</th>
      <th>Hotel Tax</th>
      <th>Hotel Gross Charges</th>
      <th>OTA Commission</th>
      <th>OTA GST</th>
      <th>OTA Commission (inc GST)</th>
      <th>OTA to Pay Hotel</th>
      <th>Meal Plan</th>
      <th>Status</th>
    </tr>
    <?php 
    $i=1;
      foreach ($guest_details as $guest_detail) {
        $checkin_id = $guest_detail['checkin_id'];
        //for last checkout date
        //$extended_nights = $obj->getExtendedBookingDetailsByCid($checkin_id);
        $no_of_night = $guest_detail['booking_nights'] + $guest_detail['extended_days'];
        //for total amount
        $amounts = $obj->getExtendedBookingAmountByCheckinID($checkin_id);
        if(!empty($amounts['sum_ext_amount'])){
          $total = ($amounts['sum_ext_amount'] + $guest_detail['booking_amount']);
        }else{
          $total = $guest_detail['booking_amount'];
        }

        if(!empty($extended_nights)){
          $date1 = $guest_detail['current_ci_date'];
          $date2 = $extended_nights['current_co_date'];

          $diff = abs(strtotime($date2) - strtotime($date1));

          $years = floor($diff / (365*60*60*24));
          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        }
        //print_r($extended_nights);die;

        if($guest_detail['status'] == 0){
          $status = 'checkin';
        }else{
          $status = 'checkedout';
        }

        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$guest_detail['hotel_name'].'</td>
          <td>'.$guest_detail['name'].'</td>
          <td>'.$guest_detail['gender'].'</td>
          <td>'.$guest_detail['email'].'</td>
          <td>'.$guest_detail['phone'].'</td>
          <td>'.$guest_detail['country'].'</td>
          <td>'.$guest_detail['state'].'</td>
          <td>'.$guest_detail['id_name'].'</td>
          <td>'.$guest_detail['id_number'].'</td>
          <td>'.$guest_detail['last_location'].'</td>
          <td>'.$guest_detail['next_location'].'</td>
          <td>'.$guest_detail['purpouse'].'</td>
          <td>'.$guest_detail['compnay_name'].'</td>
          <td>'.$guest_detail['booking_id'].'</td>
          <td>'.$guest_detail['current_ci_date'].'</td>
          <td>'.$guest_detail['final_checkout_date'].'</td>
          <td>'.$no_of_night.'</td>
          <td>'.$guest_detail['room_number'].'</td>';
          
          if(!empty($guest_detail['no_of_person'])){
            echo '<td>'.$guest_detail['no_of_person'].'</td>';
          }else{
            echo '<td>1</td>';
          }
          
          //total amount if booking is extened
          if(!empty($amounts)){
            echo '<td>'.$total.'</td>';
          }else{
            echo '<td>'.$guest_detail['booking_amount'].'</td>';
          }

          echo '<td>'.$guest_detail['charge_per_adult'].'</td>

          <td>'.$guest_detail['hotel_tax'].'</td>
          <td>'.$guest_detail['hotel_gross_charge'].'</td>
          <td>'.$guest_detail['commission'].'</td>
          <td>'.$guest_detail['gst_18'].'</td>
          <td>'.$guest_detail['commission_gst'].'</td>
          <td>'.$guest_detail['pay_to_hotel'].'</td>

          <td>'.$guest_detail['meal_plan'].'</td>
          <td>'.$status.'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php } if(isset($_GET['type']) && $_GET['type'] == 'travel_emails') {
  header("Content-type: application/vnd-ms-excel");
  $fileName = "Emails";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
  $travel_emails = $obj->downloadTravelsAgentsEmail();
  ?>
  <table border="1px">
    <tr>
      
      <th>Email</th>
    </tr>
    <?php 
    $i=1;
     
          foreach ($travel_emails as $email) {
            echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.$email['mailid'].'</td>
            </tr>
            ';
            
          }
       
    ?>
  </table>
  <?php 
}
?>

