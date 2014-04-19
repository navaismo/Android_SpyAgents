<?php


if (!@include_once(getenv('FREEPBX_CONF') ? getenv('FREEPBX_CONF') : '/etc/freepbx.conf')) { 
      include_once('/etc/asterisk/freepbx.conf'); 
}
global $db;
$id=$_GET['id'];

$sql="SELECT id from Spy_ID where id='$id'";
$results = $db->getAll($sql, DB_FETCHMODE_ASSOC);
foreach($results as $row){
	$dbid = $row['id'];
}
if ( $dbid != $id || $id == '' || $id == NULL){
	$allpeers[] = array('active_peer' => '123_no_id_123' );
        echo json_encode($allpeers);	
} else {
	if($astman->connected()) {
    		$peer = $astman->command('core show channels');
		sleep(1);

		//print_r($peer['data']);
		preg_match_all("/SIP\/(.*)-\d.*/i",$peer['data'],$body,PREG_SET_ORDER);

		//print_r($body);

		$allpeers = array();
	
		if( sizeof($body) > 0){
			for( $i = 0; $i < sizeof($body); $i++){
				//echo "Found active peer on: ".$body[$i][1]."\n";
				$allpeers[] = array('active_peer' => $body[$i][1] );
			}
				echo json_encode($allpeers);
		} else{
			$allpeers[] = array('active_peer' => '123_no_peers_123' );
			echo json_encode($allpeers);	
		}

	}
	
}		
?>
