<?php
include "/var/www/html/libs/paloSantoDB.class.php";
require_once('/var/www/html/modules/spyagents/phpagi/phpagi-asmanager.php');

$pDB = new paloDB("sqlite3:////var/www/db/spyagents.db");
$amipwd = exec("cat /etc/elastix.conf | grep amiadminpwd | awk -F'=' '{print $2}'");

$id = $_GET['id'];
$spy_exten = $_GET['spy_exten'];
$exten = $_GET['exten'];
$mydate = date('Y-m-d H:i:s');
//echo $mydate;

if ( $id == '' || $spy_exten == ''){
	echo 1;
} else {

	$sql="SELECT name from Spy_ID where id=?";
	$arrParam = array($id);
	$arrResult = $pDB->fetchTable($sql,TRUE,$arrParam);
	foreach($arrResult as $row){
        	$name = $row['name'];
	}

	$sql2="INSERT INTO Spy_ID_CDR(name,id,spiedchan,fromext,date) VALUES(?,?,?,?,?)";
        $arrParam2 = array($name,$id,$spy_exten,$exten,$mydate);
	$result = $pDB->genQuery($sql2,$arrParam2);

	$asm = new AGI_AsteriskManager();
        if($asm->connect('localhost','admin',$amipwd)){
                $peer = $asm->command("originate sip/".$exten." application ChanSpy sip/".$spy_exten."");
         }

}		
?>
