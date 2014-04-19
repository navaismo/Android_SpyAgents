<?php
/* $Id$ */
global $db;
global $amp_conf;

out(_("Installing Spy Agents"));
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

$sql = "CREATE TABLE `Spy_ID` (
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
);";

$sql2 = "CREATE TABLE `Spy_ID_CDR` (
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `spiedchan` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fromext` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'

);";

out(_("Installing Database!"));

$check = $db->query($sql);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `Spy_ID` table: " . $check->getMessage() .  "\n");
}
$check = $db->query($sql2);
if (DB::IsError($check)) {
        die_freepbx( "Can not create `Spy_ID_CDR` table: " . $check->getMessage() .  "\n");
}

$spy_src = $amp_conf['AMPWEBROOT']."/admin/modules/spyagents";
exec("cp -f $spy_src/getchans.php  /var/www/html");
exec("cp -f $spy_src/spy.php  /var/www/html");

?>
