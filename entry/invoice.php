<?php 
require 'fpdf/fpdf.php';
include_once('../lib/fetch_values.php');
$obj = new FetchValues();
$hotel_id = $_COOKIE['hotel_id'];
if(isset($_REQUEST['submit_form'])){

	if(!empty($_POST['party'])){
		$party_id = $_POST['party'];
		$party_details = $obj->getPartyDetailsForUpdate($party_id);
	}else{
		$party_details['category_name'] = $_POST['name'];
	}
	$name = $_POST['name'];
	$tax = isset($_POST['tax']) ? $_POST['tax'] : flase;
	$booking_id = $_POST['booking'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$gstin = $_POST['gstin'];
	$invoice_date_i = $_POST['invoice_date'];
	//array values
	$description = $_POST['description']; 
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];
	$hsncode = $_POST['hsncode'];
	$unit = $_POST['unit'];
	$qty = $_POST['qty'];
	$price = $_POST['price'];
	$amount = $_POST['amount'];

	$subtotal = $_POST['subtotal'];
	$cgst = isset($_POST['cgst']) ? $_POST['cgst'] : false;
	$sgst = isset($_POST['sgst']) ? $_POST['sgst'] : false;
	$igst = isset($_POST['igst']) ? $_POST['igst'] : false;
	//$comm = $_POST['comm'];
	//$cgstcm = $_POST['cgstcm'];
	//$sgstcm = $_POST['sgstcm'];
	$total = $_POST['total'];
	$checkin_id = $_POST['checkin_id'];

	$travels = $obj->getLastIdOfInvoiceDescTable();
	$travel_id = $travels['travel_id']+1;

	$hotel = $obj->getHotelDetailsById($hotel_id);

	$hotel_code = strtoupper(substr($hotel['hotel_name'], 6,4));
	$invoice_no = $hotel_code.$travel_id;
	
	$count = count($description);

	//$date_m = date_format( new DateTime($room_guest_details['inserted_date']), 'd M Y, D H:i A' ); echo $date_m;
	$date_acb_i = str_replace('/', '-', $invoice_date_i);
	$invoice_date = date('d-m-Y', strtotime($date_acb_i));
	//$invoice_date = date('d-m-Y', strtotime($invoice_date));

	$tax = $tax/2;
	if($cgst != 0.00){
		$grand_total = number_format((float)$subtotal + $cgst + $sgst, 2, '.', '');
	}else{
		$grand_total = number_format((float)$subtotal + $igst, 2, '.', '');
	}
		
	


	class PDF extends FPDF{

		
		// Page header
		function Header(){

			$obj = new FetchValues();
			$hotel_id = $_COOKIE['hotel_id'];
			$hotel = $obj->getHotelDetailsById($hotel_id);

			// Logo
		    //$this->Image('https://www.sushanttravels.com/img/logo.png',10,6,30,'C');
		    // Arial bold 15

		    $this->Rect(5, 5, 200, 287, 'D');
		    
		    $this->SetFont('Times','',8);
		    $this->Cell(0,0,'GSTIN : 07AEWPT1205L1Z0',0,0,'L');
		    $this->SetFont('Times','',10);
		    // Move to the right
		    // Title
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'TAX INVOICE',0,0,'C');
		    $this->Ln(5);
		    $this->SetFont('Times','B',15);
		    $this->Cell(80);
		    $this->Cell(30,5,'SUSHANT TRAVELS',0,0,'C');
		    $this->Ln(5);
		    $this->SetFont('Times','',10);
		    $this->Cell(80);
		    $this->Cell(30,5,'5043, MAIN BAZAR, PAHARGANJ',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'NEW DELHI - 110055',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    //$this->Cell(30,5,'Tel. : '.$hotel['hotel_phone'] .' | Email : '.$hotel['hotel_email'] ,0,0,'C');
		    $this->Cell(30,5,'Email : '.$hotel['hotel_email'] ,0,0,'C');
		    // Line break
		    $this->Ln(6);
		    $this->SetLeftMargin(5);

		}
		// Page footer
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Times','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

	// Column headings
	$header = array(
			array('S.N.',10),
	        array('Description of Goods',70), 
	        array('HSN/SAC Code',35), 
	        array('Qty',15),
	        array('Unit',20),
	        array('Price',25),
	        array('Amount',25)
	    );
	// Instanciation of inherited class
	$pdf = new PDF();

	$pdf->AddPage();

	$pdf->SetFont('Times','B',12);

	//Left Rect data

	$pdf->Rect(5, 42,  100,  45 );
	$pdf->ln(5);
	$pdf->Cell(5,2,$party_details['category_name'],0,0);
	$pdf->Ln(5);
	$pdf->SetFont('Times','',10);
	if(!empty($party_details['addressl1'])){
	$pdf->Cell(5,2,$party_details['addressl1'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(5,2,$party_details['addressl2'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(5,2,$party_details['addressl3'],0,0);
	$pdf->Ln(10);
	}
	if(!empty($party_details['gstin'])){
		$pdf->Cell(30,2,'GSTIN ',0,0);
		$pdf->Cell(5,2,' : ',0,0);
		$pdf->Cell(0,2,$party_details['gstin'],0,0);
		$pdf->ln(10);
	}

	//end Left rect data
	//Right rect data start
	$pdf->Rect(105, 42,  100,  45);
	$pdf->SetY(47);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Invoice ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_no,0,0);

	$pdf->SetY(52);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Dated ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_date,0,0);

	$pdf->SetY(57);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Reverse Charge',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,'N',0,0);

	$pdf->SetY(62);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Booking No.',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_id,0,0);

	$pdf->SetY(67);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Name Of Hotel ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$hotel['hotel_name'],0,0);

	$pdf->SetY(72);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Guest Name ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$name,0,0);

	$pdf->SetY(77);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Nationality',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$country,0,0);
	$pdf->Ln(10);

	$pdf->SetY(82);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Guest GSTIN ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$gstin,0,0);
	$pdf->Ln(5);


	//table code here
	$pdf->SetLeftMargin(5);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(10,9,'S.N.','RB',0,'C',1);
	$pdf->Cell(104,9,'Description','RB',0,'C',1);
	$pdf->Cell(25,9,'HSA/SAC Code','RB',0,'C',1);
	$pdf->Cell(10,9,'Qty','RB',0,'C',1);
	$pdf->Cell(11,9,'Unit','RB',0,'C',1);
	$pdf->Cell(20,9,'Price','RB',0,'R',1);
	$pdf->Cell(20,9,'Amount','RB',0,'R',1);
	$pdf->ln();
	$pdf->SetTextColor(0, 0, 0);
	$j=1;
	for($i=0;$i<$count;$i++){
		//$checkin_date = date('n-j-y',strtotime($checkin[$i]));
		//$checkout_date = date('n-j-y',strtotime($checkout[$i]));
	    $pdf->Cell(10,7,$j++,'R',0,'C',0);
	    $pdf->SetFont('Times','',8);
		$pdf->Cell(104,7,$description[$i].'  ( '. $checkin[$i] .' to '. $checkout[$i] .' )','R',0,'L',0);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(25,7,$hsncode[$i],'R',0,'L',0);
		$pdf->Cell(10,7,$unit[$i],'R',0,'C',0);
		$pdf->Cell(11,7,$qty[$i],'R',0,'R',0);
		$pdf->Cell(20,7,$price[$i],'R',0,'R',0);
		$pdf->Cell(20,7,$amount[$i],'R',0,'R',0);
		$pdf->ln();
	}

	$pdf->Cell(10,30,'','RB',0,'R',0);
	$pdf->Cell(104,30,'','RB',0,'L',0);
	$pdf->Cell(25,30,'','RB',0,'L',0);
	$pdf->Cell(10,30,'','RB',0,'L',0);
	$pdf->Cell(11,30,'','RB',0,'R',0);
	$pdf->Cell(20,30,'','RB',0,'L',0);
	$pdf->Cell(20,30,'','RB',0,'L',0);
	$pdf->ln();


	$pdf->Cell(180,5,'','R',0,'R',0);
	$pdf->ln();
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(180,5,' ','R',0,'',0); 
	$pdf->Cell(20,5,$subtotal,'',0,'R',0);

	if($cgst != 0.00){
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(95,5,' Add','',0,'R',0);   // empty cell with left,top, and right borders
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'CGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$cgst,'',0,'R',0);
		$pdf->ln();
		$pdf->Cell(95,5,' Add','',0,'R',0);   
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'SGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$sgst,'',0,'R',0);
	}elseif($igst != 0.00){
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(95,5,' ','',0,'R',0);   // empty cell with left,top, and right borders
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(55,5,'','',0,'L',0);
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(20,5,' ','R',0,'L',0);
		$pdf->Cell(20,5,'','',0,'R',0);
		$pdf->ln();
		$pdf->Cell(95,5,' Add','',0,'R',0);   
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'IGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$igst,'',0,'R',0);
	}else{
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(95,5,' ','',0,'R',0);   // empty cell with left,top, and right borders
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(55,5,'','',0,'L',0);
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(20,5,' ','R',0,'L',0);
		$pdf->Cell(20,5,'','',0,'R',0);
		$pdf->ln();
		$pdf->Cell(95,5,' Add','',0,'R',0);   
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'GST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,'0 %','R',0,'L',0);
		$pdf->Cell(20,5,'0.00','',0,'R',0);
	}




	//Line(float x1, float y1, float x2, float y2)
	$pdf->ln();
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(175,7,'Grand Total','T',0,'R',0);
	$pdf->Cell(5,7,' ','T',0,0);
	$pdf->Cell(20,7,$grand_total,'LTRB',0,'R',0);
	$pdf->ln();
	$pdf->SetFont('Times','',10);
	$pdf->Cell(200,7,'Narration : Being room sale for '.$name ,'TB',0,'L',0);
	$pdf->ln();

	$pdf->SetFont('Times','',8);
	$pdf->Cell(25,5,'Terms & Conditions','LB',0,'L',0);   // empty cell with left,top, and right borders"
	$pdf->Cell(75,5,'','R',0,'L',0);
	$pdf->Cell(100,5,"Receivers's Signature :",'',0,'L',0); 
	$pdf->ln();
	$pdf->Cell(100,5,'E.& O.E.','R',0,'L',0);
	$pdf->Cell(100,5,"",'B',0,'L',0);
	$pdf->ln();
	$pdf->Cell(100,5,'1. Bill are payable presentation.','R',0,'L',0);
	$pdf->Cell(100,5,"for SUSHANT TRAVELS",'',0,'R',0);
	$pdf->ln();
	$pdf->Cell(100,5,'2. Check out time 11:00 am .','R',0,'L',0);
	$pdf->Cell(100,5,"",'',0,'L',0);
	$pdf->ln();
	$pdf->Cell(100,5,"3. Subject to 'Delhi' Jurisdiction only.",'RB',0,'L',0);
	$pdf->Cell(100,5,"Authorised Signature",'B',0,'R',0);

	$pdf->Output();

}else{

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		//Travler Details
		$booking_details = $obj->getGeneratedInvoiceValueById($id);
		//print_r($booking_details);die;
		if(!empty($booking_details['party_id']) && $booking_details['party_id'] != 12){
			$party_id = $booking_details['party_id'];
			$party_details = $obj->getPartyDetailsForUpdate($party_id);
		}else{
			$party_details['category_name'] = $booking_details['name'];
		}

		
		$hotel = $obj->getHotelDetailsById($hotel_id);
		$hotel_code = strtoupper(substr($hotel['hotel_name'], 6,4));
		$invoice_no = $hotel_code.$booking_details['travel_id'];
		
		$data =  $obj->getDateDayById($id);
		$count = count($data);
		$date_acb = str_replace('/', '-', $booking_details['invoice_date']);
		$invoice_date = date('d-m-Y', strtotime($date_acb));
		
		$tax = $booking_details['tax']/2;
		if($tax == 0.5){
			$tax = 0;
		}
		if($booking_details['cgst'] != 0.00){
			$grand_total = number_format((float)$booking_details['sub_total'] + $booking_details['cgst'] + $booking_details['sgst'], 2, '.', '');
		}else{
			$grand_total = number_format((float)$booking_details['sub_total'] + $booking_details['igst'], 2, '.', '');
		}

		/*if(!empty($booking_details['commission'])){
			$grand_total = $grand_total - $booking_details['commission'];
		}
		if(!empty($booking_details['cgst_comm'])){
			$grand_total = $grand_total - $booking_details['cgst_comm'];
		}	*/
		
	}

	class PDF extends FPDF{
		// Page header
		function Header(){

			$obj = new FetchValues();
			$hotel_id = $_COOKIE['hotel_id'];
			$hotel = $obj->getHotelDetailsById($hotel_id);
		    // Logo
		    //$this->Image('https://www.sushanttravels.com/img/logo.png',10,6,30,'C');
		    // Arial bold 15

		    $this->Rect(5, 5, 200, 287, 'D');
		    
		    $this->SetFont('Times','',8);
		    $this->Cell(0,0,'GSTIN : 07AEWPT1205L1Z0',0,0,'L');
		    $this->SetFont('Times','',10);
		    // Move to the right
		    // Title
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'TAX INVOICE',0,0,'C');
		    $this->Ln(5);
		    $this->SetFont('Times','B',15);
		    $this->Cell(80);
		    $this->Cell(30,5,'SUSHANT TRAVELS',0,0,'C');
		    $this->Ln(5);
		    $this->SetFont('Times','',10);
		    $this->Cell(80);
		    $this->Cell(30,5,'5043, MAIN BAZAR, PAHARGANJ',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'NEW DELHI - 110055',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    //$this->Cell(30,5,'Tel. : 9999331194, 9899553362 Email : accounts@budgettravelindia.com',0,0,'C');
		    $this->Cell(30,5,' Email : '.$hotel['hotel_email'] ,0,0,'C');
		    // Line break
		    $this->Ln(6);
		    $this->SetLeftMargin(5);

		}
		// Page footer
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Times','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}


	// Instanciation of inherited class
	$pdf = new PDF();

	$pdf->AddPage();

	$pdf->SetFont('Times','B',12);

	//Left Rect data

	$pdf->Rect(5, 42,  100,  45 );
	$pdf->ln(5);
	$pdf->Cell(5,2,$party_details['category_name'],0,0);
	$pdf->Ln(5);
	$pdf->SetFont('Times','',10);
	$pdf->Cell(5,2,$party_details['addressl1'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(5,2,$party_details['addressl2'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(5,2,$party_details['addressl3'],0,0);
	$pdf->Ln(10);
	if(!empty($party_details['gstin'])){
		$pdf->Cell(30,2,'GSTIN ',0,0);
		$pdf->Cell(5,2,' : ',0,0);
		$pdf->Cell(0,2,$party_details['gstin'],0,0);
		$pdf->ln(10);
	}

	//end Left rect data
	//Right rect data start
	$pdf->Rect(105, 42,  100,  45);
	$pdf->SetY(47);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Invoice ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_no,0,0);

	$pdf->SetY(52);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Dated ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_date,0,0);

	$pdf->SetY(57);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Reverse Charge',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,'N',0,0);

	$pdf->SetY(62);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Booking No.',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['booking_id'],0,0);

	$pdf->SetY(67);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Name Of Hotel ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$hotel['hotel_name'],0,0);

	$pdf->SetY(72);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Guest Name ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['name'],0,0);

	$pdf->SetY(77);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Nationality',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['country'],0,0);
	$pdf->Ln(10);

	$pdf->SetY(82);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Guest GSTIN ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['gstin'],0,0);
	$pdf->Ln(5);


	//table code here
	$pdf->SetLeftMargin(5);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(10,9,'S.N.','RB',0,'C',1);
	$pdf->Cell(104,9,'Description','RB',0,'C',1);
	$pdf->Cell(25,9,'HSA/SAC Code','RB',0,'C',1);
	$pdf->Cell(10,9,'Qty','RB',0,'C',1);
	$pdf->Cell(11,9,'Unit','RB',0,'C',1);
	$pdf->Cell(20,9,'Price','RB',0,'R',1);
	$pdf->Cell(20,9,'Amount','RB',0,'R',1);
	$pdf->ln();
	$pdf->SetTextColor(0, 0, 0);
	for($i=0;$i<$count;$i++){
		//$checkin_date = date('n-j-y',strtotime($data[$i]['checkin_date']));
		//$checkout_date = date('n-j-y',strtotime($data[$i]['checkout_date']));
	    $pdf->Cell(10,7,$data[$i]['sn'],'R',0,'C',0);
	    $pdf->SetFont('Times','',8);
		$pdf->Cell(104,7,$data[$i]['description'].'  ( '. $data[$i]['checkin_date'] .' to '. $data[$i]['checkout_date'] .' )','R',0,'L',0);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(25,7,$data[$i]['hsn_code'],'R',0,'L',0);
		$pdf->Cell(10,7,$data[$i]['qty'],'R',0,'C',0);
		$pdf->Cell(11,7,$data[$i]['unit'],'R',0,'R',0);
		$pdf->Cell(20,7,$data[$i]['price'],'R',0,'R',0);
		$pdf->Cell(20,7,$data[$i]['amount'],'R',0,'R',0);
		$pdf->ln();
	}

	$pdf->Cell(10,30,'','RB',0,'R',0);
	$pdf->Cell(104,30,'','RB',0,'L',0);
	$pdf->Cell(25,30,'','RB',0,'L',0);
	$pdf->Cell(10,30,'','RB',0,'L',0);
	$pdf->Cell(11,30,'','RB',0,'R',0);
	$pdf->Cell(20,30,'','RB',0,'L',0);
	$pdf->Cell(20,30,'','RB',0,'L',0);
	$pdf->ln();


	$pdf->Cell(180,5,'','R',0,'R',0);
	$pdf->ln();
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(180,5,' ','R',0,'',0); 
	$pdf->Cell(20,5,$booking_details['sub_total'],'',0,'R',0);

	if($booking_details['cgst'] != 0.00){
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(95,5,' Add','',0,'R',0);   // empty cell with left,top, and right borders
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'CGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$booking_details['cgst'],'',0,'R',0);
		$pdf->ln();
		$pdf->Cell(95,5,' Add','',0,'R',0);   
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'SGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$booking_details['sgst'],'',0,'R',0);
	}else{
		$pdf->Ln();
		$pdf->SetFont('Times','',10);
		$pdf->Cell(95,5,' ','',0,'R',0);   // empty cell with left,top, and right borders
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(55,5,'','',0,'L',0);
		$pdf->Cell(5,5,'','',0,'L',0);
		$pdf->Cell(20,5,' ','R',0,'L',0);
		$pdf->Cell(20,5,'','',0,'R',0);
		$pdf->ln();
		$pdf->Cell(95,5,' Add','',0,'R',0);   
		$pdf->Cell(5,5,':','',0,'L',0);
		$pdf->Cell(55,5,'IGST','',0,'L',0);
		$pdf->Cell(5,5,'@','',0,'L',0);
		$pdf->Cell(20,5,$tax.' %','R',0,'L',0);
		$pdf->Cell(20,5,$booking_details['igst'],'',0,'R',0);
	}



	//Line(float x1, float y1, float x2, float y2)
	$pdf->ln();
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(175,7,'Grand Total','T',0,'R',0);
	$pdf->Cell(5,7,' ','T',0,0);
	$pdf->Cell(20,7,$grand_total,'LTRB',0,'R',0);
	$pdf->ln();
	$pdf->SetFont('Times','',10);
	$pdf->Cell(200,7,'Narration : Being room sale for '.$booking_details['name'] ,'TB',0,'L',0);
	$pdf->ln();

	$pdf->SetFont('Times','',8);
	$pdf->Cell(25,5,'Terms & Conditions','LB',0,'L',0);   // empty cell with left,top, and right borders"
	$pdf->Cell(75,5,'','R',0,'L',0);
	$pdf->Cell(100,5,"Receivers's Signature :",'',0,'L',0); 
	$pdf->ln();
	$pdf->Cell(100,5,'E.& O.E.','R',0,'L',0);
	$pdf->Cell(100,5,"",'B',0,'L',0);
	$pdf->ln();
	$pdf->Cell(100,5,'1. Bill are payable presentation.','R',0,'L',0);
	$pdf->Cell(100,5,"for SUSHANT TRAVELS",'',0,'R',0);
	$pdf->ln();
	$pdf->Cell(100,5,'2. Check out time 11:00 am .','R',0,'L',0);
	$pdf->Cell(100,5,"",'',0,'L',0);
	$pdf->ln();
	$pdf->Cell(100,5,"3. Subject to 'Delhi' Jurisdiction only.",'RB',0,'L',0);
	$pdf->Cell(100,5,"Authorised Signature",'B',0,'R',0);

	$pdf->Output();
}

?>


