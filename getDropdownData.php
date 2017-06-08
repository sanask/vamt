<?php 
include ('inc/includes.php');
//include('connection.php');

if(isset($_REQUEST["locid"]) && $_REQUEST["locid"] != "")
{
	$location = $_REQUEST["locid"];

	$query = $DB->query("Select * from glpi_locations where id = $location");
	$queryrows =$DB->numrows($query);
	if($queryrows == 1)
	{
		$data = $DB->fetch_assoc($query);
		$dataarray = array([
			'solid' => $data["solid"],
			'state' => $data["state"],
			'country' => $data["country"],
			'amname' => $data["areamanager"],
			'gateway' => $data["gateway"],
			'subnet' => $data["subnet"],
			'locm' => $data["locm"],
			'brspeed' => $data["brspeed"],
			'city' => $data["city"]

		
		]);

		echo json_encode($dataarray);
	}
}

?>