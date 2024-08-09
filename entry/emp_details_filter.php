<?php 
include_once('../lib/fetch_values.php');
$obj = new FetchValues();

include('is_login.php');
$hotel_id = $_COOKIE['hotel_id'];
if(empty($_POST['start_date']) && empty($_POST['end_date']) && !empty($_POST['depart'])){
  $dept = $_POST['depart'];
  $emp_details = $obj->getEmpDetailsByDepartment($hotel_id, $dept);

}

if(!empty($_POST['start_date']) && empty($_POST['end_date']) && empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $emp_details = $obj->getEmpDetailsByStartDate($hotel_id,$start_date);
}

if(!empty($_POST['start_date']) && !empty($_POST['end_date']) && empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $emp_details = $obj->getEmpDetailsByDateToDate($hotel_id,$start_date,$end_date);
}
if(!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $dept = $_POST['depart'];
  $emp_details = $obj->getEmpDetailsByDepartmentAndDate($hotel_id,$start_date,$end_date, $dept);
}
if(!empty($_POST['start_date']) && empty($_POST['end_date']) && !empty($_POST['depart'])){
  $start_date = $_POST['start_date'];
  $dept = $_POST['depart'];
  $emp_details = $obj->getEmpDetailsByDepartmentAndStartDate($hotel_id,$start_date,$dept);
}
if(empty($_POST['start_date']) && empty($_POST['end_date']) && empty($_POST['depart'])){
  $emp_details = "";
  echo 1;die;
}
if(isset($_POST['start_date'])){
  $start_date = $_POST['start_date'];
}
 //$avi_balance = $receive_value - $pay_value;
?>
<?php echo '
  <div id="tablesearch_top">';?>
    <?php echo '<section>
      <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable" width="100%">
        <thead>
          <tr>
            <th><h3>S.No.</h3></th>
            <th><h3>Date of Join</h3></th>
            <th><h3>Name</h3></th>
            <th><h3>Phone</h3></th>
            <th><h3>Department</h3></th>
            <th><h3>Remark</h3></th>
            <th><h3>ID Proof</h3></th>
            <th><h3>&nbsp;</h3></th>
            <th><h3>&nbsp;</h3></th>
          </tr>
        </thead>
        <tbody>';?>
          <?php
            $i=1;
            if(!empty($emp_details)){ 
            foreach ($emp_details as $emp_detail) { 
            $inserted_date = date_format(new DateTime($emp_detail['date_of_join']), 'd M Y , D');
            $employee_id = $emp_detail['employee_id'];
            $id_proof = $obj->getEmployeesIds($employee_id, $hotel_id);

          ?>
          <?php echo '<tr id="'?><?php echo $emp_detail['employee_id'];?><?php echo '">';?>
            <?php echo '<td class="name" >';?><?php echo $i++;?><?php echo '</td>
            <td class="name">';?><?php echo $inserted_date;?><?php echo '</td>
            <td class="name">';?><?php echo $emp_detail['name'];?><?php '<p>';?><?php if(!empty($emp_detail['address'])){ echo '( '.$emp_detail['address'] .' )';}?><?php '</p>';?><?php echo '</td>
            <td class="name">';?><?php echo $emp_detail['phone'];?><?php '<p>';?><?php if(!empty($emp_detail['email'])){ echo $emp_detail['email'];}?><?php '</p>';?><?php echo '</td>
            <td class="name">';?><?php echo $emp_detail['department'];?><?php echo '</td>';?>
            <?php echo '<td class="name">';?><?php echo $emp_detail['remark'];?><?php echo '</td>';?>

            <?php echo '<td class="name">';?>
            <?php
            if(isset($id_proof)){
            foreach($id_proof as $id_proo){ ?>
            <?php echo '<a href="upload/employees_ids/';?><?php echo $id_proo['images'] ;?><?php echo '" target="_blank"><img src="upload/employees_ids/';?><?php echo $id_proo['images'] ;?><?php echo '" style="height: 50px;width: 50px;"></a>';?>
            <?php } } ?>
            <?php echo '</td>
            <td class="name" style="width:80px;"><a href="#edit_employee" data-toggle="modalemp"  id="';?><?php echo $emp_detail['employee_id'];?><?php echo '" class="btn">Edit</a></td>';?>

            <?php echo '<td class="name" style="width:80px;"><a href="#" class="delete" title="';?><?php echo $emp_detail['employee_id'];?><?php echo '" id="btn_r1">Delete</a></td></tr>';?>

        <?php } } else { ?>
        <?php echo '<tr><td colspan="10" style="height:50px;"><h1>No record found.</h1></td></tr>';?>
        <?php } ?>
        <?php echo '</tbody>
      </table>
    </section>';?>
  <?php echo '
  </div>
</div>';?>
<?php 
  echo '
  <script type="text/javascript">

    $(".delete").click(function(){
      var id = $(this).attr("title");
      if(confirm("Are you sure you want to delete this?")){
        $.ajax({
          url : "delete.php?type=delete_employee_details&id="+id,
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

    $("a[data-toggle=modalemp]").click(function(){
    var employee_id = $(this).attr("id");
      $.ajax({
        url : "edit_emp_detials.php?employee_id="+employee_id,
        success:function(data){
          $(".popup1").show().html(data);
        }
      });
    });
  </script>';
?>