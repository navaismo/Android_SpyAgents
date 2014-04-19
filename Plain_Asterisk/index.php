<head>
	<title>Digital-Merge Spy Agents GUI</title>
</head>
<script type="text/javascript" src="./assets/js/jquery.js"></script>
<link href="./assets/css/bootstrap.css" rel="stylesheet" />
<link href="./assets/css/bootstrap-responsive.css" rel="stylesheet" />
<br>
<?php
include "loginsql.php";
//catch values
if(isset($_POST['button'])){
        $name=$_POST['name'];
        $id=$_POST['id'];
	//if one value is empty display the required label
	if( $name == '' ){
		//alert('all data required');
		 $errors1 = '<span class="label label-important">Required</span>';
	}elseif( $id == '' ){
		//alert('all data required');
		 $errors1 = '<span class="label label-important">Required</span>';

	}else{


		//insert new data
		$sql="INSERT INTO Spy_ID(name,id) Values('$name','$id')";
		mysql_query($sql);

	}	


}

if(isset($_POST['delid'])){
	$id=$_POST['delid'];

	$sql ="DELETE from Spy_ID where id='$id'";
	mysql_query($sql);
}


?>


<div class="box-header well span5" data-original-title>
	 	<h3>Create New ID</h3>
			<form method="post" id="form1" action="">
				<table class="table table-stripped table-condensed">
					<tr>
						<td><label for="name">Name</label></td><td><input type="text" placeholder="John Doe" id="name" name="name" class="text ui-widget-content ui-corner-all"/><? echo $errors1; ?>
					</tr>
					<tr>
						<td><label for="id">ID</label></td><td><input type="text" placeholder="JohnX" id="id" name="id" class="text ui-widget-content ui-corner-all"/><? echo $errors1; ?>
					</tr>
				</table>
				<input name="button" type="submit" value="Add ID" class="btn btn-success" />
				</form>
</div>
<br>
<div class="box-header well span8" data-original-title>	
        <h3>Created IDs</h3>
		<?php
			//retreive values from DB
			//global $db;
			include "loginsql.php";
			$kk="select * from Spy_ID";
			$results = mysql_query($kk);

 			echo "<table class='table table-stripped table-condensed'>
                        	<thead>
                                	<tr class='ui-widget-header '>
                                		<th>Name</th>
                                                <th>ID</th>
                                                <th>Delete</th>
	                                </tr>
                                 </thead>
                                 <tbody>";
					while($row = mysql_fetch_array($results)){
						echo "<tr>";
						echo "<td>". $row['name'] ."</td>";
						echo "<td>". $row['id'] ."</td>";
                                                //echo "<td><button class='btn btn-info edid' value=". $row['id'] ."><i class='icon-edit icon-white'></i></a></td>";
                                                echo "<form name='fdelid' method='post' action=''><td><button class='btn btn-danger' name='delid' value=". $row['id'].">ID: ".$row['id']. "<i class='icon-trash icon-white'></i></button></form></td>";
					
						
					}

                                                 echo "</tr>";
                                   echo "</tbody>
                           </table>";

?>
</div>
<br>
<div class="box-header well span8" data-original-title>
	<h3>View Calls per ID</h3>

		<?php
			global $db;
			$sql3="SELECT * from Spy_ID";
			$results1 = mysql_query($sql3);
			
			echo "<form name='f3' method='post' action=''>";
			echo "<select size='' name='ids' id='ids' onchange='this.form.submit()' class='table text ui-widget-content ui-corner-all'><option value=''>-- --</option>";
			while($row1 = mysql_fetch_array($results1)){
				echo "<option value='". $row1['id'] ."'>". $row1['name'] ." - ". $row1['id'] ."</option>";

			}
			echo "</select></form>";
			

			if(isset($_POST['ids'])){
				$ids=$_POST['ids'];
				$sql4="SELECT * from Spy_ID_CDR where id='$ids'";
				$results2 = mysql_query($sql4);
				 echo "<p class='label label-inverse'>ChanSpy did by  $ids</p><table class='table text ui-widget-content ui-corner-all'>
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
					while($row3 = mysql_fetch_array($results2)){
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
</div>
