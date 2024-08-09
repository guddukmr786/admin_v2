<?php
require_once '../include/config.php';
$db = new Database();
if(isset($_GET['type']) && $_GET['type'] == 'Emp_name'){
  $search_string =  $_POST['query'];
  if (strlen($search_string) >= 1 && $search_string !== ' ') {
      $hotel_id = $_COOKIE['hotel_id'];
      $query = 'SELECT * FROM employees WHERE hotel_id = "'.$hotel_id.'" AND name LIKE "%'.$search_string.'%" ORDER BY name ASC';
      $result = $db->execute($query);
      $result_array = $db->getResults($result);

      if (isset($result_array)) {
        $i=1;
        foreach ($result_array as $result) {
          $inserted_date = date_format(new DateTime($result['date_of_join']), 'd M Y , D');
          // Output HTML formats
          $html = '<li class="cir-item">';
          $html .= '<span class="cir-item-name size"><a href="#">emp_name</a></span><br>';
          $html .= '<span class="cir-item-desc size">emp_phone</span>';
          $html .= '</li><hr style="border:1px dotted #428BCA">';
         
          // Output strings and highlight the matches
          $name = $result['name'];
          $phone = $result['phone'];
        
          $o = str_replace('emp_name', $name, $html);
          $o = str_replace('emp_phone', $phone, $o);
          // Output it
          echo($o);

        }
      } else {
        // Replace for no results
        $o = str_replace('name', 'No Record Found', $html);
        $o = str_replace('phone', '', $o);
        // Output
        echo($o);
      }
  }

}else{

  $search_string =  trim($_POST['query']);
  if (strlen($search_string) >= 1 && $search_string !== ' ') {
      $hotel_id = $_SESSION['hotel_id'];
      $query = 'SELECT * FROM employees WHERE hotel_id = "'.$hotel_id.'" AND name LIKE "%'.$search_string.'%" ORDER BY name ASC';
      $result = $db->execute($query);
      $result_array = $db->getResults($result);

      if (isset($result_array)) {
        $i=1;
        $j=1;
        foreach ($result_array as $result) {
          $inserted_date = date_format(new DateTime($result['date_of_join']), 'd M Y , D');
          $employee_id = $result['employee_id'];
          $query_img = "SELECT * FROM employee_ids WHERE employee_id = '$employee_id' AND hotel_id = '$hotel_id'";
          $execute_img = $db->execute($query_img);
          $id_proof = $db->getResults($execute_img);
          $count = count($id_proof);
          // Output HTML formats
          $html ='<tr id="employee_id">';
          $html .='<td class="name">snString</td>';
          $html .='<td class="name">insertedDateString</td>';
          $html .='<td class="name">nameString</td>';
          $html .='<td class="name">fatherString<p></p></td>';
          $html .='<td class="name">phoneString</td>';
          $html .='<td class="name">hContactString</td>';
          $html .='<td class="name">refContactString</td>';
          $html .='<td class="name">departmentString</td>';
          $html .='<td class="name">caddressString</td>'; 
          $html .='<td class="name">addressString</td>';
          $html .='<td class="name">remarkString</td>';
          $html .='<td class="name">transferToString</td>';
          $html .='<td class="name">transferFromString</td>';
          $html .='<td class="name">';
          
          if($count > 0){ 
          for ($i=0; $i < $count; $i++) { 

          $html .='<a href="upload/employees_ids/imageString'.$i.'" target="_blank"><img src="upload/employees_ids/imageString" style="height: 50px;width: 50px;"></a>';
          } } 
          $html .='</td>';

          if($result['status'] == 0){

          $html .='<td class="name"><select name="employee_id" id="active"><option value="0" selected="selected">Active</option><option value="1">Inactive</option></select>';
          $html .='<img class="modallodardemployee_id" style="display: none" alt="" src="images/ajax-loader-search.gif" />';
          $html .='</td>';

          } else { 

          $html .='<td class="name"><select name="employee_id" id="active"><option value="0">Active</option><option value="1" selected="selected">Inactive</option></select>';
            $html .='<img class="modallodardemployee_id" style="display: none" alt="" src="images/ajax-loader-search.gif" />';
          $html .='</td>';

          }

          $html .='<td class="name"><a href="#edit_employee" data-toggle="modalemp"  id="employee_id" class="btn">Edit</a></td>';
         
          if($result['emp_status'] == 'Transferred') { 

          $html .='<td class="name"><a class="rejected_booking" >Transferred</a> </td>';

          } else { 

          $html .='<td class="name"><a href="#select_hotel" data-target="#myModal2" data-toggle="modaltransfer" class="btn" id="employee_id|nameString|phoneString" >Transfer</a> </td>';

          }
          $html .='</tr>';
          //nameString fatherString phoneString hContactString refContactString departmentString caddressString addressString remarkString transferToString transferFromString imageString
          $employee_id = $result['employee_id'];
          $modid = 'modallodard'.$result['employee_id'];
          $name = $result['name'];
          $father_name = $result['father_name'];
          $phone = $result['phone'];
          $home_contact = $result['home_contact'];
          $ref_contact = $result['ref_contact'];
          $email = $result['email'];
          $current_address = $result['current_address'];
          $address = $result['address'];
         
          $date_of_join = $result['date_of_join'];
          $remark = $result['remark'];
          $transfer_to = $result['transfer_to'];
          $transfer_from = $result['transfer_from'];

          foreach($id_proof as $id_proo){ 
            $images[] = $id_proo['images'];
          } 
          $o = str_replace('snString', $i++, $html);
          $o = str_replace('employee_id', $employee_id,$o);
          $o = str_replace('insertedDateString', $date_of_join, $o);
          $o = str_replace('nameString', $name, $o);
          $o = str_replace('fatherString', $father_name, $o);
          $o = str_replace('phoneString', $phone, $o);
          $o = str_replace('hContactString', $home_contact, $o);
          $o = str_replace('refContactString', $ref_contact, $o);
          $o = str_replace('departmentString', $email, $o);
          $o = str_replace('caddressString', $current_address, $o);
          $o = str_replace('addressString', $address, $o);
          $o = str_replace('remarkString', $remark, $o);
          $o = str_replace('transferToString', $transfer_to, $o);
          $o = str_replace('transferFromString', $transfer_from, $o);
          $o = str_replace('modallodardemployee_id', $modid, $o);
          
          if($count > 0){
          for ($i=0; $i < $count; $i++) {  
          $o = str_replace('idproof'.$i, $images[$i], $o);
          } }
          $o = str_replace('idstring', $employee_id, $o);
          // Output it
          echo($o);

        }
      } else {
        echo '<td colspan="17">
          <h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
          <br/>
          <p>Only Employee Name are accepted search field</p>
        </td>';
      }
  }
}
?>