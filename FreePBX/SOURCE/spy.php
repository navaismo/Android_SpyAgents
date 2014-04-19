<?php
if (!@include_once(getenv('FREEPBX_CONF') ? getenv('FREEPBX_CONF') : '/etc/freepbx.conf')) {
      include_once('/etc/asterisk/freepbx.conf');
}
global $db;


$id = $_GET['id'];
$spy_exten = $_GET['spy_exten'];
$exten = $_GET['exten'];
$mydate = date('Y-m-d H:i:s');
echo $mydate;
if ( $id == '' || $spy_exten == ''){
	echo 1;
} else {

	$sql="SELECT name from Spy_ID where id='$id'";
	$results = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	foreach($results as $row){
        	$name = $row['name'];
	}

	$sql2="INSERT INTO Spy_ID_CDR(name,id,spiedchan,fromext,date) VALUES('$name','$id','$spy_exten','$exten','$mydate')";
	$db->query($sql2);

	 if($astman->connected()) {
                $peer = $astman->command("originate sip/".$exten." application ChanSpy sip/".$spy_exten."");
	 }
//		echo "done";
}		
?>
