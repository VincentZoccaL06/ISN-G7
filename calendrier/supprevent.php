<!DOCTYPE html PUBLIC >
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gestion de calendrier | Suppression d'événement</title>
    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" />
</head>
<body>
	<?php
		include("sql_connect.php");
		
		if(isset($_GET['id']) && is_numeric($_GET['id'])) {
			// Traitement de la suppression de l'événement
			$id = htmlentities($_GET['id']);
			
			$req = "DELETE FROM calendrier WHERE id_evenement = " .$id;
			mysqli_query($connection,$req);
			
			$req = "DELETE FROM evenements WHERE id_evenement = " .$id;
			mysqli_query($connection,$req);
			
			echo '<ul><li>Evénement supprimé !</li></ul>';
		}
		
		
		// Récupération des événements
		$req = "SELECT * FROM evenements";
		$evenements = mysqli_query($connection,$req);
		
		if(mysqli_num_rows($evenements)) $nbEvents = true;
		else $nbEvents = false;
		
		
		mysqli_close($connection);
	?>
    
	<h1>Supprimer un événement</h1>
	
    <?php
	if($nbEvents) {
		
		while($evenement = mysqli_fetch_array($evenements)) {
			echo '
			<table class="listeEvent">
				<tr><td>'.html_entity_decode($evenement['titre_evenement']).'</td></tr>
				<tr><td>'.html_entity_decode($evenement['contenu_evenement']).'</td></tr>
				<tr><td><a href="supprevent.php?id='.$evenement['id_evenement'].'">Supprimer</a></td></tr>
			</table>
			<br/><br/>
			';
		}
		
	} else {
		
		echo '<p>Il n\'y a pas d\'événements à supprimer</p>';
		
	}
	?>
    
    
    <p class="centre"><a href="calendrier.php">Revenir à l'accueil</a></p>
</body>
</html>
