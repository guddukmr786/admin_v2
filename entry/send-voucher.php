<?php
include_once('../include/config.php');
require '../PHPMailer/src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;

$db = new Database();
$hotel_id = $_COOKIE['hotel_id'];

$id = $_GET['id'];
$query = $db->execute("SELECT cbo.*, h.hotel_name FROM cir_booking_oyo cbo left join hotels h on cbo.hotel_id = h.hotel_id WHERE offlineb_id = '$id' limit 1");
$results = $db->getResult($query);

$filename = end(explode('/', $results['invoice_location']));
$subject = "Booking voucher from Check in Room";
$html = "";

$html .= '<!DOCTYPE html>';
$html .= '<html>';
$html .= '<head>';
$html .= '<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type">';
$html .= '<title>Reservation Confirmation Check In Room</title>';
$html .= '<style type="text/css">';

$html .= 'body,td,th {font-size: medium;color:#000000;}';
$html .= 'body {background-color: #ffdead;}';
$html .= '.style3 {font-size: 18px;font-weight: bold;}';
$html .= '.style4 {font-size: small;font-weight: bold;}';
$html .= '.style5 {font-size: small}';
$html .= '</style></head>';
$html .= '<body style="background-color: #ffadad00;">';
$html .= '<div align="center">';
$html .= '<table width="600" border="1" bordercolor="99CCFF">';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF"><div align="center">';
$html .= '<p class="style3"><img src="cid:logo" alt="Header" width="200" height="50"></p>';
$html .= '</div></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF"><img src="cid:banner" alt="Header" width="600" height="188"></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><strong>Dear Business Partner, </strong><br>';
$html .= '<br>Thank you for your continued support to Chec In Room<br>Please confirm the following booking that is done as per the allocation assigned to us.</br></br>';
$html .= '</div></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Reservation Details:</strong></div></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td width="121" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Hotel Name</span></div></td>';
$html .= '<td width="473" colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['hotel_name'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Guest Name</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['guest_name'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Phone Number</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['guest_phone'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Checkin Date</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['checkin_date'] . '</td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Checkout Date</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['checkout_date'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">No Of Nights</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['no_of_nights'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Type Of Room</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['room_category'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">No Of Room</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['no_of_rooms'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">No of Guest</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $results['no_of_adults'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Inclusions</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;Accommodation</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Payment Details</strong></div></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Room Charges </span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $results['room_charge'] . '</span></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Hotel Tax </span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $results['gst_charge'] . '</span></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Net Amount Pay At Hotel</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $results['pay_now'] . '</span></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Hotel Policy:</strong></div></td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Cancellation Policy</span></div></td>';
$html .= '<td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style5">Guaranteed reservations cancelled within 48 hours of arrival will be subject to a one night charge </span></div></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left">';

$html .= '<p align="left"><a href="http://www.checkinroom.in" target="_self">Check In Room</a> | booking@checkinroom.com</p>';
$html .= '</div></td>';
$html .= '</tr>';
$html .= '</table>';
$html .= '</div>';
$html .= '</body>';
$html .= '</html>';

$email = "guddu@digitalindiawebsolutions.com";
$invoice = 'http://checkinroom.in/uploads/cir_oyo_booking_voucher/' . $filename;
//$invoice = 'uploads/cir_oyo_booking_voucher/'.$filename;

$mail = new PHPMailer();
//$mail->IsSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "booking@checkinroom.com";
$mail->Password = "Vijay#1174";
$mail->Port = 465;
$mail->SMTPSecure = "ssl";
$mail->isHTML(true);
$mail->setFrom('booking@checkinroom.com', 'Check In Room');
$mail->addReplyTo('support@checkinroom.com');
$mail->addAddress($email);
$mail->addBCC('guddukmr786@gmail.com');

$mail->addStringAttachment(file_get_contents($invoice), $filename);
//$mail->AddStringAttachment($invoice, $filename,"base64", "application/pdf");
//$mail->AddAttachment($invoice, $name = $filename,  $encoding = 'base64', $type = 'application/pdf');
$mail->addEmbeddedImage('email/logo.png', 'logo');
$mail->addEmbeddedImage('email/hotel-temp.jpg', 'banner');
$mail->Subject = $subject;

$mail->Body = $html;

$mail->AltBody = '';

if (!$mail->send()) {
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo . "<br>";
} else {
  echo "success";
}
