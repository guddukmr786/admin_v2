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
		$party_details['name'] = $_POST['name'];
	}
	$name = $_POST['name'];
	$tax = isset($_POST['tax']) ? $_POST['tax'] : flase;
	$booking_id = $_POST['booking'];
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$gstin = $_POST['gstin'];
	$invoice_date = $_POST['invoice_date'];
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

	$invoice_date = date('d-m-Y', strtotime($invoice_date));

	$tax = $tax/2;
	if($cgst != 0.00){
		$grand_total = number_format((float)$subtotal + $cgst + $sgst, 2, '.', '');
	}else{
		$grand_total = number_format((float)$subtotal + $igst, 2, '.', '');
	}
		
	


	class PDF extends FPDF{
		// Page header
		function Header(){
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
		    $this->Cell(30,5,'4781, Main Bazar, Pahar Ganj, Near New Delhi Railway Station, Central',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'NEW DELHI - 110055',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'Tel. : 011-41522406, +91 9999706194 | Email : booking@sushnattravels.com',0,0,'C');
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
	$pdf->Cell(5,2,$party_details['name'],0,0);
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
		$checkin_date = date('n-j-y',strtotime($checkin[$i]));
		$checkout_date = date('n-j-y',strtotime($checkout[$i]));
	    $pdf->Cell(10,7,$j++,'R',0,'C',0);
	    $pdf->SetFont('Times','',8);
		$pdf->Cell(104,7,$description[$i].'  ( '. $checkin_date .' to '. $checkout_date .' )','R',0,'L',0);
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
		$pdf->Cell(20,5,$igst,'',0,'R',0);
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
		$booking_details = $obj->getGeneratedInvoiceValueOfSushantTravelsById($id);
		//echo 'hi'.$booking_details['cgst']."<br>".$booking_details['sgst'];die;
		$invoice_no = 'ST'.$booking_details['s_invoice_id'];
		
		$data =  $obj->getDateDayOfSushantTravelsById($id);
		$count = count($data);

		$date_mo1 = str_replace('/','-',$booking_details['invoice_date']);
		$invoice_date = date('d-m-Y', strtotime($date_mo1));
		
		$tax = $booking_details['tax']/2;
		if($tax == 0.5){
			$tax = 0;
		}
		if($booking_details['cgst'] != 0.00){
			$grand_total = number_format((float)$booking_details['sub_total'] + $booking_details['cgst'] + $booking_details['sgst'], 2, '.', '');
		}else{
			$grand_total = number_format((float)$booking_details['sub_total'] + $booking_details['igst'], 2, '.', '');
		}
		
	}

	class PDF extends FPDF{
		// Page header
		function Header(){
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
		    $this->Cell(30,5,'4781, Main Bazar, Pahar Ganj, Near New Delhi Railway Station, Central',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'NEW DELHI - 110055',0,0,'C');
		    $this->Ln(5);
		    $this->Cell(80);
		    $this->Cell(30,5,'Tel. : 011-41522406, +91 9999706194 | Email : booking@sushnattravels.com',0,0,'C');
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

	$pdf->Rect(5, 42,  100,  30 );
	$pdf->ln(5);
	$pdf->Cell(30,0,'Name ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['name'],0,0);
	$pdf->Ln(5);
	$pdf->SetFont('Times','',10);
	if(!empty($booking_details['email'])){
		$pdf->Cell(30,0,'Email ',0,0);
		$pdf->Cell(5,0,' : ',0,0);
		$pdf->Cell(0,0,$booking_details['email'],0,0);
		$pdf->Ln(5);
	}
	$pdf->Cell(30,0,'Phone ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['contact'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(30,0,'City',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['city'],0,0);
	$pdf->Ln(5);
	$pdf->Cell(30,0,'Nationality',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['country'],0,0);
	

	//end Left rect data

	//Right rect data start
	$pdf->Rect(105, 42,  100,  30);
	$pdf->SetY(46);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Invoice ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_no,0,0);

	$pdf->SetY(51);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Invoice Date ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$invoice_date,0,0);

	$pdf->SetY(56);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Reverse Charge',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,'N',0,0);

	/*$pdf->SetY(61);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'Booking No.',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,'1546546456',0,0);*/
	
	$pdf->SetY(61);
	$pdf->SetX(108);
	$pdf->Cell(30,0,'GSTIN ',0,0);
	$pdf->Cell(5,0,' : ',0,0);
	$pdf->Cell(0,0,$booking_details['gstin'],0,0);
	$pdf->ln(10);
	
	//end of right code

	$pdf->SetLeftMargin(5);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->Cell(10,10,'S.N.','RB',0,'C',1);
	$pdf->Cell(20,10,'Date','RB',0,'C',1);
	$pdf->Cell(125,10,'Description','RB',0,'C',1);
	$pdf->Cell(25,10,'HSA/SAC Code','RB',0,'C',1);
	$pdf->Cell(20,10,'Amount','RB',0,'R',1);
	$pdf->ln();
	$pdf->SetTextColor(0, 0, 0);
    for($i=0;$i<$count;$i++){
    	$date_mo = str_replace('/','-',$data[$i]['days']);
	    $checkin_date = date('d-m-Y',strtotime($date_mo));
	  
	    $pdf->Cell(10,5,$data[$i]['sn'],'R',0,'C',0);
	    $pdf->Cell(20,5,$checkin_date,'R',0,'L',0);
	    $pdf->SetFont('Times','',8);
	    $pdf->Cell(125,5,$data[$i]['description'],'R',0,'L',0);
	    $pdf->SetFont('Times','',10);
	    $pdf->Cell(25,5,$data[$i]['hsn_code'],'R',0,'R',0);
	    $pdf->Cell(20,5,$data[$i]['amount'],'R',0,'R',0);
	    $pdf->Ln();
    }

    $pdf->Cell(10,10,'','RB',0,'R',0);
	$pdf->Cell(20,10,'','RB',0,'L',0);
	$pdf->Cell(125,10,'','RB',0,'L',0);
	$pdf->Cell(25,10,'','RB',0,'L',0);
	$pdf->Cell(20,10,'','RB',0,'R',0);
	$pdf->ln();
    
	$pdf->Cell(180,5,'','R',0,'R',0);
	$pdf->ln();
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
	}elseif($booking_details['igst'] != 0.00){
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
	$pdf->Cell(175,7,'Grand Total','TB',0,'R',0);
	$pdf->Cell(5,7,' ','TB',0,0);
	$pdf->Cell(20,7,$grand_total,'LTRB',0,'R',0);
	$pdf->ln();

	$pdf->SetFont('Times','',8);
	$pdf->Cell(26,5,'Terms & Conditions :','B',0,'L',0);
	$pdf->ln();
	$pdf->Cell(200,5,'E.& O.E.','R',0,'L',0);
	$pdf->ln();
	$pdf->Cell(200,5,'1. 100% Cancellation if cancelled prior 24 hours of Tour Departure.','',0,'L',0);
	$pdf->ln();
	$pdf->Cell(200,5,'2. 50% Cancellation if cancelled within 7 days of Tour Departure.','',0,'L',0);
	$pdf->ln();
	$pdf->Cell(200,5,'3. 25% Cancellation if cancelled within 15 days of Tour Departure.','',0,'L',0);
	$pdf->ln();
	$pdf->Cell(200,5,'4. 10% Cancellation if cancelled there after.','',0,'L',0);
	$pdf->ln(5);

	$pdf->SetFont('Times','',10);
	$pdf->Cell(26,7,'Sushant Travels :','T',0,'L',0);  
	$pdf->Cell(74,15,'','RT',0,'L',0); //margin 5 px from Right"
	$pdf->Cell(100,7,"Receivers's Signature :",'T',0,'L',0); 
	$pdf->ln(15);

	$pdf->SetFont('Times','',8);
	$pdf->Cell(95,5,"Authorised Signature",'B',0,'R',0);
	$pdf->Cell(5,5,"",'RB',0,'R',0); //margin 5 px from Right"
	$pdf->Cell(95,5,"Authorised Signature",'B',0,'R',0);
	$pdf->Cell(5,5,"",'RB',0,'R',0);
	$pdf->Output();
}

?>


