<?php

 // Connects to Our Database 
 mysql_connect("localhost", "pdbuser", "pdbpass") or die(mysql_error()); 
 mysql_select_db("pdbname") or die(mysql_error()); 

 ?> 
