<?php
require_once '../include/config.php';
$db = new Database();

$search_string =  trim($_POST['query']);
if (strlen($search_string) >= 1 && $search_string !== ' ') {
    $hotel_id = $_COOKIE['hotel_id'];
    //$query = 'SELECT * FROM day_book_entry WHERE hotel_id = "'.$hotel_id.'" AND expense_type LIKE "%'.$search_string.'%" OR expense_by LIKE "%'.$search_string.'%" OR department LIKE "%'.$search_string.'%" ORDER BY expense_type ASC';
    $query = 'SELECT * FROM day_book_entry WHERE hotel_id = "'.$hotel_id.'" AND CONCAT(expense_type,"|",expense_by,"|",department) LIKE "%'.$search_string.'%"';
    $result = $db->execute($query);
    $result_array = $db->getResults($result);
    
    $receive_value = 0;
    $pay_value = 0;
    foreach ($result_array as $result) {
      if($result['receive_pay'] == 'Receive'){
        $receive_value += $result['amount'];
      }elseif ($result['receive_pay'] == 'Pay') {
        $pay_value += $result['amount'];
      }
    }

    if (!empty($result_array)) {
      $i=1;
      foreach ($result_array as $result) {
        $inserted_date = date_format(new DateTime($result['date_of_expense']), 'd M Y , D');
        // Output HTML formats
        $html = '<tr id="idstring">';
        $html .= '<td class="name">snString</td>';
        $html .= '<td class="name">insertedDD</td>';
        $html .= '<td class="name">expBy</td>';
        if($result['expense_type'] == 'Cash balance') { 
          $html .= '<td class="name" style="background-color:#88C08B;">receiveAmount</td>';
        } else { 
          $html .= '<td class="name">receiveAmount</td>';
        } 
        $html .= '<td class="name">payAmount</td>';
        $html .= '<td class="name">description</td>';
        $html .= '<td class="name">deaprtment</td>';
        if($result['expense_type'] == 'Cash balance') {
        $html .= '<td class="name" style="width:80px;"><a disabled href="#edit_day_book" data-toggle="modaldaybook"  id="idstring" class="btn">Edit</a></td>';
        } else {
        $html .= '<td class="name" style="width:80px;"><a href="#edit_day_book" data-toggle="modaldaybook"  id="idstring" class="btn">Edit</a></td>';
        }
        $html .= '<td class="name" style="width:80px;"><a href="#" class="delete" title="idstring" id="btn_r1">Delete</a></td>';
        $html .= '</tr>';
        
        // Output strings and highlight the matches
        $receive_pay = $result['receive_pay'];
        $expense_by = $result['expense_by'];
        $amount = $result['amount'];
        $description = $result['description'];
        $department = $result['department'];
        //$inserted_date = $result['date_of_expense'];
        $day_b_id = $result['day_b_id'];
        // Replace the items into above HTML

        $o = str_replace('snString', $i++, $html);
        $o = str_replace('insertedDD', $inserted_date, $o);
        $o = str_replace('expBy', $expense_by, $o);
        if($result['receive_pay'] == 'Receive'){
            $o = str_replace('payAmount', '', $o);
            $o = str_replace('receiveAmount', $amount, $o);
        }
        if($result['receive_pay'] == 'Pay'){
          $o = str_replace('receiveAmount', '', $o);
          $o = str_replace('payAmount', $amount, $o);
        }
        $o = str_replace('description', $description, $o);
        $o = str_replace('deaprtment', $department, $o);
        $o = str_replace('idstring', $day_b_id, $o);
        // Output it
        echo($o);

      }
      $current_balance = $receive_value - $pay_value;
      echo '<hr>';
      echo '<tr>
              <td colspan="4" style="text-align:right;padding-right:70px;font-size:14px;">Total : '.$receive_value.'</td>
              <td  style="font-size:14px;">Total : '.$pay_value.'</td>
              <td colspan="5" style="text-align:right;padding-left:70px;font-size:14px;"> Currnet Balance : <span style="font-size:16px;">'.$current_balance.'</span>Rs.</td>
            </tr>';

      echo '<tr>';
            if($current_balance <= 0) { 
            echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;"><span style="color:red;">Closing Balance '.$current_balance.' Rs</span></td>';
            } else {
            echo '<td colspan="10" style="text-align:right;padding-right:10px;font-size:16px;color:#30C8FF;">Closing Balance  : ' . $current_balance . ' Rs</td>';
            }
      echo '</tr>';
    } else {
      // Replace for no results
      /*$o = str_replace('snString', '', $html);
      $o = str_replace('insertedDD', '', $o);
      $o = str_replace('expBy', '', $o);
      $o = str_replace('receiveAmount', '', $o);
      $o = str_replace('payAmount', '', $o);
      $o = str_replace('description', '', $o);
      $o = str_replace('deaprtment', '', $o);*/
      // Output
      echo '<td colspan="12">
        <h4 style="font-family: Georgia, serif;">We could not find guest details matching your search criteria.</h4>
        <br/>
        <p>Only Guest name/ phone number/ booking id are accepted search field</p>
      </td>';
    }
}
  echo '

  <script type="text/javascript">
    $(".delete").click(function(){
      var id = $(this).attr("title");
      if(confirm("Are you sure you want to delete this?")){
        $.ajax({
          url : "delete.php?type=delete_daybook&id="+id,
          type : "POST",
          success:function(res){
            if(res == 0){
              $("#error").hide();
              $("tr#"+id).css("background-color","#ccc");
              $("tr#"+id).fadeOut("slow");
            }else{
              $("#error").show().html("<div class=alert alert-danger>Error! Please try again later.</div>");
            }
          }
        });
      }else{
        return false;
      }
    });

    $("a[data-toggle=modaldaybook]").click(function(){
    var d_book_id = $(this).attr("id");
      $.ajax({
        url : "edit_day_book.php?d_book_id="+d_book_id,
        success:function(data){
          $(".popup1").show().html(data);
        }
      });
    });
  </script>';
?>