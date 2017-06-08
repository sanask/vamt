<?php
include ('inc/includes.php');

$name	=	$_REQUEST['val'];
$typ	=	1;


$typ		=	1;

$Code		=	$name;
$Group		=	$_REQUEST['groups_id'];
$AssetType  = 	$_REQUEST['AssetType'];
if($AssetType==0){
	echo "Please Select Asset Type First";
	exit();
}


//$Code		=	'ISEC2017CPU123';
//$Group		=	10;
$AssetTypeArray		=	array('TAB'=>1);

$ValidGroupArrayFirst = array('ICI','TMP','UNA','SNG','RNT','HFC' ,'BOR');

$ValidGroupArrayLombard = array('LGI','TMP','UNA','RNT');

$ValidGroupArrayPru = array('PLI','DIR','RNT');

$ValidGroupArrayIsecR = array('WEB','TMP','UNA','ISEC','RNT');

$ValidGroupArrayIsecPD = array('ISEC','WEB','IPD','ISC');

$ValidGroupArrayFoundation = array('ICI','TEMP','IFIG');


if($Group==7 || $Group==9 || $Group==8){
	$ValidGroupArray 	=	$ValidGroupArrayFirst;
}elseif($Group==12){
	$ValidGroupArray 	=	$ValidGroupArrayLombard;
}elseif($Group==13){
	$ValidGroupArray 	=	$ValidGroupArrayPru;
}elseif($Group==6){
	$ValidGroupArray 	=	$ValidGroupArrayIsecR;
}elseif($Group==14){	
	$ValidGroupArray 	=	$ValidGroupArrayIsecPD;
}elseif($Group==10){	
	$ValidGroupArray 	=	$ValidGroupArrayFoundation;
}

if(is_numeric(substr($Code, 4,4))){
	$GroupVar			=	substr($Code, 0,4);
	$YearVar			=	substr($Code, 4,4);	
	$AssetTypeVar		=	substr($Code, 8,3);
	$RandNumberVar		=	substr($Code, 11,16);
}else{
	$GroupVar		=	substr($Code, 0,3);
	$YearVar		=	substr($Code, 3,4);	
	$AssetTypeVar	=	substr($Code, 7,3);
	$RandNumberVar	=	substr($Code, 10,16);

}
	$CodeLength			=	strlen($Code);

	if(strlen($Code)!=16){
		echo "Length should be 16 Characters";
		exit();
	}
	if(!in_array($GroupVar,$ValidGroupArray)){
		echo "Invalid Group Entered in Asset Code";	
		exit();
	}
	if(!is_numeric($YearVar)){
		echo "Invalid Year";	
		exit();
	}
	if($AssetTypeArray[$AssetTypeVar]!=$AssetType){
		echo "Invalid Asset Type in Asset Code";	
		exit();
	}
	if(!is_numeric($RandNumberVar)){
		echo "Invalid Last 6 Digit";
		exit();
	}





if($name){
	if($typ==1){
		$Field	=	'name';
	}elseif($typ==2){
		$Field	=	'serial';
	}
	$query = "SELECT * FROM `glpi_phones` where ".$Field."='".trim($name)."'";
	$result = $DB->query($query);
	$rs	=	$DB->result($result, 0, 0);
	if ($DB->numrows($result)>0) {
		echo "<font color='red'>Duplicate Asset Code</font>";
	}
}
?>