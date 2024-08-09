<?php  

include_once('../lib/fetch_values.php');

$obj = new FetchValues();

if(empty($_SESSION['admin_id']) || $_SESSION['admin_id'] == "") {

  header('Location:../index.php');

  die;

}
$hotel_id = $_SESSION['hotel_id'];
if(isset($_GET['checkin_id'])){

  $checkin_id = $_GET['checkin_id'];

}

$customer_details = $obj->getEntryListById($checkin_id, $hotel_id);

$hotel_id = $customer_details['hotel_id'];

$hotel_details = $obj->getHotelDetailsById($hotel_id);

$summary_details = $obj->getSummaryDetailById($checkin_id);

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <title>Customer Final Checkout</title>

    <link rel="stylesheet" href="css/checkout.css" media="all" />

    <link rel="stylesheet" href="css/other.css" media="all" />

    <link rel="stylesheet" href="font-awesome-4.5.0/css/font-awesome.css" media="all" />

  </head>

  <body>

    <header class="clearfix">

     <p class="btn_add">

      <a href="#"  onclick="window.print()"><i class="fa fa-print">&nbsp;</i>Print Bill</a>
      <a href="add_summary.php?checkin_id=<?php echo $checkin_id;?>&type=update_bill"><i class="fa fa-print">&nbsp;</i>Update Bill</a>
      <a href="room_view.php"><i class="fa fa-print">&nbsp;</i>Go Back</a>

    </p>



      <div id="logo">

        <img src="images/logo.png" alt="check in room">

        

      </div>

     

      <h1>ID - <?php echo $customer_details['booking_id'];?> (Final Bill)</h1>

      <div id="company" class="clearfix">

        <div><strong><?php echo $hotel_details['hotel_name'];?></strong></div>

        <div><?php echo $hotel_details['hotel_address'];?><br /> <?php echo $hotel_details['hotel_address1'];?></div>

        <div><?php echo $hotel_details['hotel_phone'];?></div>

        <div><strong><?php echo $hotel_details['hotel_email'];?></strong></div>

      </div>

      <div id="project">

         <div><span>Booking Id</span> <?php echo $customer_details['booking_id'];?> </div>

        <div><span>Room No</span> <?php echo $customer_details['room_number'];?></div>

        <div><span>CLIENT</span> <?php echo $customer_details['name'];?></div>

        <div><span>ADDRESS</span> <?php echo $customer_details['address'];?></div>

        <div><span>EMAIL</span> <a href="<?php echo $customer_details['email'];?>"><?php echo $customer_details['email'];?></a></div>

        <div><span>Check In date</span> <?php echo $customer_details['checkin_date'];?></div>

        <div><span>Check Out date</span> <?php echo $customer_details['checkout_date'];?></div>

      </div>

    </header>

    <main>

      <table>

        <thead>

          <tr>

            <th class="bill"><strong>Bill ID</strong></th>

            <th class="desc"><strong>DESCRIPTION</strong></th>

            <th><strong><i class="fa fa-inr">&nbsp;</i>PRICE</strong></th>

            <th><strong>QTY</strong></th>

            <th><strong>TOTAL</strong></th>

          </tr>

        </thead>

        <tbody>

          <?php

          $sub_total=0;

          $advance_pay=0;

          foreach ($summary_details as $summary_detail) { ?>

          <tr>

            <td class="bill">CIR-Bill-<?php echo $summary_detail['bill_id'];?></td>

            <td class="desc"><?php echo $summary_detail['menu'];?></td>

            <td class="unit"><?php echo $summary_detail['bill_amount'];?></td>

            <td class="qty"><?php echo $summary_detail['qty'];?></td>

            <td class="total"><?php echo $summary_detail['total_amount'];?></td>

          </tr>

          <?php

            $sub_total+=$summary_detail['total_amount'];
            if(isset($summary_detail['advance_amount'])){
                $advance_pay += $summary_detail['advance_amount']; 
            }
            
          }

          $tax_rate=10;

          $tax = ($sub_total * $tax_rate)/100;
          if(isset($advance_pay)){
            $grand_total =($sub_total + $tax)- $advance_pay;
          }else{
               $grand_total = $sub_total + $tax;
          }
         

          ?>

          <tr>

            <td colspan="4"><strong>SUBTOTAL</strong></td>

            <td class="total"><?php echo $sub_total;?></td>

          </tr>

          <tr>

            <td colspan="4"><strong>Service Charge</strong> 10%</td>

            <td class="total"><?php echo round($tax, 2);?></td>

          </tr>

          <tr>

            <td colspan="4"><strong>Advance Payment</strong></td>

            <td class="total"><?php echo round($advance_pay, 2);?></td>

          </tr>

          <tr>

            <td colspan="4" class="grand total"><strong>GRAND TOTAL</strong></td>

            <td class="grand total"><?php echo round($grand_total, 2);?></td>

          </tr>

          

           </tbody>

      </table>

 



   

     

    </main>

    

    <footer>

   

   <p class="btn_add"><a href="room_view.php?checkin_id=<?php echo $customer_details['checkin_id'];?>&room_number=<?php echo $customer_details['room_number'];?>" ><i class="fa fa-sign-out">&nbsp;</i>Final Check Out</a></p>

    </footer>

  </body>

</html>