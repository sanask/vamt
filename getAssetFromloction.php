<?php
include ('inc/includes.php');


foreach ($_SESSION['glpitransfer_list']['Computer'] as $key => $val) {
  $AssetId   =  $val;
}


$query = "SELECT * FROM `glpi_computers` where locations_id='".trim($_REQUEST['locid'])."' and id!=".$AssetId;
$result = $DB->query($query);


echo "<select name='replcedbyid' onchange='showfields(this.value)'>";
echo "<option value=''>Select Asset</option>";
while($results	=	$DB->fetch_assoc($result)){

	echo "<option value='".$results['id']."'>".$results['name']."</option>";
}
echo "</select>";
//Computer::dropdown(array('value'  => $_REQUEST['locid']));
?>