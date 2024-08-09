<?php
require_once '../include/config.php';
$db = new Database();
if(isset($_GET['type']) && $_GET['type'] == 'guest_details'){

  $search_string =  $_POST['query'];

  if (strlen($search_string) >= 1 && $search_string !== ' ') {

    $hotel_id = $_COOKIE['hotel_id'];
      
    $date = CURR_DATE;
    $query = 'SELECT * FROM check_in_details WHERE hotel_id = "'.$hotel_id.'" AND status = 0 AND checkout_date >= "'.$date.'" AND name LIKE "%'.$search_string.'%" ORDER BY name ASC';
    
    $result = $db->execute($query);
    $result_array = $db->getResults($result);

    if (isset($result_array)) {

      $i=1;
      foreach ($result_array as $result) {
        $checkin_id = $result['checkin_id'];
        $checkin_date = $result['checkin_date'];
        $query = "SELECT * FROM echeckin_person_name WHERE checkin_id = '$checkin_id' AND checkin_date = '$checkin_date'";
        $execute = $db->execute($query);
        $all_name = $db->getResults($execute);
        $count = count($all_name);

        // Output HTML formats
        $html .='<ul class="main_ul">';
        $html .='<span cir-item-name style="font-size: 14px;"><a><b>Room No. -room_number</b></a></span></br>';
        $html .='<li class="size"><a>name</a></li>';
        
        if($count > 0){ 
          for ($i=0; $i< $count; $i++) {

          $html .='<li class="size"><a>name'.$i.'</a></li>';

          } 
        }
        $html .='<li class="size">phone</li>';
        $html .='<li class="size">email</li>';
        $html .='<li class="size">checkin_date - checkout_date</li>';
        $html .='<hr style="border: 1px dotted #428BCA;">';
        $html .='</ul>';

        // Output strings and highlight the matches
        $room_number = $result['room_number'];
        $name = $result['name'];
        foreach($all_name as $all_na){ 
          $all_g_name[] = $all_na['name_title'].''.$all_na['name'];
        } 
        $phone = $result['phone'];
        $email = $result['email'];
        $checkin_date = date('d M, Y', strtotime(str_replace('/','-',$result['checkin_date'])));
        $checkout_date = date('d M, Y', strtotime(str_replace('/','-',$result['checkout_date'])));


        $o = str_replace('room_number', $room_number, $html);
        $o = str_replace('name', $name, $o);
        if($count > 0){
          for ($i=0; $i < $count; $i++) {  
            $o = str_replace('name'.$i, $all_g_name[$i], $o);
          } 
        }
        $o = str_replace('phone', $phone, $o);
        $o = str_replace('email', $email, $o);
        $o = str_replace('checkin_date', $checkin_date, $o);
        $o = str_replace('checkout_date', $checkout_date, $o);
        
        // Output it
        echo($o);

      }
    } else {
      
      $o = str_replace('No Record Found');
        echo($o);
    }
  }
}
?>