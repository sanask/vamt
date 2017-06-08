<?php
include ('inc/includes.php');

//mysql_connect("localhost","root","");
//mysql_select_db("glpi");
//Session::init();
$name   		=   base64_decode($_SESSION['name']);
$model			=	base64_decode($_SESSION['model']);
$man			=	base64_decode($_SESSION['man']);
$os				=	base64_decode($_SESSION['os'])." ".base64_decode($_SESSION['version']);
$hdd			=	base64_decode($_SESSION['hddcapacity']);
$speed			=	base64_decode($_SESSION['speed']);
$username 		= 	base64_decode($_SESSION['username']);
$dig			=	base64_decode($_SESSION['dig']);
$mcadd			=	base64_decode($_SESSION['mcadd']);
$ramid			=	base64_decode($_SESSION['ramid']);
$cdr			=	base64_decode($_SESSION['cdr']);
$cpumake		=	base64_decode($_SESSION['cpumake']);
$dns			=	base64_decode($_SESSION['dns']);
$ipadd			=	base64_decode($_SESSION['ipadd']);
$osbit			=	base64_decode($_SESSION['osbit']);
$serialno		=	base64_decode($_SESSION['serialno']);
$subnet			=	base64_decode($_SESSION['subnet']);
$AudioStatus			=	base64_decode($_SESSION['AudioStatus']);




//$query = "SELECT * FROM `glpi_manufacturers` where name='".TRIM($man)."'";
//$result = $DB->query($query);
//$rs	=	$DB->result($result, 0, 0);
//if ($DB->numrows($result)>0) {
//	$manid	=	 $rs['id'];
//}else{
//	$DB->query("insert into `glpi_manufacturers` (name) values ('".TRIM($man)."')");
//	$manid	=	$DB->insert_id();
//}

//$query = "SELECT * FROM `glpi_computermodels` where name='".TRIM($model)."'";
//$result = $DB->query($query);
//$rs1	=	$DB->result($result, 0, 0);
//if ($DB->numrows($result) >0) {
//	$modid	=	 $rs1['id'];
//}else{
//	$DB->query("insert into `glpi_computermodels` (name) values ('".TRIM($model)."')");
//	$modid	=	$DB->insert_id();
//}
$query = "SELECT * FROM `glpi_plugin_fields_operatingsystemfielddropdowns` where name='".TRIM($os)."'";
$result = $DB->query($query);
if ($DB->numrows($result) >0) {
	$rs1 = $DB->fetch_assoc($result);
	$osid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_operatingsystemfielddropdowns` (name,completename) values ('".TRIM($os)."','".TRIM($os)."')");
	$osid	=	$DB->insert_id();
}
$query = "SELECT * FROM `glpi_plugin_fields_hddcapacityfielddropdowns` where name='".$hdd."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$hdid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_hddcapacityfielddropdowns` (name,completename) values ('".$hdd."','".$hdd."')");
	$hdid	=	$DB->insert_id();
}
$query = "SELECT * FROM `glpi_plugin_fields_cpuspeedfielddropdowns` where name='".$speed."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$spid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_cpuspeedfielddropdowns` (name,completename) values ('".$speed."','".$speed."')");
	$spid	=	$DB->insert_id();
}

$query = "SELECT * FROM `glpi_plugin_fields_ramidfielddropdowns` where name='".$ramid."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$rid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_ramidfielddropdowns` (name,completename) values ('".$ramid."','".$ramid."')");
	$rid	=	$DB->insert_id();
}
$query = "SELECT * FROM `glpi_plugin_fields_cpumakefielddropdowns` where name='".$cpumake."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$cmid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_cpumakefielddropdowns` (name,completename) values ('".$cpumake."','".$cpumake."')");
	$cmid	=	$DB->insert_id();
}

$query = "SELECT * FROM `glpi_plugin_fields_opticaldrivefielddropdowns` where name='".$cdr."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$cdid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_opticaldrivefielddropdowns` (name,completename) values ('".$cdr."','".$cdr."')");
	$cdid	=	$DB->insert_id();
}


$query = "SELECT * FROM `glpi_networks` where name='".$dig."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$nid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_networks` (name) values ('".$dig."')");
	$nid	=	$DB->insert_id();
}

$query = "SELECT * FROM `glpi_plugin_fields_osarchitecturefielddropdowns` where name='".$osbit."'";
$result = $DB->query($query);
$rs1 = $DB->fetch_assoc($result);
if ($DB->numrows($result) >0) {
	$oid	=	 $rs1['id'];
}else{
	$DB->query("insert into `glpi_plugin_fields_osarchitecturefielddropdowns` (name,completename) values ('".$osbit."','".$osbit."')");
	$oid	=	$DB->insert_id();
}

$manid = 0;
$modid = 0;


echo $name."|".$manid."|".$man."|".$modid."|".TRIM($model)."|".$username."|".TRIM($os)."|".$osid."|".$speed."|".$spid."|".
$dig."|".$mcadd."|".$ramid."|".$rid."|".$hdd."|".$hdid."|".$cdr."|".$cdid."|".$cpumake."|".$cmid."|".$dns."|".$nid."|".$ipadd."|".$osbit."|".$oid."|".$serialno."|".$subnet."|".$AudioStatus;
?>
