<html>
<body style='background-color:#CCCCCC;'>
<div id="loading" style="height: 100px;width: 100%;position: fixed;z-index: 1000;top: 50%;text-align:center">
	Please wait while your page is loading<br>
    <img src="pics/ajax-loader.gif" id="Please wait while your page is loading" style="text-align:center" />
</div>
<script language="javascript" type="text/javascript">
function fetch(){
	
var browser_name = '';
isIE = /*@cc_on!@*/false || !!document.documentMode;
isEdge = !isIE && !!window.StyleMedia;
if(navigator.userAgent.indexOf("Chrome") != -1 && !isEdge){
	browser_name = 'chrome';
}else if(navigator.userAgent.indexOf("Safari") != -1 && !isEdge){
	browser_name = 'safari';
}else if(navigator.userAgent.indexOf("Firefox") != -1 ) {
	browser_name = 'firefox';
}else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )){
	browser_name = 'ie';
}else if(isEdge){
	browser_name = 'edge';
}else {
   browser_name = 'other-browser';
}

if(browser_name=='ie'){		
var wbemFlagReturnImmediately = 0x10;
var wbemFlagForwardOnly = 0x20;
var spval,spval1,strexpaudio
objLocator = new ActiveXObject("WbemScripting.SWbemLocator");
objService = objLocator.ConnectServer(".","root/cimv2");
objService.Security_.ImpersonationLevel = 3;
var arrComputers = ".";
for (i = 0; i < arrComputers.length; i++) {
   var objWMIService = GetObject("winmgmts:\\\\" + arrComputers + "\\root\\CIMV2");
   var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_ComputerSystem", "WQL",wbemFlagReturnImmediately | wbemFlagForwardOnly);
   var enumItems = new Enumerator(colItems);
   for (; !enumItems.atEnd(); enumItems.moveNext()) {
    var objItem = enumItems.item();
		Manufacturer = objItem.Manufacturer;
		Model  =  objItem.Model;
		CName  = objItem.Name;
		UName  = objItem.UserName;
   }
    var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_OperatingSystem");
   var enumItems = new Enumerator(colItems);
   for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		Os     = objItem.Caption;
		Version = objItem.Version;
	}
	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_Processor");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		strosbit	=	objItem.AddressWidth;
		Speed 	=	(objItem.MaxClockSpeed/1000).toFixed(2)+" GHz";
		cpumake	=	objItem.Name;//objItem.Manufacturer+"-"+
	}
	
	MACAddress	=	"";
	IPAddress	=	"";
	i=1;
	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration where IPEnabled=TRUE");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		if(MACAddress==""){
			MACAddress  = objItem.MACAddress;
		}else{
			MACAddress	=	MACAddress+"-"+objItem.MACAddress;
		}

		if(i==1){
			IPArra = objItem['IPAddress'].toArray();
			IPAddress = IPArra[0];
			SubnetArr  = objItem['IPSubnet'].toArray();
			SubnetAddr	=	SubnetArr[0];
			DefaultIPGatewayArr	=	objItem['DefaultIPGateway'].toArray();
			DefaultIPGateway 	=	DefaultIPGatewayArr[0];
		}
		i=i+1;
	}
	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_PhysicalMemory");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		RamId	=	Math.round((objItem.Capacity)/1073741824)+" GB";
		//+objItem.Manufacturer+"-"+objItem.Description;
	}
	colItems=objWMIService.ExecQuery("SELECT * FROM CIM_DiskDrive");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		hdcapacity = Math.round((objItem.Size)/1073741824)+" GB";
	}
	var colItems = objWMIService.ExecQuery("SELECT * FROM win32_logicaldisk");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		if(objItem.DriveType==2){
			FDDEnable = "Enable";
		}else{
			if(objItem.DriveType==5){
			var CDEnable = "Enable";
			}
		}
	}
	CDR = 'NA';
	if(CDEnable=="Enable"){
		colItems = objWMIService.ExecQuery("SELECT Name,Availability FROM Win32_CDROMDrive", "WQL",wbemFlagReturnImmediately + wbemFlagForwardOnly);
		var enumItems = new Enumerator(colItems);
		for (; !enumItems.atEnd(); enumItems.moveNext()) {
			var objItem = enumItems.item();
			var CDR = objItem.Name+"-"+objItem.Availability;
		}
	}
	dns		=	"";
	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration where IPEnabled=TRUE");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		var enumItems1 = objItem.DNSServerSearchOrder.toArray();
		for(var i = 0; i < enumItems1.length; i++)
		{
			if(dns==''){
				dns 	=	enumItems1[0];
			}else{
				dns 	=	dns+"-"+enumItems1[0];
			}
		}
	}
	//strosbit	=	'';

	//var WshShell = new ActiveXObject("WScript.Shell");
	//var value = WshShell.RegRead("HKLM\\HARDWARE\\DESCRIPTION\\System\\CentralProcessor\\0\\Identifier");
	//if (value.indexOf("x86")> "0"){
	//	strosbit="32";
	//}else{
	//	if (value.indexOf("64") > "0"){
	//		strosbit="64";
	//	}	
	//}

	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_BIOS");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		var serialno = objItem.SerialNumber;
	}
	
	var colItems = objWMIService.ExecQuery("SELECT * FROM Win32_SoundDevice");
	var enumItems = new Enumerator(colItems);
	for (; !enumItems.atEnd(); enumItems.moveNext()) {
		var objItem = enumItems.item();
		var StatusInfo = objItem.StatusInfo;
		if(StatusInfo==2 || StatusInfo==4){
			AudioStatus	= 0;
		}else{
			AudioStatus	= 1;
		}
	}

	
	
}
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		window.location = "front/central.php";
    }
  };
  xhttp.open("POST", "insertdata.php?name="+CName+"&man="+Manufacturer+"&model="+Model+"&username="+UName+"&os="+Os+"&version="+Version+"&speed="+Speed+"&dig="+DefaultIPGateway+"&mcadd="+MACAddress+"&ramid="+RamId+"&hddcapacity="+hdcapacity+"&cdr="+CDR+"&cpumake="+cpumake+"&dns="+dns+"&ipadd="+IPAddress+"&osbit="+strosbit+"&serialno="+serialno+"&subnet="+SubnetAddr+"&AudioStatus="
  	+AudioStatus, true);
  xhttp.send();
}else{
	window.location = "front/central.php";
}
}  
 fetch();
</script>
</body>
</html>