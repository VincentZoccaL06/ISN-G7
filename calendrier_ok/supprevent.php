<!DOCTYPE html PUBLIC >
<html >
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>Gestion de calendrier</title>
	    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" /> <!---appel des  fonction d' affichage  CSS -->
		</head>
	</head>
	<body>
		<?php
			include("sql_connect.php");

			// si suppression validé
			if(isset($_GET['id']) && is_numeric($_GET['id']))
			{
				// Traitement de la suppression de l'événement
				$id = htmlentities($_GET['id']);
				# supprime  dans  la table date_evenemenr la selection 
				$req = "DELETE FROM date_evenement WHERE id_evenement = " .$id;
				//echo $req ;
				mysqli_query($connection,$req);# execution de la requette 
				
				echo '<ul> suppression effectuée</ul>';
			}
			
			
			// Récupération des événements par la requette  (selectionne * =tous de la table date_evenement)
			$req = "SELECT * FROM date_evenement";
			$evenements = mysqli_query($connection,$req);

			# s'il y en à
			if(mysqli_num_rows($evenements)) $nbEvents = true;
			else $nbEvents = false;
			
			
			mysqli_close($connection); # fermeture  de la base de donnée
		?>
	    
		<h1>Supprimer un événement</h1>
		
	    <?php

	        // affiche les evevenments à supprimer 
			if($nbEvents)
				{
				
					while($evenement = mysqli_fetch_array($evenements))
						{
							if(!empty($evenement['photo']))
								{
									echo'
											<table class="listeEvent">
												<tr>
													<th><h2>'.$evenement['jour_evenement'].'/'.$evenement['mois_evenement'].'/'.$evenement['annee_evenement'].'</h2></th> 
												<tr>
												<tr><td>
													<h3>'.html_entity_decode($evenement['titre_evenement']).':</h3>
												</td></tr>
												<tr><td>
													<h4>'.html_entity_decode($evenement['contenu_evenement']).'</h4>
												</td></tr>
												<td>
												<a href="supprevent.php?id='.$evenement['id_evenement'].'"><img src="design/corb.png"></a>
												<p align="center"><img height ="120" width="120"  src="data:image;base64,'.base64_encode($evenement['photo']).'">
												</td>
												</tr>

											</table>
										';
								}
								else
								{
									echo '
											<table class="listeEvent">
												<tr>
													<th><h2>'.$evenement['jour_evenement'].'/'.$evenement['mois_evenement'].'/'.$evenement['annee_evenement'].'</h2>	
													</th> 
												<tr>
												<tr><td><h3>'.html_entity_decode($evenement['titre_evenement']).':</h3></td></tr>
												<tr><td><h4>'.html_entity_decode($evenement['contenu_evenement']).'</h4</td></tr>
												<tr><td><a href="supprevent.php?id='.$evenement['id_evenement'].'"><img src="design/corb.png"></a></td></tr>

											</table>
						    			';	
								}		
						
						}
				} 
				else {echo '<p>Il n\'y a pas d\'événements à supprimer</p>';}
		?>
	    
	    <p class="centre"><a href="calendrier.php"><img src="design/retour.png"></a></p>
	</body>
</html>
