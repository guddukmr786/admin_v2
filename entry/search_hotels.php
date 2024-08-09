<?php
require_once '../include/config.php';

$db = new Database();

$search_string = trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {

  $query = 'SELECT * FROM hotels WHERE CONCAT(hotel_name,"|",hotel_email) LIKE "%'.$search_string.'%"';

  $result = $db->execute($query);

  $result_array = $db->getResults($result);

  if (!empty($result_array)) {

    $i=1;

    foreach ($result_array as $result) {

      $html = '<tr>';

      $html .= '<td class="name">iii</td>';

      $html .= '<td class="name">hotelString</td>';
     
      $html .= '<td class="small">emailString</td>';
 
      $html .= '<td class="small">contactString</td>';

      $html .= '<td class="name">addressOneString</td>';

      $html .= '<td class="name">addressSecondString</td>';
      $html .= '<td class="name">starString</td>';
      $html .= '<td class="name">createdDateString</td>';
      if(isset($result['status']) && $result['status'] == 0 ){
        $html .= '<td class="name"><select style="padding:5px 0px 5px 5px;" name="hotel_id" id="active"><option value="0" selected="selected">Active</option><option value="1">Inactive</option></select>
          <img class="modallodard'."hotel_id".'" style="display: none" alt="" src="images/ajax-loader-search.gif" /></td>';
      } else{
        $html .='<td class="name"><select  style="padding:5px 0px 5px 5px;" name="hotel_id" id="active"><option value="0">Active</option><option value="1" selected="selected">Inactive</option></select>
            <img class="modallodard'."hotel_id".'" style="display: none" alt="" src="images/ajax-loader-search.gif" />
          </td>';
      } 

      $html .= '<td class="name""><a href="#user_edit" data-toggle="modaluser"  id="hotel_id" class="btn">Edit</a></td>';

      $html .= '</tr>';



      // Output strings and highlight the matches

      $hotel_id = $result['hotel_id'];

      $d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);

      $hotel_name = $result['hotel_name'];

      $email = $result['hotel_email'];

      $hotel_phone = $result['hotel_phone'];

      $hotel_address = $result['hotel_address'];

      $hotel_address1 = $result['hotel_address1'];

      $hotel_star = $result['hotel_star'];
      $added_date = $result['added_date'];

      // Replace the items into above HTML

   
      $o = str_replace('iii', $i++, $html);
      
      $o = str_replace('hotelString', $hotel_name, $o);

      $o = str_replace('emailString', $email, $o);

      $o = str_replace('contactString', $hotel_phone, $o);

      $o = str_replace('addressOneString', $hotel_address, $o);

      $o = str_replace('addressSecondString', $hotel_address1, $o);

      $o = str_replace('starString', $hotel_star, $o);

      $o = str_replace('createdDateString', $added_date, $o);

      $o = str_replace('hotel_id', $hotel_id, $o);

      // Output it

      echo($o);



      }

  } else {

    echo '<td colspan="16">
        <h4 style="font-family: Georgia, serif;">We could not find Hotel details matching your search criteria.</h4>
        <br/>
        <p>Only Hotel Name / Hotel Eamil are accepted search field</p>
      </td>';

  }

}

?>