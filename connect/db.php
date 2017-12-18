<?php
// Datenbankverbindung erstellen LOCAL
$hostname_user = "localhost";
$database_user = "goandfly";
$username_user = "root";
$password_user = "";
$user = mysql_pconnect($hostname_user, $username_user, $password_user) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_user, $user);

// Datenbankverbindung erstellen SERVER
/*$hostname_user = "localhost";
$database_user = "d017956f";
$username_user = "d017956f";
$password_user = "veQfmf882Z3FCGpE";
$user = mysql_pconnect($hostname_user, $username_user, $password_user) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_user, $user);*/
?>