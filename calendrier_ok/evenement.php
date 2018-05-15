<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Gestion de calendrier </title>
	    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" /> <!---appel des  fonction d' affichage  CSS -->
	</head>
	<body>
		<?php
			$typeDate = "#^[0-3]?[0-9]/[01]?[0-9]/[0-9]{4}$#";
			
			if(isset($_GET['d']) && preg_match($typeDate, $_GET['d']))
			 {
				// Traitement de l'affichage
				$date = htmlentities($_GET['d']);
				$tabDate = explode('/', $date);
				
				$req = "SELECT * FROM date_evenement WHERE id_evenement IN (SELECT id_evenement FROM date_evenement WHERE jour_evenement=".$tabDate[0]." AND mois_evenement=".$tabDate[1]." AND annee_evenement=".$tabDate[2].")";
				//echo $req ;

				include("sql_connect.php");

				$date_evenement = mysqli_query($connection,$req);
				
				if(mysqli_num_rows($date_evenement))
				{
					while($date_evenements = mysqli_fetch_array($date_evenement)) {
						# si il y a un photo  afficher  la date  le titre  le contenu et la photo
							# ligne de commande pour afficher la photo avec  dimention 250*250
						#<p align="center"> <img height ="250" width="250" src="data:image;base64,'.base64_encode($date_evenements['photo']).'"></br></td> 

						if(!empty($date_evenements['photo']))
						{
							echo '
									<table class="listeEvent">
										
										<tr>
											<th><h2>'.$date_evenements['jour_evenement'].'/'.$date_evenements['mois_evenement'].'/'.$date_evenements['annee_evenement'].'</h2>	
											</th> 
										<tr>
										</tr>
											<th><h3>'
											.$date_evenements['titre_evenement'].'</h3>
											</th>
										</tr>
										<tr>
											<td><h4>
											'.$date_evenements['contenu_evenement'].'</h4>

											<p align="center"> <img height ="250" width="250" src="data:image;base64,'.base64_encode($date_evenements['photo']).'"></br></td> 
										</tr>
									</table>						
								';
						}
						else     #  n' affiche pas la photo
						{
							echo '
									<table class="listeEvent">
										
										<tr>
											<th><h2>'.$date_evenements['jour_evenement'].'/'.$date_evenements['mois_evenement'].'/'.$date_evenements['annee_evenement'].'</h2>	
											</th> 
										<tr>
										</tr>
											<th><h3>'
											.$date_evenements['titre_evenement'].'</h3>
											</th>
										</tr>
										<tr>
											<td><h4>
											'.$date_evenements['contenu_evenement'].'</h4>
													</td></tr>

									</table>
													
								';
						}	
						
						
					}
					
				} 
				else {echo '<p>Il n\'y a aucun événement pour cette date.</p>';}
				
				mysqli_close($connection);
			}
			
			echo '<p class="centre"><a href="calendrier.php"><img src="design/retour.png"/p>'
		?>
	</body>
</html>
