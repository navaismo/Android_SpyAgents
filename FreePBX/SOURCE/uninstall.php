<?php
/* $Id$ */
global $db;
global $amp_conf;

out(_("Uninstalling Spy Agents"));
if (! function_exists("out")) {
	function out($text) {
		echo $text."<br />";
	}
}

if (! function_exists("outn")) {
	function outn($text) {
		echo $text;
	}
}

$sql="DROP TABLE Spy_ID";
$sql2="DROP TABLE Spy_ID_CDR";
out(_("Removing Database!"));
$check = $db->query($sql);
$check = $db->query($sql2);

?>
