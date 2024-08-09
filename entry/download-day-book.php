<?php

include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];

if(isset($_REQUEST['day_book_download'])) {
  $date1 = $_POST['start_date'];
  $date2 = $_POST['end_date'];
  $depart = isset($_POST['depart'])  ? $_POST['depart'] : "";
 
  $day_book_detials = $obj->downloadDayBookEntryDateWise($hotel_id, $date1, $date2, $depart);
  header("Content-type: application/vnd.ms-excel");
  $fileName = "cir-day-book";
  header("Content-Disposition: attachment; filename=".$fileName.".xls");
 
  ?>
  <table border="1px">
    <tr>
      <th>Sn No.</th>
      <th>Hotel Name</th>
      <th>Expense Type</th>
      <th>Receive</th>
      <th>Pay</th>
      <th>Expense By</th>
      <th>Description</th>
      <th>Department</th>
      <th>Date of Expense</th>
      <th>Entry Date</th>
    </tr>
    <?php 
    $i=1;
 
      foreach ($day_book_detials as $day_book) {
        $amount = $day_book['amount'];
        $rec_pay = $day_book['receive_pay'];
        $date_of_expense = date_format( new DateTime($day_book['date_of_expense']), 'd M Y, D' );
        $inserted_date = date_format( new DateTime($day_book['inserted_date']), 'd M Y, D H:i A' );
        
        echo '
        <tr>
          <td>'.$i++.'</td>
          <td>'.$day_book['hotel_name'].'</td>
          <td>'.$day_book['expense_type'].'</td>';

          if($rec_pay == 'Receive')
            echo '<td>'.$day_book['amount'].'</td>';
          else
            echo '<td></td>';

          if($rec_pay == 'Pay')
            echo '<td>'.$day_book['amount'].'</td>';
          else
            echo '<td></td>';
          
          echo '<td>'.$day_book['expense_by'].'</td>
          <td>'.$day_book['description'].'</td>
          <td>'.$day_book['department'].'</td>
          <td>'.$date_of_expense.'</td>
          <td>'.$inserted_date.'</td>
        </tr>
        ';
      }
    ?>
  </table>
<?php 
}
?>

