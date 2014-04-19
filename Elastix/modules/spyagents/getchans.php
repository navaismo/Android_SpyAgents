<?php
include "/var/www/html/libs/paloSantoDB.class.php";
require_once('/var/www/html/modules/spyagents/phpagi/phpagi-asmanager.php');

$pDB = new paloDB("sqlite3:////var/www/db/spyagents.db");
$amipwd = exec("cat /etc/elastix.conf | grep amiadminpwd | awk -F'=' '{print $2}'");
$id = $_GET['id'];

$sql="SELECT id from Spy_ID where id=?";
$arrParam = array($id);
$arrResult = $pDB->fetchTable($sql,TRUE,$arrParam);

foreach($arrResult as $row){
	$dbid = $row['id'];
}

if ( $dbid != $id || $id == '' || $id == NULL){
	$allpeers[] = array('active_peer' => '123_no_id_123' );
        echo __json_encode($allpeers);	

	//echo '{"active_peer":"123_no_id_123"}';
} else {
	$asm = new AGI_AsteriskManager();
        if($asm->connect('localhost','admin',$amipwd)){
    		$peer = $asm->command('core show channels');
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
				echo __json_encode($allpeers);
		} else{
			$allpeers[] = array('active_peer' => '123_no_peers_123' );
			echo __json_encode($allpeers);	
		}

	}
	
}		



function __json_encode( $data ) {           
    if( is_array($data) || is_object($data) ) {
        $islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) );
       
        if( $islist ) {
            $json = '[' . implode(',', array_map('__json_encode', $data) ) . ']';
        } else {
            $items = Array();
            foreach( $data as $key => $value ) {
                $items[] = __json_encode("$key") . ':' . __json_encode($value);
            }
            $json = '{' . implode(',', $items) . '}';
        }
    } elseif( is_string($data) ) {
        # Escape non-printable or Non-ASCII characters.
        # I also put the \\ character first, as suggested in comments on the 'addclashes' page.
        $string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
        $json    = '';
        $len    = strlen($string);
        # Convert UTF-8 to Hexadecimal Codepoints.
        for( $i = 0; $i < $len; $i++ ) {
           
            $char = $string[$i];
            $c1 = ord($char);
           
            # Single byte;
            if( $c1 <128 ) {
                $json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1);
                continue;
            }
           
            # Double byte
            $c2 = ord($string[++$i]);
            if ( ($c1 & 32) === 0 ) {
                $json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128);
                continue;
            }
           
            # Triple
            $c3 = ord($string[++$i]);
            if( ($c1 & 16) === 0 ) {
                $json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128));
                continue;
            }
               
            # Quadruple
            $c4 = ord($string[++$i]);
            if( ($c1 & 8 ) === 0 ) {
                $u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1;
           
                $w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3);
                $w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128);
                $json .= sprintf("\\u%04x\\u%04x", $w1, $w2);
            }
        }
    } else {
        # int, floats, bools, null
        $json = strtolower(var_export( $data, true ));
    }
    return $json;
} 



?>
