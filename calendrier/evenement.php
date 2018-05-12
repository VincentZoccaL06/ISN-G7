<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Gestion de calendrier | Evenement</title>
    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" />
</head>
<body>
	<?php
		$typeDate = "#^[0-3]?[0-9]/[01]?[0-9]/[0-9]{4}$#";
		
		if(isset($_GET['d']) && preg_match($typeDate, $_GET['d'])) {
			// Traitement de l'affichage
			$date = htmlentities($_GET['d']);
			$tabDate = explode('/', $date);
			
			$req = "SELECT * FROM date_evenement WHERE id_evenement IN (SELECT id_evenement FROM date_evenement WHERE jour_evenement=".$tabDate[0]." AND mois_evenement=".$tabDate[1]." AND annee_evenement=".$tabDate[2].")";
			//echo $req ;

			include("sql_connect.php");

			$date_evenement = mysqli_query($connection,$req);
			
			if(mysqli_num_rows($date_evenement)) {
				while($date_evenements = mysqli_fetch_array($date_evenement)) {
					echo '
						<table class="listeEvent">
							
							<tr>
								<th>'.$date_evenements['jour_evenement'].'/'.$date_evenements['mois_evenement'].'/'.$date_evenements['annee_evenement'].'	
								</th> 
							<tr>
							</tr>
								<th>'
								.$date_evenements['titre_evenement'].'
								</th>
							</tr>
							<tr>
								<td>
								'.$date_evenements['contenu_evenement'].'
								</td>
							</tr>

						</table>
						
						
					';
					//affichage  de la phot lie a  l'evenement au dimention 150*150 si elle existe
					if(!empty($date_evenements['photo']))
					{
					echo '<img height ="150" width="150" src="data:image;base64,'.base64_encode($date_evenements['photo']).'"></br>';
					}
					else{}
					//echo $date_evenements['photo'];
				}
				
			} else {
				echo '<p>Il n\'y a aucun événement pour cette date.</p>';
			}
			
			mysqli_close($connection);
		}
		
		echo '<p class="centre"><a href="calendrier.php">Revenir au calendrier</a></p>'
	?>
</body>
</html>
