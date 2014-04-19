<?php
//Check if user is "logged in"
if (!defined('FREEPBX_IS_AUTH')) { 
	die('No direct script access allowed'); 
}
?>
<?php
global $db;
//catch values
if(isset($_POST['button'])){
        $name=$_POST['name'];
        $id=$_POST['id'];
	//if one value is empty display the required label
	if( $name == '' ){
		//alert('all data required');
		 $errors1 = '<span class="ui-state-highlight">Required</span>';
	}elseif( $id == '' ){
		//alert('all data required');
		 $errors1 = '<span class="ui-state-highlight">Required</span>';

	}else{


		//insert new data
		$sql="INSERT INTO Spy_ID(name,id) Values('$name','$id')";
		$db->query($sql);

	}	


}

if(isset($_POST['delid'])){
	$id=$_POST['delid'];

	$sql ="DELETE from Spy_ID where id='$id'";
	$db->query($sql);
}


?>


<!--<script src="modules/spyagents/func.js"></script>
	<div id="dialog-delete" Title="Alert">
               <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Delete this ID?</p>
        </div>-->

 	<h3>Create New ID</h3>
	<hr>	<form method="post" id="form1" action="">
			<table>
				<tr>
					<td><label for="name">Name</label></td><td><input type="text" placeholder="John Doe" id="name" name="name" class="text ui-widget-content ui-corner-all"/><? echo $errors1; ?>
				</tr>
				<tr>
					<td><label for="id">ID</label></td><td><input type="text" placeholder="JohnX" id="id" name="id" class="text ui-widget-content ui-corner-all"/><? echo $errors1; ?>
				</tr>
			</table>
		<input name="button" type="submit" value="Add ID" />
		</form>
	<br><br>
        <h3>Created IDs</h3>
	<hr>
		<?php
			//retreive values from DB
			global $db;
			$kk="select * from Spy_ID";
			$results = $db->getAll($kk, DB_FETCHMODE_ASSOC);

 			echo "<table class='table text ui-widget-content ui-corner-all'>
                        	<thead>
                                	<tr class='ui-widget-header '>
                                		<th>Name</th>
                                                <th>ID</th>
                                                <th>Delete</th>
	                                </tr>
                                 </thead>
                                 <tbody>";
					foreach($results as $row){
						echo "<tr>";
						echo "<td>". $row['name'] ."</td>";
						echo "<td>". $row['id'] ."</td>";
                                                //echo "<td><button class='btn btn-info edid' value=". $row['id'] ."><i class='icon-edit icon-white'></i></a></td>";
                                                echo "<form name='fdelid' method='post' action=''><td><button  name='delid' value=". $row['id'].">DEL ID: ".$row['id']."</button></form></td>";
					
						
					}

                                                 echo "</tr>";
                                   echo "</tbody>
                           </table>";

?>

	<br><br>
	<h3>View Calls per ID</h3>
	<hr>	

		<?php
			global $db;
			$sql3="SELECT * from Spy_ID";
			$results1 = $db->getAll($sql3, DB_FETCHMODE_ASSOC);
			
			echo "<form name='f3' method='post' action=''>";
			echo "<select name='ids' id='ids' onchange='this.form.submit()' class='table text ui-widget-content ui-corner-all'><option value=''>-- --</option>";
			foreach($results1 as $row1){
				echo "<option value='". $row1['id'] ."'>". $row1['name'] ." - ". $row1['id'] ."</option>";

			}
			echo "</select></form>";
			

			if(isset($_POST['ids'])){
				$ids=$_POST['ids'];
				$sql4="SELECT * from Spy_ID_CDR where id='$ids'";
				$results2 = $db->getAll($sql4, DB_FETCHMODE_ASSOC);
				 echo "<br><p>ChanSpy did by  $ids</p><table class='table text ui-widget-content ui-corner-all'>
                                	<thead>
                                       		<tr class='ui-widget-header '>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Spyed</th>
                                                <th>From Exten</th>
                                        </tr>
                                 </thead>
                                 <tbody>";
                                        foreach($results2 as $row3){
                                                echo "<tr>";
                                                echo "<td>". $row3['date'] ."</td>";
                                                echo "<td>". $row3['name'] ."</td>";
                                                echo "<td>". $row3['id'] ."</td>";
                                                echo "<td>". $row3['spiedchan'] ."</td>";
                                                echo "<td>". $row3['fromext'] ."</td>";
                                                //echo "<td><button class='btn btn-info edid' value=". $row['id'] ."><i class='icon-edit icon-w$
                                                //echo "<form name='fdelid' method='post' action=''><td><button  name='delid' value=". $row['id']$


                                        }

                                                 echo "</tr>";
                                   echo "</tbody>
                           </table>";
			

			}

		?>
