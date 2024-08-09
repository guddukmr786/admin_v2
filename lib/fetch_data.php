<?php 
require_once '../include/config.php';
class FetchData
{
	private $db;
	private $id;
	function __construct()
	{
		$this->db = new Database();
	}
	public function getCountries(){
		$countries = $this->db->execute("SELECT DISTINCT country_name FROM country_states ORDER BY country_name ASC");
		$results = $this->db->getResults($countries);
		return $results;
	}

}
?>