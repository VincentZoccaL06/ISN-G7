
<?php
	/**connection à la base de donnée  mysql nom = vincent  lieu = pc en local  not de passe =root**/ 
	$connection = mysqli_connect("localhost","root","","vincent");
		// gestion des erreurs de connection et selection 
	
	if (!$connection)
		{die("Database connection failed: " . mysqli_connect_error());}

	// 2. Selection de la base de donnée  
	$db_select = mysqli_select_db($connection, "vincent");


	if (!$db_select) 
		{die("Database selection failed: " . mysqli_error($connection));}
?>
