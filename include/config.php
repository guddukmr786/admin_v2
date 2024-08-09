<?php

ini_set("session.use_trans_sid", 0);
ini_set("session.use_only_cookies", 1);
ini_set('session.gc_maxlifetime', 43200);
session_set_cookie_params(43200);
session_start();
class Database {
	private $folder_name;
	private $host_name;
	private $user_name;
	private $password;
	private $db_name;
	private $con;
	private $result;
	function __construct() {
	
		if($_SERVER['HTTP_HOST'] == 'localhost'){

			$this->folder_name = '/cir/';
			$this->host_name = "127.0.0.1";
			$this->user_name = "root";
			$this->password = "";
			$this->db_name = "checklmo_cir_admin";

		}else{

			$this->folder_name = "/";
			$this->host_name = "localhost";
			$this->user_name = "checklmo_cir_adm";
			$this->password = "MPi})I5Ic!m3";
			$this->db_name ="checklmo_cir_admin";

		}

		$this->con = mysqli_connect($this->host_name, $this->user_name, $this->password, $this->db_name)
		or die("Couldn't connect to the database".mysqli_error());

	}

	public function execute($query){
		$this->result = mysqli_query( $this->con, $query );

	}



	public function getResult(){
		return mysqli_fetch_assoc($this->result);

	}



	public function getResults(){
		$return = array();
		while ($row = mysqli_fetch_assoc($this->result)) {
			$return[]=$row;
		}
		return $return;
	}



	public function rowCount(){
		return mysqli_num_rows($this->result);
	}



	public function LastId() {
		return mysqli_insert_id($this->con);
	}



	public function affectedRows(){
		return mysqli_affected_rows($this->con);
	}

	public function realEscape($value){
		return  mysqli_real_escape_string($this->con, $value);
	}
	
} 

if($_SERVER["HTTP_HOST"]=="192.168.1.194"){

	$folder_name='/cir/';

} else {

	$folder_name='/';

}

$root = 'http//'.$_SERVER['HTTP_HOST'].$folder_name;

$doc_root =$_SERVER['DOCUMENT_ROOT'].$folder_name;

$css_root = $root. 'css/';

$script_root=$root.'js/';

$lib_root = $root.'lib/';

$include_root = $root.'include/';

$images_root = $root.'images/';



date_default_timezone_set('Asia/Calcutta');


$date=date('d/m/Y');
$date1=date('Y-m-d');
$date_time=date('Y-m-d H:i:s');
$date_time1=date('d-m-Y H:i:s');

$modified_date=date('d-M-Y, D');



$site_title="Travel | Leader";



define("WEB_ROOT",$root);

define("DOC_ROOT",$doc_root);

define("CURR_DATE",$date);

define("CURR_DATE1",$date1);
define("DATE_TIME",$date_time);
define("DATE_TIME1",$date_time1);

define("MODIFIED_DATE",$modified_date);

define("CSS_ROOT",$css_root);

define("LIB_ROOT",$lib_root);

define("INCLUDE_ROOT",$include_root);

define("SCRIPT_ROOT",$script_root);

define("IMAGES_ROOT",$images_root);

define("SITE_TITLE",$site_title);



?>