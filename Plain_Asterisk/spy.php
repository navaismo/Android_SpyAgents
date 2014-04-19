<?php
include "loginsql.php";
require_once('/var/lib/asterisk/agi-bin/phpagi/phpagi-asmanager.php');

$id = $_GET['id'];
$spy_exten = $_GET['spy_exten'];
$exten = $_GET['exten'];
$mydate = date('Y-m-d H:i:s');
echo $mydate;
if ( $id == '' || $spy_exten == ''){
	echo 1;
} else {

	$sql="SELECT name from Spy_ID where id='$id'";
	$results = mysql_query($sql);
	while($row = mysql_fetch_array($results)){
        	$name = $row['name'];
	}

	$sql2="INSERT INTO Spy_ID_CDR(name,id,spiedchan,fromext,date) VALUES('$name','$id','$spy_exten','$exten','$mydate')";
	mysql_query($sql2);

	$asm = new AGI_AsteriskManager();
        if($asm->connect('localhost','muser','mpass')){
                $peer = $asm->command("originate sip/".$exten." application ChanSpy sip/".$spy_exten."");
	 }
//		echo "done";
}		
?>
