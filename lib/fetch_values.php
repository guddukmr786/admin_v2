<?php
require_once '../include/config.php';
require '../PHPMailer/src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;

class FetchValues

{
  private $db;
  private $id;
  private $hotel_id;
  private $setLimit;
  private $pageLimit;
  private $room_status;
  private $room_number;
  private $checkin_date;
  private $checkin_id;
  private $start_date;
  private $end_date;
  private $dept;
  private $c_balance;
  private $depart;
  private $company;
  private $travel_id;
  private $s_invoice_id;
  private $party_id;
  function __construct()
  {
    $this->db = new Database();
  }


  public function getTravelDetails($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;

    $query_list = "SELECT * FROM travel_details ORDER BY id DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getAllInsertedhotelDetails($setLimit, $pageLimit)
  {
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;

    $query_list = "SELECT * FROM hotel_details ORDER BY hotel_details_id DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getInsertedHotelDetailsById($id)
  {

    $this->id = $id;
    $query = $this->db->execute("SELECT * FROM hotel_details WHERE hotel_details_id = '$id' LIMIT 1");
    return $this->db->getResult($query);
  }

  public function getCheckinDetailForUpdate($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM check_in_details WHERE checkin_id = '$id' AND hotel_id ='$hotel_id'";
    $update_details = $this->db->execute($query);
    $results = $this->db->getResult($update_details);
    return $results;
  }

  public function getCountries()
  {
    $countries = $this->db->execute("SELECT DISTINCT country_name FROM country_states ORDER BY country_name ASC");
    $results = $this->db->getResults($countries);
    return $results;
  }
  public function getAllBookingViaCategories()
  {
    $booki = $this->db->execute("SELECT * FROM booking_via  WHERE status=0 ORDER BY booking_via_id ASC");
    $results = $this->db->getResults($booki);
    return $results;
  }

  public function getTotalEntryList($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;

    $query_list = "SELECT cid.*, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.hotel_id = '$id' ORDER BY cid.final_checkout_date ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getTotalArrivalBookingList($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    $crr_date = CURR_DATE;
    $query_booking_list = "SELECT * FROM arrival_booking_history WHERE hotel_id = '$id' AND status = 0 AND checkin_date = '$crr_date' ORDER BY checkin_date DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_booking_list);
    $results = $this->db->getResults($execute_query);

    /*$query_again = "SELECT * FROM arrival_booking_history WHERE hotel_id = '$id' AND status = 0 AND checkin_date != '$crr_date' ORDER by checkin_date DESC LIMIT ".$pageLimit." , ".$setLimit;
    $execute_query_again = $this->db->execute($query_again);
    $results[] = $this->db->getResults($execute_query_again);*/
    return $results;
  }

  public function getTotalCirArrivalBookingList($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    $crr_date = CURR_DATE;
    $query_booking_list = "SELECT * FROM cir_booking_oyo WHERE hotel_id = '$id' AND checkin_date = '$crr_date' ORDER BY checkin_date DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_booking_list);
    $results = $this->db->getResults($execute_query);

    /*$query_again = "SELECT * FROM arrival_booking_history WHERE hotel_id = '$id' AND status = 0 AND checkin_date != '$crr_date' ORDER by checkin_date DESC LIMIT ".$pageLimit." , ".$setLimit;
    $execute_query_again = $this->db->execute($query_again);
    $results[] = $this->db->getResults($execute_query_again);*/
    return $results;
  }

  public function getDateWiseCheckedinDetails($id)
  {
    $this->id = $id;
    $crr_date = CURR_DATE;
    $query_booking_list = "SELECT * FROM guest_checkin_history WHERE hotel_id = '$id' AND status = 0 AND checkin_date = '$crr_date' ORDER BY checkin_date DESC ";
    //echo $query_booking_list;die;
    $execute_query = $this->db->execute($query_booking_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getDateWiseCheckinDetailsListById($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM guest_checkin_history WHERE checkin_history_id = '$id' AND hotel_id = '$hotel_id'";
    $execute_query = $this->db->execute($query);
    $results = $this->db->getResult($execute_query);
    return $results;
  }

  public function getDateWiseCheckedinDetailsFilter($hotel_id, $start_date, $end_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $query_list = "SELECT * FROM guest_checkin_history WHERE hotel_id = '$hotel_id' AND current_ci_date >= '$start_date' AND current_ci_date <= '$end_date' ORDER BY current_ci_date ASC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function downloadTotalGuestDetails($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query_list = "SELECT cid.*, h.hotel_name as hotel_name, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.status=0 AND cid.hotel_id = '$hotel_id' ORDER BY cid.checkin_id DESC ";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }



  public function downloadDailyGuestDetails($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $current_date = CURR_DATE1;
    $query_list = "SELECT cid.*, h.hotel_name as hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.status=0 AND cid.current_ci_date ='$current_date' AND cid.hotel_id ='$hotel_id' ORDER BY cid.checkin_id DESC ";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  // //SELECT cid.*, gi.id_proof, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN guest_ids gi ON cid.checkin_id = gi.checkin_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.hotel_id = '$id' AND cid.room_number = '$room_number' AND cid.status = 0
  public function downloadTotalGuestBookingDetails($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query_list = "SELECT abh.*, h.hotel_name as hotel_name, bv.category_name as compnay_name FROM arrival_booking_history abh LEFT JOIN hotels h ON abh.hotel_id = h.hotel_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE abh.status=0 AND abh.hotel_id = '$hotel_id' ORDER BY abh.arrival_b_id DESC ";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function downloadDailyGuestBookingDetails($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $current_date = CURR_DATE;
    $query_list = "SELECT abh.*, h.hotel_name as hotel_name FROM arrival_booking_history abh LEFT JOIN hotels h ON abh.hotel_id = h.hotel_id WHERE abh.status=0 AND abh.checkin_date ='$current_date' AND abh.hotel_id = '$hotel_id' ORDER BY abh.arrival_b_id DESC ";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function downloadGuestEmail($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query_list = "SELECT cid.email, cid.phone, h.hotel_name as hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.hotel_id ='$hotel_id' ORDER BY cid.checkin_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function downloadTravelsAgentsEmail()
  {
    $query_list = "SELECT mailid FROM travel_details";
    $execute_query = $this->db->execute($query_list);
    return $this->db->getResults($execute_query);
  }

  public function downloadDateWiseGuestEmail($hotel_id, $start_date, $end_date, $company)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->company = $company;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    $query = "SELECT cid.email, cid.checkin_date, h.hotel_name, cid.booking_id FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.final_checkout_date >='$date1' AND cid.final_checkout_date <='$date2'";

    if (!empty($hotel_id)) {
      $query .= " AND cid.hotel_id ='$hotel_id'";
    }
    if (!empty($company)) {
      $query .= " AND cid.booking_via='$company'";
    }
    $query .= " ORDER BY cid.final_checkout_date ASC";
    //$query_list = "SELECT cid.email, cid.checkin_date, h.hotel_name, cid.booking_id as hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.final_checkout_date >='$date1' AND cid.final_checkout_date <='$date2' AND cid.booking_via='$company' AND cid.hotel_id ='$hotel_id' ORDER BY cid.final_checkout_date ASC";

    $execute_query = $this->db->execute($query);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function downloadDateWiseGuestPhone($hotel_id, $start_date, $end_date, $company)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->company = $company;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    //$query_list = "SELECT cid.phone,cid.checkin_date, h.hotel_name as hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.final_checkout_date >='$date1' AND cid.final_checkout_date <='$date2' AND cid.booking_via='$company' AND cid.hotel_id ='$hotel_id' ORDER BY cid.final_checkout_date ASC";

    $query_list = "SELECT cid.phone,cid.checkin_date, h.hotel_name as hotel_name FROM check_in_details cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id WHERE cid.final_checkout_date >='$date1' AND cid.final_checkout_date <='$date2'";
    if (!empty($hotel_id)) {
      $query_list .= " AND cid.hotel_id ='$hotel_id'";
    }
    if (!empty($company)) {
      $query_list .= " AND cid.booking_via='$company'";
    }
    $query_list .= " ORDER BY cid.final_checkout_date ASC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }
  //test
  public function downloadTotalGuestDetailsDateWise($hotel_id, $start_date, $end_date, $company)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->company = $company;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));

    $_SESSION['report_hotel_id'] = $hotel_id;

    //SELECT cid.*, gi.id_proof, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN guest_ids gi ON cid.checkin_id = gi.checkin_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.hotel_id = '$id' AND cid.room_number = '$room_number' AND cid.status = 0
    $query_list = "SELECT cid.*, h.hotel_name as hotel_name , bv.category_name as compnay_name  FROM guest_checkin_history cid LEFT JOIN hotels h ON cid.hotel_id = h.hotel_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id  WHERE cid.current_ci_date >='$date1' AND cid.current_ci_date <='$date2'";
    if (!empty($hotel_id)) {
      $query_list .= " AND cid.hotel_id ='$hotel_id'";
    }
    if (!empty($company)) {
      $query_list .= " AND cid.booking_via='$company'";
    }
    $query_list .= " ORDER BY cid.current_ci_date DESC";

    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getExtendedBookingDetailsByCid($checkin_id)
  {

    $this->checkin_id = $checkin_id;
    $query = $this->db->execute("SELECT * FROM extended_booking_days WHERE checkin_id = '$checkin_id' ORDER BY ex_booking_id DESC LIMIT 1");
    //$results = $this->db->getResult($query);
    return $this->db->getResult($query);
  }

  public function getTotalAmountOfExtendedDays($checkin_id)
  {
    $this->checkin_id = $checkin_id;
    $query = $this->db->execute("SELECT SUM(booking_amount) as total FROM extended_booking_days WHERE checkin_id = '$checkin_id'");
    return $this->db->getResult($query);
  }


  public function getEntryListById($id)
  {
    $this->id = $id;
    $query_list = "SELECT cid.*, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.checkin_id = '$id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getEntryListByRoomNumber($room_number, $hotel_id)
  {
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    $query_list = "SELECT * FROM check_in_details WHERE room_number = '$room_number' AND status=0 AND hotel_id = '$hotel_id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getBookingAmountById($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query_ro = $this->db->execute("SELECT room_number FROM check_in_details WHERE checkin_id = '$id' AND status=0 AND hotel_id = '$hotel_id'");
    $query_res = $this->db->getResult($query_ro);
    $room_number = $query_res['room_number'];

    $query_list = "SELECT amount FROM day_book_entry WHERE expense_by = '$room_number' AND expense_type = 'Room Rent' AND check_out_status = 0 AND hotel_id = '$hotel_id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }
  public function getBookingAmountByRoomNumber($room_number, $hotel_id)
  {
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    $query_list = "SELECT amount FROM day_book_entry WHERE expense_by = '$room_number' AND expense_type = 'Room Rent' AND check_out_status = 0 AND hotel_id = '$hotel_id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getSummaryDetailById($id)
  {
    $this->id = $id;
    $query_list = "SELECT * FROM summary_details WHERE checkin_id = '$id'  ORDER BY summary_id DESC";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResults($execute_query);
    return $result;
  }

  public function getAdvanceAmountById($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query_ch = "SELECT room_number FROM check_in_details WHERE checkin_id ='$id' AND status = 0 AND hotel_id = '$hotel_id'";
    $query_ex = $this->db->execute($query_ch);
    $result = $this->db->getResult($query_ex);
    $room_number = $result['room_number'];


    $query_list = "SELECT * FROM day_book_entry WHERE expense_by = '$room_number' AND expense_type = 'Room Advance'  ORDER BY day_b_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getAdvanceAmountByRoomNumber($room_number)
  {
    $this->room_number = $room_number;
    $query_list = "SELECT * FROM day_book_entry WHERE expense_by = '$room_number' AND expense_type = 'Room Advance'  ORDER BY day_b_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }


  public function getSummaryDetailByRoom($room_number, $hotel_id)
  {
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    $query_ch = "SELECT checkin_id FROM check_in_details WHERE room_number ='$room_number' AND status = 0 AND hotel_id = '$hotel_id'";
    $query_ex = $this->db->execute($query_ch);
    $result = $this->db->getResult($query_ex);
    $checkin_id = $result['checkin_id'];


    $query_list = "SELECT * FROM summary_details WHERE checkin_id = '$checkin_id' AND status=0 ORDER BY summary_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getHotelDetailsById($id)
  {
    $this->id = $id;
    $query_list = "SELECT * FROM hotels WHERE hotel_id = '$id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getAllHotelDetails()
  {
    $query_list = "SELECT * FROM hotels WHERE status = 0 ORDER BY hotel_id DESC ";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getTouristNameById($id)
  {
    $this->id = $id;
    $query_name = "SELECT * FROM echeckin_person_name WHERE checkin_id = '$id' LIMIT 1";
    $execute_query_n = $this->db->execute($query_name);
    $result = $this->db->getResult($execute_query_n);
    return $result;
  }

  public function getCheckinPersonById($id, $checkin_date)
  {
    $this->id = $id;
    $this->checkin_date = $checkin_date;
    $query_name = "SELECT * FROM echeckin_person_name WHERE checkin_id = '$id' AND checkin_date = '$checkin_date'";
    $execute_query_n = $this->db->execute($query_name);
    $results = $this->db->getResults($execute_query_n);
    return $results;
  }

  public function getCheckinIdsById($id)
  {
    $this->id = $id;
    //$this->checkin_date = $checkin_date;
    $query_name = "SELECT * FROM guest_ids WHERE checkin_id = '$id'";
    $execute_query_n = $this->db->execute($query_name);
    $results = $this->db->getResults($execute_query_n);
    return $results;
  }

  public function getRoomDetails($id)
  {
    $this->id = $id;
    $ground_query = $this->db->execute("SELECT * FROM room_details WHERE hotel_id='$id'");
    $results = $this->db->getResults($ground_query);
    $ground_floor = [];
    $first_floor = [];
    $second_floor = [];
    $third_floor = [];
    $fourth_floor = [];
    foreach ($results as $key => $value) {
      if ($value['floor'] == 0) {
        array_push($ground_floor, $value);
      } else if ($value['floor'] == 1) {
        array_push($first_floor, $value);
      } else if ($value['floor'] == 2) {
        array_push($second_floor, $value);
      } else if ($value['floor'] == 3) {
        array_push($third_floor, $value);
      } else if ($value['floor'] == 4) {
        array_push($fourth_floor, $value);
      }
    }
    return [$ground_floor, $first_floor, $second_floor, $third_floor, $fourth_floor];
  }

  public function getGroundFloorRoom($id)
  {
    $this->id = $id;
    $ground_query = $this->db->execute("SELECT * FROM room_details WHERE floor=0 AND hotel_id='$id'");
    $results = $this->db->getResults($ground_query);
    return $results;
  }

  public function getFirstFloorRoom($id)
  {
    $this->id = $id;
    $first_query = $this->db->execute("SELECT * FROM room_details WHERE floor=1 AND hotel_id='$id'");
    $results = $this->db->getResults($first_query);
    return $results;
  }
  public function getFirstSecondRoom($id)
  {
    $this->id = $id;
    $second_query = $this->db->execute("SELECT * FROM room_details WHERE floor=2 AND hotel_id='$id'");
    $results = $this->db->getResults($second_query);
    return $results;
  }

  public function getFirstThirdRoom($id)
  {
    $this->id = $id;
    $third_query = $this->db->execute("SELECT * FROM room_details WHERE floor=3 AND hotel_id='$id'");
    $results = $this->db->getResults($third_query);
    return $results;
  }

  public function getFirstFounthRoom($id)
  {
    $this->id = $id;
    $third_query = $this->db->execute("SELECT * FROM room_details WHERE floor=4 AND hotel_id='$id'");
    $results = $this->db->getResults($third_query);
    return $results;
  }
  //test
  public function getRoomGuestDetails($room_number, $id)
  {
    $this->room_number = $room_number;
    $this->id = $id;
    $guest_query = "SELECT cid.*, gi.id_proof, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN guest_ids gi ON cid.checkin_id = gi.checkin_id LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.hotel_id = '$id' AND cid.room_number = '$room_number' AND cid.status = 0";
    $guest_details = $this->db->execute($guest_query);
    $result = $this->db->getResult($guest_details);
    return $result;
  }



  //update table

  public function updateRoomStatus($room_status, $room_number, $hotel_id)
  {
    $this->room_status = $room_status;
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    $query_status = $this->db->execute("UPDATE room_details SET room_status = '$room_status' WHERE room_number = '$room_number' AND hotel_id = '$hotel_id'");
    return "success";
  }

  public function updateCheckoutFinal($id, $room_number, $hotel_id)
  {
    $this->id = $id;
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    $nextlocation = $_SESSION['nextlocation'];
    $current_co_date = CURR_DATE1;
    $checkout_by = $_SESSION['checkout_by'];


    $current_date_time = DATE_TIME;

    $this->db->execute("UPDATE check_in_details SET next_location = '$nextlocation', final_checkout_date='$current_date_time',status=1, checkout_by = '$checkout_by', current_co_date='$current_co_date' WHERE checkin_id = '$id' AND hotel_id = '$hotel_id'");

    if ($this->db->affectedRows() >= 0) {

      $this->db->execute("UPDATE room_details SET room_status = 'cleaning' WHERE room_number = '$room_number' AND hotel_id = '$hotel_id'");

      //make a backup of checkin history

      $this->db->execute("INSERT INTO guest_checkin_history(`checkin_id`, `hotel_id`, `serial_number`, `name`, `gender`, `son_of`, `email`, `phone`, `country`, `state`, `pincode`, `date_of_birth`, `id_name`, `id_number`, `last_location`, `next_location`, `purpouse`, `address`, `arrival_date`, `arrival_location`, `passport_number`, `pass_expiry_date`, `visa_number`, `visa_expiry_date`, `booking_via`, `booking_id`, `checkin_date`, `checkout_date`, `final_checkout_date`, `booking_nights`, `extended_days`, `room_number`, `no_of_person`, `booking_amount`, `charge_per_adult`, `hotel_tax`, `hotel_gross_charge`, `commission`, `gst_18`, `commission_gst`, `pay_to_hotel`, `meal_plan`, `status`, `checkout_by`, `inserted_by`, `logedin_users`, `inserted_date`, `current_ci_date`, `current_co_date`, `transfer_date`) SELECT * FROM check_in_details WHERE checkin_id = '$id' AND hotel_id = '$hotel_id'");


      $this->db->execute("UPDATE extended_booking_days SET status=1 WHERE checkin_id = '$id' AND hotel_id = '$hotel_id'");

      $this->db->execute("UPDATE day_book_entry SET check_out_status = 1 WHERE expense_by = '$room_number' AND hotel_id = '$hotel_id' AND summary_id = 1");

      return "success";
    } else {

      return "error";
    }
  }
  public function getCheckedoutValueForRecheckin($id)
  {
    $this->id = $id;
    $checked_query = $this->db->execute("SELECT * FROM check_in_details WHERE checkin_id = '$id' AND status = 1");
    $result = $this->db->getResult($checked_query);
    return $result;
  }

  public function getRoomSummary($id)
  {
    $this->id = $id;
    $view_summary = $this->db->execute("SELECT sd.*, cid.name, cid.checkin_date, cid.booking_id FROM summary_details sd LEFT JOIN check_in_details cid ON sd.checkin_id = cid.checkin_id WHERE sd.checkin_id = '$id'");
    $result = $this->db->getResult($view_summary);
    return $result;
  }

  public function getViewExtendedCheckinDays($checkin_id, $hotel_id)
  {
    $this->checkin_id = $checkin_id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM `extended_booking_days` WHERE checkin_id = '$checkin_id' AND status = 0 AND hotel_id = '$hotel_id'";
    $view_extend = $this->db->execute($query);
    $results = $this->db->getResults($view_extend);
    return $results;
  }

  public function roomTranserferProcess($checkin_id, $room_number, $hotel_id)
  {
    $this->checkin_id = $checkin_id;
    $this->room_number = $room_number;
    $this->hotel_id = $hotel_id;
    if (!empty($room_number)) {
      $validate_query = $this->db->execute("SELECT room_number FROM room_details WHERE room_number = $room_number AND room_status = 'empty' AND hotel_id = '$hotel_id'");
      $room_no_validate = $this->db->rowCount($validate_query);
      if ($room_no_validate > 0) {
        $query_room = $this->db->execute("SELECT room_number FROM check_in_details WHERE checkin_id='$checkin_id' AND status=0 AND hotel_id = '$hotel_id'");
        $resutl = $this->db->getResult($query_room);
        $old_room_number = $resutl['room_number'];

        $this->db->execute("UPDATE room_details SET room_status = 'cleaning' WHERE room_number ='$old_room_number' AND room_status ='booked' AND hotel_id = '$hotel_id'");
        $che_query = $this->db->execute("UPDATE check_in_details SET room_number = '$room_number', transfer_date = NOW() WHERE checkin_id = '$checkin_id' AND status = 0 AND room_number='$old_room_number' AND hotel_id = '$hotel_id'");
        $che_query = $this->db->execute("UPDATE guest_checkin_history SET room_number = '$room_number', transfer_date = NOW() WHERE checkin_id = '$checkin_id' AND status = 0 AND room_number='$old_room_number' AND hotel_id = '$hotel_id'");

        $msg = $this->db->execute("UPDATE room_details SET room_status = 'booked' WHERE room_number ='$room_number' AND room_status = 'empty' AND hotel_id = '$hotel_id'");

        if ($this->db->affectedRows($msg)) {
          return 0;
        } else {
          return 1;
        }
      } else {
        return 3;
      }
    } else {
      return 2;
    }
  }

  public function getViewAllGuestName($checkin_id, $checkin_date)
  {
    $this->checkin_id = $checkin_id;
    $this->checkin_date = $checkin_date;
    if (!empty($checkin_id) && !empty($checkin_date)) {
      $name_query = "SELECT * FROM echeckin_person_name WHERE checkin_id='$checkin_id' AND checkin_date ='$checkin_date'";
      $exe_query = $this->db->execute($name_query);
      $results = $this->db->getResults($exe_query);
      return $results;
    }
  }

  public function getDataForRecheckin($id)
  {
    $this->id = $id;
    $query = "SELECT * FROM check_in_details WHERE checkin_id = '$id'";
    $execute_query = $this->db->execute($query);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  //izhar
  public function getArrivalBookingListById($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT abh.*, bv.category_name as compnay_name FROM arrival_booking_history abh LEFT JOIN booking_via bv ON abh.booking_via = bv.booking_via_id WHERE abh.arrival_b_id = '$id' AND hotel_id = '$hotel_id'";
    $execute_query = $this->db->execute($query);
    $results = $this->db->getResult($execute_query);
    return $results;
  }

  public function getExpensesCategories()
  {
    $query = "SELECT *  FROM expence_category WHERE status=0 ORDER BY exp_cat_id DESC";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }

  public function getToatalDayBookEntryList($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    $date1 = CURR_DATE1;
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$id' AND date_of_expense = '$date1'  AND summary_id != 1 ORDER BY expense_type DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results1 = $this->db->getResults($execute_query);

    $query_list1 = "SELECT * FROM day_book_entry WHERE hotel_id = '$id' AND check_out_status = 1 AND date_of_expense = '$date1' ";
    $execute_query1 = $this->db->execute($query_list1);
    $results2 = $this->db->getResults($execute_query1);

    $results = array_merge($results1, $results2);
    return $results;
  }

  public function getClosingBalance($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $date1 = CURR_DATE1;
    $query_list = "SELECT closing_balance FROM closing_balance_table WHERE hotel_id = '$hotel_id' AND closing_date < '$date1' ORDER BY closing_date DESC LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getClosingBalanceDateWise($hotel_id, $start_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $query_list = "SELECT closing_balance FROM closing_balance_table WHERE hotel_id = '$hotel_id' AND closing_date < '$date1' ORDER BY closing_date DESC LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    $result = $this->db->getResult($execute_query);
    return $result;
  }

  public function getDayBookEntryByDepartment($hotel_id, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->dept = $dept;
    $date1 = CURR_DATE1;
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND department = '$dept' AND date_of_expense = '$date1' ORDER BY expense_type DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getDayBookEntryByStartDate($hotel_id, $start_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense = '$date1' ORDER BY expense_type DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getDayBookEntryByDateToDate($hotel_id, $start_date, $end_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->end_date = $end_date;
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense >= '$date1' AND date_of_expense <= '$date2' ORDER BY expense_type DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getDayBookEntryByDepartmentAndDate($hotel_id, $start_date, $end_date, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->end_date = $end_date;
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    $this->dept = $dept;
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense >= '$date1' AND date_of_expense <= '$date2' AND department = '$dept' ORDER BY expense_type DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getDayBookEntryByDepartmentAndStartDate($hotel_id, $start_date, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->dept = $dept;
    $query_list = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense = '$date1' AND department = '$dept' ORDER BY expense_type DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function updateClosingBalance($hotel_id, $c_balance)
  {
    $this->hotel_id = $hotel_id;
    $this->c_balance = $c_balance;
    $cr_date = CURR_DATE1;
    $query = "SELECT * FROM closing_balance_table WHERE hotel_id = '$hotel_id' AND closing_date = '$cr_date'";
    $exe = $this->db->execute($query);
    $result = $this->db->getResult($exe);
    if ($result > 0) {
      $query_up = "UPDATE closing_balance_table SET closing_balance = '$c_balance' WHERE hotel_id = '$hotel_id' AND closing_date = '$cr_date'";
      $exe_up = $this->db->execute($query_up);
    } else {
      $query_in = "INSERT INTO closing_balance_table( `hotel_id`, `closing_balance`, `closing_date`) VALUES('$hotel_id','$c_balance','$cr_date')";
      $exe_in = $this->db->execute($query_in);
    }
    //For daybook entry table

    $cr_date = CURR_DATE1;
    $tomorrow = date('Y-m-d', strtotime($cr_date . '+1 days'));

    $cr_date_time = DATE_TIME;
    $tomorrow_d_time = date('Y-m-d H:i:s', strtotime($cr_date_time . '+1 days'));

    $query = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense = '$tomorrow' AND expense_type = 'Cash balance'";
    $exe = $this->db->execute($query);
    $result = $this->db->getResult($exe);
    if ($result > 0) {
      $query_up = "UPDATE day_book_entry SET amount = '$c_balance' WHERE hotel_id = '$hotel_id' AND date_of_expense = '$tomorrow' AND expense_type = 'Cash balance'";
      $exe_up = $this->db->execute($query_up);
    } else {
      $query_in = "INSERT INTO day_book_entry( `hotel_id`, `expense_type`, `receive_pay`, `amount`, `department`, `date_of_expense`, `inserted_date`)
      VALUES('$hotel_id','Cash balance','Receive','$c_balance','Hotel','$tomorrow', '$tomorrow_d_time')";
      $exe_in = $this->db->execute($query_in);
    }
  }
  public function getDayBookEntryForUpdate($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM day_book_entry WHERE hotel_id = '$hotel_id' AND day_b_id = '$id'";
    $execute = $this->db->execute($query);
    $result = $this->db->getResult($execute);
    return $result;
  }
  public function getExtendedBookingDetails($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT checkout_date as c_date FROM extended_booking_days WHERE hotel_id = '$hotel_id' AND checkin_id = '$id' AND status = 0 ORDER BY ex_booking_id DESC LIMIT 1";
    $execute = $this->db->execute($query);
    $results = $this->db->getResult($execute);
    return $results;
  }

  public function getAllGuestName($id)
  {
    $this->id = $id;
    $query = "SELECT name FROM echeckin_person_name WHERE checkin_id = '$id' LIMIT 1";
    $execute = $this->db->execute($query);
    $results = $this->db->getResult($execute);
    return $results;
  }

  // public function getAllGuestNameByCheckinDateAndId($id)
  // {
  //   $this->id = $id;
  //   $this->checkin_date = $checkin_date;
  //   $query = "SELECT name FROM echeckin_person_name_history WHERE checkin_id = '$id' AND checkin_date = '$checkin_date'";
  //   $execute = $this->db->execute($query);
  //   return $this->db->getResults($execute);
  // }

  public function getRoomStatus($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query = "SELECT  room_status, COUNT(*) as room_status_count FROM room_details WHERE hotel_id = '$hotel_id' GROUP BY  room_status ";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }


  public function getNumberOfBookedRoom($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM room_details WHERE room_status = 'booked' AND hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->rowCount($execute);
    return $results;
  }

  public function getNumberOfEmptyRoom($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM room_details WHERE room_status = 'empty' AND hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->rowCount($execute);
    return $results;
  }

  public function getNumberOfCleaningRoom($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM room_details WHERE room_status = 'cleaning' AND hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->rowCount($execute);
    return $results;
  }

  public function getHotels()
  {
    $query = "SELECT * FROM hotels WHERE status = 0";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }

  public function getTodayArrivalBooking($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $date = CURR_DATE;
    $query = "SELECT abh.*, bv.category_name as compnay_name FROM arrival_booking_history abh LEFT JOIN booking_via bv ON abh.booking_via = bv.booking_via_id WHERE abh.checkin_date = '$date' AND abh.booking_status = 'confirmed' AND abh.hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }

  public function getYesterdayArrivalBooking($hotel_id)
  {

    $this->hotel_id = $hotel_id;
    $date = new DateTime('-1 day');
    $date1 = $date->format('d/m/Y');
    $query = "SELECT abh.*, bv.category_name as compnay_name FROM arrival_booking_history abh LEFT JOIN booking_via bv ON abh.booking_via = bv.booking_via_id WHERE abh.checkin_date = '$date1' AND abh.booking_status = 'confirmed' AND abh.hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }


  public function getTomorrowArrivalBooking($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $date = new DateTime('+1 day');
    $date1 = $date->format('d/m/Y');
    $query = "SELECT abh.*, bv.category_name as compnay_name FROM arrival_booking_history abh LEFT JOIN booking_via bv ON abh.booking_via = bv.booking_via_id WHERE abh.checkin_date = '$date1' AND abh.booking_status = 'confirmed' AND abh.hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }
  public function getTodayCheckedin($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $date = CURR_DATE;
    $query = "SELECT cid.*, bv.category_name as compnay_name FROM check_in_details cid LEFT JOIN booking_via bv ON cid.booking_via = bv.booking_via_id WHERE cid.status = 0 AND cid.final_checkout_date ='0000-00-00 00:00:00' AND cid.hotel_id = '$hotel_id'  ORDER BY cid.room_number ASC";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }
  public function getAllGuestNameByCheckinId($checkin_id, $checkin_date)
  {
    $this->checkin_id = $checkin_id;
    $this->checkin_date = $checkin_date;
    $query = $this->db->execute("SELECT * FROM echeckin_person_name WHERE checkin_id = '$checkin_id' AND checkin_date = '$checkin_date'");
    return $this->db->getResults($query);
  }

  public function getExtendedDateByCheckinId($checkin_id, $hotel_id)
  {
    $this->checkin_id = $checkin_id;
    $this->hotel_id = $hotel_id;

    $query = $this->db->execute("SELECT * FROM extended_booking_days WHERE checkin_id = '$checkin_id' AND hotel_id = '$hotel_id' AND status = 0 ORDER BY ex_booking_id DESC LIMIT 1");
    return $this->db->getResult($query);
  }

  public function getToatalEmployeesDetails($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$id' AND status = 0 ORDER BY employee_id ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getToatalInactiveEmployeesDetails($setLimit, $pageLimit, $id)
  {
    $this->id = $id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$id' AND status = 1 ORDER BY employee_id ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }
  public function getEmployeeDetailsForUpdate($id, $hotel_id)
  {
    $this->id = $id;
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND employee_id = '$id'";
    $execute = $this->db->execute($query);
    $result = $this->db->getResult($execute);
    return $result;
  }

  //employees
  public function getEmpDetailsByDepartment($hotel_id, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->dept = $dept;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND department = '$dept' ORDER BY employee_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getEmpDetailsByStartDate($hotel_id, $start_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND date_of_join = '$date1' ORDER BY employee_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getEmpDetailsByDateToDate($hotel_id, $start_date, $end_date)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->end_date = $end_date;
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND date_of_join >= '$date1' AND date_of_join <= '$date2' ORDER BY employee_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getEmpDetailsByDepartmentAndDate($hotel_id, $start_date, $end_date, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->end_date = $end_date;
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));
    $this->dept = $dept;
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND date_of_join >= '$date1' AND date_of_join <= '$date2' AND department = '$dept' ORDER BY employee_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getEmpDetailsByDepartmentAndStartDate($hotel_id, $start_date, $dept)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $this->dept = $dept;
    $query_list = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' AND date_of_join = '$date1' AND department = '$dept' ORDER BY employee_id DESC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getEmployeeDetails($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $query = "SELECT * FROM employees WHERE hotel_id = '$hotel_id' LIMIT 10";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }

  public function getEmployeesIds($id, $hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $this->id = $id;
    $query = "SELECT * FROM employee_ids WHERE employee_id = '$id' AND hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $results = $this->db->getResults($execute);
    return $results;
  }
  public function sendSoldOutAlertEmail($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $sold_query = "SELECT * FROM room_details WHERE  room_status IN('empty','cleaning') AND hotel_id ='$hotel_id' AND status = 0";
    $sold_exe = $this->db->execute($sold_query);
    $room_count = $this->db->rowCount($sold_exe);
    //return $room_count;
    $checkin_date = CURR_DATE;
    $curre_date =  CURR_DATE1;
    $arriv_query = $this->db->execute("SELECT * FROM arrival_booking_history WHERE hotel_id = '$hotel_id' AND status= 0 AND booking_status = 'confirmed' AND checkin_date = '$checkin_date'");
    $arr_count = $this->db->rowCount($arriv_query);

    $hotel_query = $this->db->execute("SELECT hotel_name FROM hotels WHERE status = 0 AND hotel_id ='$hotel_id'");
    $result = $this->db->getResult($hotel_query);
    $hotel_name = $result['hotel_name'];

    if ($arr_count >= $room_count) {

      $subject = "Room Sold Out.";

      // HTML email starts here

      $message  = "<html><body>";

      $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

      $message .= "<tr><td>";

      $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

      $message .= "<tbody>

                  <tr align='center' height='50' style='font-family:Verdana, Geneva, sans-serif;'>

                    <td style='background-color:#035CA7; text-align:center;'>

                      <a href='http://www.admin.checkinroom.com/room_view.php' target='_blank' style='color:#fff; text-decoration:none;'><h4>admin.checkinroom.com</h4></a>
                    </td>
                  </tr>
                  <tr>
                    <td colspan='4' style='padding:15px;'>

                      <p style='font-size:20px;'>Hi </p>

                      <p style='margin-left:50px;font-size:15px; font-family:Verdana, Geneva, sans-serif;'>$hotel_name is sold out.</p>
                   </td>
                  </tr>
                </tbody>";

      $message .= "</table>";

      $message .= "</td></tr>";

      $message .= "</table>";

      $message .= "</body></html>";

      $mail = new PHPMailer();

      $mail->IsSMTP();

      $mail->isHTML(true);

      $mail->Host = "www.admin.checkinroom.com";  // Specify main and backup server

      $mail->From = "booking@admin.checkinroom.com";

      $mail->FromName = "Check in rooms";
      $mail->addAddress('guddukmr786@gmail.com');
      /*$mail->addAddress('reservation@budgettravelindia.com');*/

      //$mail->addBCC('booking@hotelshelton.in');
      /*if($hotel_id = 1){
        $mail->addBCC('booking@hotelnirmalmahal.com');
      }
      if($hotel_id = 2){
        $mail->addBCC('booking@hotelallizwell.in');
      }
      if($hotel_id = 3){
        $mail->addBCC('booking@hotelshelton.in');
      }
      if($hotel_id = 6){
        $mail->addBCC('booking@arjunhotel.com');
      }
      if($hotel_id = 7){
        $mail->addBCC('booking@hotelprincepalacedx.com');
      }
      if($hotel_id = 8){
        $mail->addBCC('booking@hotelcabanadelhi.com');
      }*/

      $mail->Subject = $subject;

      $mail->Body = $message;

      $mail->AltBody = '';

      if ($mail->send()) {
        $aa = "INSERT INTO alert(hotel_id, curre_date , message) VALUES('$hotel_id','$curre_date','yes')";

        $this->db->execute($aa);
      }
    }
  }

  public function getAlertMessage($hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $curre_date =  CURR_DATE1;
    $query = "SELECT message FROM alert WHERE curre_date = '$curre_date' AND hotel_id = '$hotel_id'";
    $execute = $this->db->execute($query);
    $result = $this->db->getResult($execute);
    return $result;
  }


  public function getTravelId($id)

  {

    $this->id = $id;

    $query = "SELECT * FROM travel_details WHERE id = '$id' LIMIT 1";

    $execute = $this->db->execute($query);

    $result = $this->db->getResult($execute);

    return $result;
  }


  public function getTransferedBookingHotelName($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT transfer_to FROM arrival_booking_history WHERE booking_id = '$id' AND booking_status = 'transfered'");
    $result = $this->db->getResult($query);

    $h_id = $result['transfer_to'];
    //echo "SELECT hotel_name FROM hotels WHERE hotel_id = '$id'";die;
    $query_ho = $this->db->execute("SELECT hotel_name FROM hotels WHERE hotel_id = '$h_id'");
    return $this->db->getResult($query_ho);
  }

  public function getTransferedBookingCheckinDetails($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT * FROM check_in_details WHERE booking_id = '$id' LIMIT 1");
    return $this->db->getResult($query);
  }


  public function getAllDates()
  {
    $query = $this->db->execute("SELECT checkin_id, hotel_id, checkin_date, checkout_date FROM check_in_details");
    return $this->db->getResults($query);
  }

  public function hotel_id($id, $checkin_date, $end_date)
  {
    $this->db->execute("UPDATE check_in_details SET checkin_date ='$checkin_date', checkout_date ='$end_date' WHERE checkin_id = '$id'");
  }


  public function unsetEntryFormSession()
  {
    //unset($_SESSION['checkin_id']);
    unset($_SESSION['checkin_date']);
    unset($_SESSION['checkout_date']);
    unset($_SESSION['booking_nights']);
    unset($_SESSION['nametitle']);

    unset($_SESSION['fname']);

    unset($_SESSION['gender']);
    unset($_SESSION['no_gender']);
    if (isset($_SESSION['relation'])) {

      unset($_SESSION['relation']);
    }

    unset($_SESSION['email']);

    unset($_SESSION['phone']);

    unset($_SESSION['fkcountry']);

    unset($_SESSION['city']);

    if (isset($_SESSION['pin'])) {

      unset($_SESSION['pin']);
    }

    unset($_SESSION['day']);

    unset($_SESSION['month']);

    unset($_SESSION['year']);

    unset($_SESSION['idname']);

    unset($_SESSION['idno']);

    if (isset($_SESSION['lastlocation'])) {

      unset($_SESSION['lastlocation']);
    }

    if (isset($_SESSION['nextlocation'])) {
      unset($_SESSION['nextlocation']);
    }

    unset($_SESSION['purpose']);
    if (isset($_SESSION['ids'])) {
      unset($_SESSION['ids']);
      unset($_SESSION['tmpids']);
    }
    unset($_SESSION['address']);
    if (isset($_SESSION['arrival_date'])) {
      unset($_SESSION['arrival_date']);
    }
    if (isset($_SESSION['arrlocation'])) {
      unset($_SESSION['arrlocation']);
    }
    if (isset($_SESSION['passport'])) {
      unset($_SESSION['passport']);
    }
    if (isset($_SESSION['passportexp'])) {
      unset($_SESSION['passportexp']);
    }

    if (isset($_SESSION['visa'])) {
      unset($_SESSION['visa']);
    }

    if (isset($_SESSION['visa_valid'])) {
      unset($_SESSION['visa_valid']);
    }
    unset($_SESSION['booking_via']);
    unset($_SESSION['bookingid']);
    unset($_SESSION['checkin']);
    unset($_SESSION['checkout']);
    unset($_SESSION['nights']);
    unset($_SESSION['roomno']);
    unset($_SESSION['adult']);
    unset($_SESSION['child']);
    unset($_SESSION['b_amount']);
    if (isset($_SESSION['ex_ad_charges'])) {
      unset($_SESSION['ex_ad_charges']);
    }
    unset($_SESSION['meal_plan']);

    //arrival form 
    if (isset($_SESSION['name'])) {
      unset($_SESSION['name']);
    }
    if (isset($_SESSION['category'])) {
      unset($_SESSION['category']);
    }
    if (isset($_SESSION['mode'])) {
      unset($_SESSION['mode']);
    }
    if (isset($_SESSION['company'])) {
      unset($_SESSION['company']);
    }
    if (isset($_SESSION['pickup'])) {
      unset($_SESSION['pickup']);
    }
    if (isset($_SESSION['flight'])) {
      unset($_SESSION['flight']);
    }
    if (isset($_SESSION['noofguest'])) {
      unset($_SESSION['noofguest']);
    }
    if (isset($_SESSION['noofroom'])) {
      unset($_SESSION['noofroom']);
    }
  }

  public function getToatalUsersDetails($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM admin_login WHERE status = 0 AND user_name != 'blackhat007' AND user_name!='xxx' ORDER BY name ASC LIMIT " . $pageLimit . " , " . $setLimit;

    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }


  public function getToatalInactiveUsersDetails($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM admin_login WHERE status = 1 AND user_name != 'blackhat007' ORDER BY name ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getToatalHotelsDetails($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM hotels WHERE status = 0 ORDER BY hotel_name ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }
  public function getToatalInactiveHotelsDetails($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    //$date1 = CURR_DATE1;
    $query_list = "SELECT * FROM hotels WHERE status = 1 ORDER BY hotel_name ASC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }



  public function getUserDetailsForUpdate($id)
  {
    $this->id = $id;
    $query_list = "SELECT * FROM admin_login WHERE admin_id ='$id' LIMIT 1";
    $execute_query = $this->db->execute($query_list);
    return $this->db->getResult($execute_query);
  }


  public function downloadDayBookEntryDateWise($hotel_id, $start_date, $end_date, $depart)
  {
    $this->hotel_id = $hotel_id;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->depart = $depart;
    $ddd1 = str_replace('/', '-', $start_date);
    $date1 = date('Y-m-d', strtotime($ddd1));
    $ddd2 = str_replace('/', '-', $end_date);
    $date2 = date('Y-m-d', strtotime($ddd2));


    $query = "SELECT db.*, h.hotel_name FROM day_book_entry db LEFT JOIN hotels h ON db.hotel_id = h.hotel_id WHERE db.date_of_expense >='$date1' AND db.date_of_expense <= '$date2' AND db.hotel_id ='$hotel_id'";

    if (!empty($depart)) {
      $query .= " AND db.department='$depart'";
    }
    $query .= " ORDER BY db.date_of_expense ASC";

    $execute_query = $this->db->execute($query);
    $results = $this->db->getResults($execute_query);
    return $results;
  }

  public function getGeneratedInvoice($setLimit, $pageLimit, $hotel_id)
  {
    $this->hotel_id = $hotel_id;
    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    $query_list = "SELECT * FROM invoice_details WHERE hotel_id = '$hotel_id' ORDER BY gstin, inserted_date DESC LIMIT " . $pageLimit . " , " . $setLimit;
    //echo $query_list;die;
    $execute_query = $this->db->execute($query_list);
    return $this->db->getResults($execute_query);
  }

  public function getDataOfBookingDescription($travel_id)
  {
    $this->travel_id = $travel_id;
    $query_day = $this->db->execute("SELECT * FROM invoice_desc WHERE travel_id = '$travel_id' LIMIT 1");
    return $this->db->getResult($query_day);
  }

  public function getGeneratedInvoiceValueById($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT * FROM invoice_details WHERE travel_id = '$id' LIMIT 1");
    return $this->db->getResult($query);
  }

  public function getDateDayById($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT sn, description, checkin_date, checkout_date, hsn_code, qty, unit, price, amount FROM invoice_desc WHERE travel_id ='$id'");
    return $this->db->getResults($query);
  }



  public function getPartyDetails()
  {
    $query_list = "SELECT * FROM booking_via ORDER BY booking_via_id ASC";
    $execute_query = $this->db->execute($query_list);
    $results = $this->db->getResults($execute_query);
    return $results;
  }



  public function getPartyDetailsForUpdate($id)
  {

    $this->id = $id;

    $query = "SELECT * FROM booking_via WHERE booking_via_id = '$id' LIMIT 1";

    $execute = $this->db->execute($query);

    $result = $this->db->getResult($execute);

    return $result;
  }

  public function getLastIdOfInvoiceDescTable()
  {

    $query = $this->db->execute("SELECT travel_id FROM invoice_details ORDER BY travel_id DESC LIMIT 1");
    return $this->db->getResult($query);
  }


  public function getGeneratedInvoiceOfSushantTravels($setLimit, $pageLimit)
  {

    $this->setLimit = $setLimit;
    $this->pageLimit = $pageLimit;
    $query_list = "SELECT * FROM invoice_sushant_travels ORDER BY s_invoice_id DESC LIMIT " . $pageLimit . " , " . $setLimit;
    $execute_query = $this->db->execute($query_list);
    return $this->db->getResults($execute_query);
  }

  public function getDataOfBookingDescriptionOfSushantTravels($s_invoice_id)
  {
    $this->s_invoice_id = $s_invoice_id;
    $query_day = $this->db->execute("SELECT * FROM invoice_desc_sushant WHERE s_invoice_id = '$s_invoice_id' LIMIT 1");
    return $this->db->getResult($query_day);
  }

  public function getGeneratedInvoiceValueOfSushantTravelsById($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT * FROM invoice_sushant_travels WHERE s_invoice_id = '$id' LIMIT 1");
    return $this->db->getResult($query);
  }

  public function getDateDayOfSushantTravelsById($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT  days, description, hsn_code, amount, sn FROM invoice_desc_sushant WHERE s_invoice_id ='$id'");
    return $this->db->getResults($query);
  }

  public function getCirHotelDetailsForUpdate($id)
  {
    $this->id = $id;
    $query = $this->db->execute("SELECT * FROM hotels WHERE hotel_id = '$id'");
    return $this->db->getResult($query);
  }

  public function getExtendedBookingAmountByCheckinID($id)
  {

    $this->id = $id;
    $query = $this->db->execute("SELECT SUM(booking_amount) as sum_ext_amount FROM extended_booking_days WHERE checkin_id = '$id'");
    return $this->db->getResult($query);
  }

  public function getCompanyName($party_id)
  {

    $this->party_id = $party_id;
    $query = $this->db->execute("SELECT name FROM party_details WHERE party_id = '$party_id' LIMIT 1");
    return $this->db->getResult($query);
  }
}