<?php
	mysql_connect("localhost", "root", "");
	mysql_select_db("MySomeBD") or die (mysql_error());
	mysql_query('SET character_set_database = utf8');
	mysql_query("SET NAMES 'utf8'");
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
?>