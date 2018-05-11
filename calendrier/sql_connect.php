<?php
	/**connection a la base de donnee  mysql vincent**/
	$connection = mysqli_connect("localhost","root","","vincent");
if (!$connection) 
{
    die("Database connection failed: " . mysqli_connect_error());
}
// 2. Selection de la base de donne 
$db_select = mysqli_select_db($connection, "vincent");
if (!$db_select) 
{
    die("Database selection failed: " . mysqli_error($connection));
}
?>
