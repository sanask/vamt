<?php

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=vamt_icici_billing.csv');

// create a file pointer connected to the output stream/
$output = fopen('php://output', 'w');
//Asset Code
// output the column headings
fputcsv($output, array('Asset Code','Branch Name', 'Asset Type', 'Make', 'Model','Serial number','Asset Name','Group','Installation By','Gateway','Location Type','AM Name','Sol ID','Country','State','City','Branch Speed','Employee login ID','Employee Contact Number','Employee No','Employee Name','Employee Grade','Emp Department Name','Employee Designations','Consultant ID','Consultant Name','Consultant Contact Number','Consultant Department Name','Consultant Designaiton','Consultant Grade','Asset Year','Invoice Number','Status','Hardware Installed By','Service Type','FCRM Number','PO Number','Asset Status','Status Remark','IP Address','CPU Make','CPU Speed','RAM SIZE','HDD Capacity','MAC Address','Operating System','DNS Entries','Machine Subnet','Machine Gateway','OS Architecture','Monitor Type','Monitor Size','Optical Drive','Audio Enable','Patch Cable','Dual Monitor','Bag','Keyboard','Battery','Mouse','Power Adapter','Physical Damage','Red Tag','Memory','Initial page counter','Current counter of pages','Serial Port','Parallel Port','USB  Port','Ethernet Port','Wifi  Port','Printer Category','Sleep Mode','Power Connection Mode','Firmware Upgrade','Scanner Type','WYSE device','IMEI 1','IMEI 2','Sim Imsi No','Sim Operator','Air Watch Browser','Air Watch Agent','Enrollment Status','Charger','USB Cable','Cover','MAC Address','Burn Sr','Switch Port','USB','Micro USB','Fast Ethernet')); 

include ('inc/includes.php');
$groups_id	=	$_REQUEST['groups_id'];
$assettype	=	$_REQUEST['at'];
$assetsyear	=	$_REQUEST['ay'];

if($groups_id!=0){
    $groupqry.=' where glpi_groups.id IN ('.$groups_id.')';
}


$tables				=	array('glpi_computers','glpi_printers','glpi_peripherals','glpi_phones','glpi_networkequipments');
$pluginstable		=	array('glpi_plugin_fields_computerlocationtypes','glpi_plugin_fields_printerprintcategories','glpi_plugin_fields_peripheralscanners','glpi_plugin_fields_phonetablets','glpi_plugin_fields_networkequipmentnetworkdevices');
$typestable			=	array('glpi_computertypes','glpi_printertypes','glpi_peripheraltypes','glpi_phonetypes','glpi_networkequipmenttypes');
$modelstable		=	array('glpi_computermodels','glpi_printermodels','glpi_peripheralmodels','glpi_phonemodels','glpi_networkequipmentmodels');
$typeid				=	array('computertypes_id','printertypes_id','peripheraltypes_id','phonetypes_id','networkequipmenttypes_id');
$modelid			=	array('computermodels_id','printermodels_id','peripheralmodels_id','phonemodels_id','networkequipmentmodels_id');


$amnamefield  	= 	array('amnamefield2','amnamefield3','amnamefield4','amnamefield5','amnamefield');
$consultantid  	= 	array('consultantidfield','consultantidfield2','consultantidfield3','consultantidfield5','consultantidfield4');
$cname  		= 	array('consultantnamefield','consultantnamefield2','consultantnamefield3','consultantnamefield5','consultantnamefield4');
$cnumber  		= 	array('consultantcontactnumberfield','consultantcontactnumberfield2','consultantcontactnumberfield3','consultantcontactnumberfield5','consultantcontactnumberfield4');
$state  		= 	array('statefield2','statefield3','statefield4','statefield5','statefield');
$city  		= 	array('cityfield2','cityfield5','cityfield4','cityfield6','cityfield3');

$solid 		  	=	array('solidfield2','solidfield3','solidfield4','solidfield5','solidfield');
$assetyear	  	=   array('assetyearfield2','assetyearfield3','assetyearfield','assetyearfield4','assetyearfield5');
$gateway  		=	array('gatewayfield','gatewayfield2','gatewayfield3','gatewayfield5','gatewayfield4');
$loctype  		=	array('locationtypefield2','locationtypefield3','locationtypefield4','locationtypefield5','locationtypefield');
$country  		=	array('countryfield','countryfield2','countryfield3','countryfield5','countryfield4');
$brspeed  		=	array('testbrspeedfield','branchspeedfield','branchspeedfield2','branchspeedfield4','branchspeedfield3');
$ename	  		=	array('employeenamefield2','employeenamefield','employeenamefield3','employeenamefield5','employeenamefield4');
$egrade	  		=	array('ownergradefield','gradefield','employeegradefield','employeegradefield2','emlpoyeegradefield');
$edept  		=	array('empdepartmentnamefield','empdepartmentnamefield2','employeedepartmentnamefield','employeedepartmentnamefield3','employeedepartmentnamefield2');
$cdept	  		=	array('consultantdepartmentnamefield','consultantdepartmentnamefield2','consultantdepartmentnamefield3','consultantdepartmentnamefield5','consultantdepartmentnamefield4');
$edesi 	  		=	array('ownerdesignationfield','ownerdesignationfield2','employeedesignationfield','employeedesignationfield3','employeedesignationfield2');
$cdesi 	  		=	array('consultantdesignaitonfield','consultantdesignaitonfield2','consultantdesignationfield','consultantdesignationfield3','consultantdesignationfield2');
$cgrade  		=	array('consultantgradefield','consultantgradefield2','consultantgradefield3','consultantgradefield5','consultantgradefield4');
$invoice 		=	array('invoicenumberfield','invoicenumberfield2','invoicenumberfield3','invoicenumberfield4','invoicenumberfield5');
$fcrmno   		=	array('fcrmnumberfield','fcrmnumberfield2','fcrmnumberfield3','fcrmnumberfield4','fcrmnumberfield5');
$pono 	 		=	array('ponumberfield','ponumberfield2','ponumberfield3','ponumberfield4','ponumberfield5');


if($assettype=='1'){
	$start  = 0;
	$count 	=	1;
}elseif($assettype=='2'){
	$start  = 1;
	$count 	=	2;
}elseif($assettype=='3'){
	$start  = 2;
	$count 	=	3;	
}elseif($assettype=='4'){
	$start  = 3;
	$count 	=	4;	
}elseif($assettype=='5'){
	$start  = 4;
	$count 	=	5;	
}else{
	$start  = 0;
	$count 	=	count($tables);
}

for($i=$start;$i<$count;$i++){
if($assetsyear!=0){
	if(isset($groupqry)){
		$groupqry.=' and '.$pluginstable[$i].'.'.$assetyear[$i].'='.$assetsyear;	
	}else{
		$groupqry.=' where '.$pluginstable[$i].'.'.$assetyear[$i].'='.$assetsyear;
	}
    
}
 $ExtraFields	=	array('glpi_plugin_fields_cpumakefielddropdowns.name as cpumake,glpi_plugin_fields_cpuspeedfielddropdowns.name as cpuspeed,glpi_plugin_fields_ramidfielddropdowns.name as ramsize,glpi_plugin_fields_hddcapacityfielddropdowns.name as hddcapacity, '.$pluginstable[$i].'.macaddressfield as macaddress, '.$pluginstable[$i].'.ipaddressfield as ipaddress,glpi_plugin_fields_operatingsystemfielddropdowns.name as osname,'.$pluginstable[$i].'.dnsentriesfield as dns,'.$pluginstable[$i].'.machinegatewayfield as mgateway,'.$pluginstable[$i].'.machinesubnetfield as msubnet,glpi_plugin_fields_osarchitecturefielddropdowns.name as osaname,glpi_plugin_fields_monitortftfielddropdowns.name as monitortype,glpi_plugin_fields_monitortftsizefielddropdowns.name as monitorsize,glpi_plugin_fields_opticaldrivefielddropdowns.name as odrive,'.$pluginstable[$i].'.audioenablefield as audio,glpi_plugin_fields_patchcablefielddropdowns.name as patchcable,glpi_plugin_fields_dualmonitorfielddropdowns.name as dmonitor,glpi_plugin_fields_bagfielddropdowns.name as bag,glpi_plugin_fields_batteryfielddropdowns.name as battery,glpi_plugin_fields_keyboardfielddropdowns.name as keyboard,glpi_plugin_fields_mousefielddropdowns.name as mouse,glpi_plugin_fields_poweradapterfielddropdowns.name as poweradapter,'.$tables[$i].'.autoupdatesystems_id as installationby',
 	$pluginstable[$i].'.physicaldamagefield4 as physical,'.$pluginstable[$i].'.redtagfield4 as redtag,'.$tables[$i].'.memory_size as memory_size,'.$tables[$i].'.init_pages_counter initcounter,'.$tables[$i].'.last_pages_counter as lastcounter,'.$tables[$i].'.have_serial,'.$tables[$i].'.have_parallel,'.$tables[$i].'.have_usb,'.$tables[$i].'.have_wifi,'.$tables[$i].'.have_ethernet,glpi_plugin_fields_printercategoryfielddropdowns.name as ptypename,glpi_plugin_fields_sleepmodefielddropdowns.name as sleepmode,glpi_plugin_fields_powerconnectionmodefielddropdowns.name as powermode,'.$pluginstable[$i].'.firmwareupgradefield3 as fupgrade,'.$pluginstable[$i].'.ipaddressfield2 as ipaddress,'.$pluginstable[$i].'.installationbyfield5 as installationby',
 	$pluginstable[$i].'.physicaldamagefield2 as physical,'.$pluginstable[$i].'.redtagfield3 as redtag,'.$pluginstable[$i].'.ipaddressfield3 as ipaddress,glpi_plugin_fields_scannertypefielddropdowns.name as scanertype,glpi_plugin_fields_monitortypefielddropdowns.name as monitortype,glpi_plugin_fields_monitorsizefielddropdowns.name as monitorsize,glpi_plugin_fields_keyboardfielddropdowns.name as keyboard,glpi_plugin_fields_patchcablefielddropdowns.name as patchcable,glpi_plugin_fields_mousefielddropdowns.name as mouse,glpi_plugin_fields_poweradapterfielddropdowns.name as poweradapter,glpi_plugin_fields_wysedevicefielddropdowns.name as wyse,'.$tables[$i].'.users_id as installationby',
 	$pluginstable[$i].'.ipaddressfield5 as ipaddress,'.$pluginstable[$i].'.imei1field,'.$pluginstable[$i].'.imei2field,'.$pluginstable[$i].'.simoperatorfield,'.$pluginstable[$i].'.simimsinofield,'.$pluginstable[$i].'.airwatchagentfield,'.$pluginstable[$i].'.airwatchbrowserfield,glpi_plugin_fields_enrollmentstatusfielddropdowns.name as enroll,glpi_plugin_fields_chargerfielddropdowns.name as charger,glpi_plugin_fields_usbcablefielddropdowns.name as usbcable,glpi_plugin_fields_coverfielddropdowns.name as cover,'.$pluginstable[$i].'.addedbyfield as installationby',
 	 $pluginstable[$i].'.ipaddressfield4 as ipaddress,'.$pluginstable[$i].'.macaddressfield2,glpi_plugin_fields_burnsrfielddropdowns.name as burnsr,glpi_plugin_fields_switchportfielddropdowns.name as switchport,glpi_plugin_fields_patchcablefielddropdowns.name as patchcable,glpi_plugin_fields_poweradapterfielddropdowns.name as poweradapter,glpi_plugin_fields_usbfielddropdowns.name as usb,glpi_plugin_fields_microusbfielddropdowns.name as microusb,glpi_plugin_fields_fastethernetfielddropdowns.name as ethernet,'.$pluginstable[$i].'.physicaldamagefield5 as physical,'.$pluginstable[$i].'.installationbyfield4 as installationby'


 	);



$ExtraJoin		=	array('LEFT JOIN `glpi_plugin_fields_cpumakefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_cpumakefielddropdowns_id` = glpi_plugin_fields_cpumakefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_cpuspeedfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_cpuspeedfielddropdowns_id` = glpi_plugin_fields_cpuspeedfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_ramidfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_ramidfielddropdowns_id` = glpi_plugin_fields_ramidfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_hddcapacityfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_hddcapacityfielddropdowns_id` = glpi_plugin_fields_hddcapacityfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_operatingsystemfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_operatingsystemfielddropdowns_id` = glpi_plugin_fields_operatingsystemfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_osarchitecturefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_osarchitecturefielddropdowns_id` = glpi_plugin_fields_osarchitecturefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_monitortftfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_monitortftfielddropdowns_id` = glpi_plugin_fields_monitortftfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_monitortftsizefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_monitortftsizefielddropdowns_id` = glpi_plugin_fields_monitortftsizefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_opticaldrivefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_opticaldrivefielddropdowns_id` = glpi_plugin_fields_opticaldrivefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_patchcablefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_patchcablefielddropdowns_id` = glpi_plugin_fields_patchcablefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_dualmonitorfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_dualmonitorfielddropdowns_id` = glpi_plugin_fields_dualmonitorfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_bagfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_bagfielddropdowns_id` = glpi_plugin_fields_bagfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_batteryfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_batteryfielddropdowns_id` = glpi_plugin_fields_batteryfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_keyboardfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_keyboardfielddropdowns_id` = glpi_plugin_fields_keyboardfielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_mousefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_mousefielddropdowns_id` = glpi_plugin_fields_mousefielddropdowns.`id`)
	LEFT JOIN `glpi_plugin_fields_poweradapterfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_poweradapterfielddropdowns_id` = glpi_plugin_fields_poweradapterfielddropdowns.`id`)
	','
LEFT JOIN `glpi_plugin_fields_printercategoryfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_printercategoryfielddropdowns_id` = glpi_plugin_fields_printercategoryfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_sleepmodefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_sleepmodefielddropdowns_id` = glpi_plugin_fields_sleepmodefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_powerconnectionmodefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_powerconnectionmodefielddropdowns_id` = glpi_plugin_fields_powerconnectionmodefielddropdowns.`id`)
	','
LEFT JOIN `glpi_plugin_fields_scannertypefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_scannertypefielddropdowns_id` = glpi_plugin_fields_scannertypefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_monitortypefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_monitortypefielddropdowns_id` = glpi_plugin_fields_monitortypefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_monitorsizefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_monitorsizefielddropdowns_id` = glpi_plugin_fields_monitorsizefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_keyboardfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_keyboardfielddropdowns_id` = glpi_plugin_fields_keyboardfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_patchcablefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_patchcablefielddropdowns_id` = glpi_plugin_fields_patchcablefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_wysedevicefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_wysedevicefielddropdowns_id` = glpi_plugin_fields_wysedevicefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_poweradapterfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_poweradapterfielddropdowns_id` = glpi_plugin_fields_poweradapterfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_mousefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_mousefielddropdowns_id` = glpi_plugin_fields_mousefielddropdowns.`id`)','

LEFT JOIN `glpi_plugin_fields_enrollmentstatusfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_enrollmentstatusfielddropdowns_id` = glpi_plugin_fields_enrollmentstatusfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_chargerfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_chargerfielddropdowns_id` = glpi_plugin_fields_chargerfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_usbcablefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_usbcablefielddropdowns_id` = glpi_plugin_fields_usbcablefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_coverfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_coverfielddropdowns_id` = glpi_plugin_fields_coverfielddropdowns.`id`)','

LEFT JOIN `glpi_plugin_fields_burnsrfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_burnsrfielddropdowns_id` = glpi_plugin_fields_burnsrfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_switchportfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_switchportfielddropdowns_id` = glpi_plugin_fields_switchportfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_patchcablefielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_patchcablefielddropdowns_id` = glpi_plugin_fields_patchcablefielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_poweradapterfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_poweradapterfielddropdowns_id` = glpi_plugin_fields_poweradapterfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_usbfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_usbfielddropdowns_id` = glpi_plugin_fields_usbfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_microusbfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_microusbfielddropdowns_id` = glpi_plugin_fields_microusbfielddropdowns.`id`)
LEFT JOIN `glpi_plugin_fields_fastethernetfielddropdowns` ON ('.$pluginstable[$i].'.`plugin_fields_fastethernetfielddropdowns_id` = glpi_plugin_fields_fastethernetfielddropdowns.`id`)

');

 $query = "SELECT $tables[$i].* , glpi_groups.`name` as groupname,$typestable[$i].`name` as typename,glpi_locations.`name` as location,glpi_plugin_fields_statusfielddropdowns.`name` as statusnme,$pluginstable[$i].`$amnamefield[$i]` as amname,$modelstable[$i].`name` as modelname,glpi_manufacturers.`name` as makename,$pluginstable[$i].`$consultantid[$i]` as consultantid,$pluginstable[$i].`$cname[$i]` as consultantname,$pluginstable[$i].`$cnumber[$i]` as concontactnumber,glpi_states.`name` as statesname,glpi_plugin_fields_statusremarkfielddropdowns.`name` as remarkname,$pluginstable[$i].`$state[$i]` as statename,$pluginstable[$i].`$city[$i]` as cityname,$pluginstable[$i].`$solid[$i]` as solid,$pluginstable[$i].`$assetyear[$i]` as assetyear,$pluginstable[$i].`$gateway[$i]` as gateway,$pluginstable[$i].`$loctype[$i]` as locationtype,$pluginstable[$i].`$country[$i]` as country,$pluginstable[$i].`$brspeed[$i]` as brspeed,$pluginstable[$i].`$ename[$i]` as employeename,$pluginstable[$i].`$egrade[$i]` as grade,$pluginstable[$i].`$edept[$i]` as deptname,$pluginstable[$i].`$cdept[$i]` as cdeptname,$pluginstable[$i].`$edept[$i]` as edesignation,$pluginstable[$i].`$cdesi[$i]` as cdesign,$pluginstable[$i].`$cgrade[$i]` as cgrade,$pluginstable[$i].`$invoice[$i]` as invoicenumber,glpi_plugin_fields_hardwareinstalledbyfielddropdowns.`name` as hardwareinstall,$pluginstable[$i].`$fcrmno[$i]` as fcrmnumber,$pluginstable[$i].`$pono[$i]` as ponumber,glpi_plugin_fields_servicetypefielddropdowns.`name` as servicetype,$ExtraFields[$i]  FROM $tables[$i]
                LEFT JOIN `$pluginstable[$i]`
                    ON ($tables[$i].`id` = $pluginstable[$i].`items_id`)
                LEFT JOIN `glpi_groups`
                    ON ($tables[$i].`groups_id` = glpi_groups.`id`
                    )      
                LEFT JOIN `$typestable[$i]`
                    ON ($tables[$i].`$typeid[$i]` = $typestable[$i].`id`)
                LEFT JOIN `glpi_locations`
                    ON ($tables[$i].`locations_id` = glpi_locations.`id`)
                LEFT JOIN `glpi_plugin_fields_statusfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusfielddropdowns_id` = glpi_plugin_fields_statusfielddropdowns.`id`)                  
                LEFT JOIN `glpi_manufacturers`
                    ON ($tables[$i].`manufacturers_id` = glpi_manufacturers.`id`)
                LEFT JOIN `$modelstable[$i]`
                    ON ($tables[$i].`$modelid[$i]` = $modelstable[$i].`id`)
                LEFT JOIN `glpi_states`
                    ON ($tables[$i].`states_id` = glpi_states.`id`)
                LEFT JOIN `glpi_plugin_fields_statusremarkfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_statusremarkfielddropdowns_id` = glpi_plugin_fields_statusremarkfielddropdowns.`id`)
                LEFT JOIN `glpi_plugin_fields_hardwareinstalledbyfielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_hardwareinstalledbyfielddropdowns_id` = glpi_plugin_fields_hardwareinstalledbyfielddropdowns.`id`) 
                 LEFT JOIN `glpi_plugin_fields_servicetypefielddropdowns`
                    ON ($pluginstable[$i].`plugin_fields_servicetypefielddropdowns_id` = glpi_plugin_fields_servicetypefielddropdowns.`id`)
                    ".$ExtraJoin[$i]." ".$groupqry;
      $result = $DB->request($query);
      if ($result->numrows() > 0) {
      	foreach ($result as $line) {
      		if($line['audio']==1){$audio = 'Yes';}else{$audio = 'No';}
			if($line['physical']==1){$physical = 'Yes';}else{$physical = 'No';}
			if($line['redtag']==1){$redtag = 'Yes';}else{$redtag = 'No';}
			if($line['have_serial']==1){$serial='Yes';}else{$serial = 'No';}
			if($line['have_parallel']==1){$parallel='Yes';}else{$parallel='No';}
			if($line['have_usb']==1){$husb='Yes';}else{$husb='No';}
			if($line['have_ethernet']==1){$hether='Yes';}else{$hether='No';}
			if($line['have_wifi']==1){$hwifi='Yes';}else{$hwifi='No';}
			if($line['fupgrade']==1){$fupgrade='Yes';}else{$fupgrade='No';}
			$hdd = explode(" ",$line['hddcapacity']);

			if($hdd[0]>='450' and $hdd[0]<='500'){
				$nhdd='500 GB';
			}else{
				$nhdd=$line['hddcapacity'];
			}
			if($assettype==1){
				$empno = $line['uuid'];
			}else{
				$empno = $line['contact'];
			}
			fputcsv($output, array($line['name'],$line['location'], $line['typename'], $line['makename'], $line['modelname'],$line['serial'],$line['otherserial'],$line['groupname'],$line['installationby'],$line['gateway'],$line['locationtype'],$line['amname'],$line['solid'],$line['country'],$line['statename'],$line['cityname'],$line['brspeed'],$line['contact'],$line['contact_num'],$empno,$line['employeename'],$line['grade'],$line['deptname'],$line['edesignation'],$line['consultantid'],$line['consultantname'],$line['concontactnumber'],$line['cdeptname'],$line['cdesign'],$line['cgrade'],$line['assetyear'],$line['invoicenumber'],$line['statusnme'],$line['hardwareinstall'],$line['servicetype'],$line['fcrmnumber'],$line['ponumber'],$line['statesname'],$line['remarkname'],$line['ipaddress'],$line['cpumake'],$line['cpuspeed'],$line['ramsize'],$nhdd,$line['macaddress'],$line['osname'],$line['dns'],$line['msubnet'],$line['mgateway'],$line['osaname'],$line['monitortype'],$line['monitorsize'],$line['odrive'],$audio,$line['patchcable'],$line['dmonitor'],$line['bag'],$line['keyboard'],$line['battery'],$line['mouse'],$line['poweradapter'],$physical,$redtag,$line['memory_size'],$line['initcounter'],$line['lastcounter'],$serial,$parallel,$husb,$hether,$hwifi,$line['ptypename'],$line['sleepmode'],$line['powermode'],$fupgrade,$line['scanertype'],$line['wyse'],$line['imei1field'],$line['imei2field'],$line['simimsinofield'],$line['simoperatorfield'],$line['airwatchbrowserfield'],$line['airwatchagentfield'],$line['enroll'],$line['charger'],$line['usbcable'],$line['cover'],$line['macaddress'],$line['burnsr'],$line['switchport'],$line['usb'],$line['microusb'],$line['ethernet']));      		
      		}
      	}
 	}
 ?>