<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<!-- affiche image de fond  -->
<style>
body{margin:0;padding:0;background: url(../star7.jpg) no-repeat center fixed; /*image de fond*/
background-size: cover; /*taille image de fond*/
	}
</style> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Gestion de calendrier | Ajout d'événement</title>
    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" />
</head>
<body>
	<?php
		// Variables vides pour les valeurs par défaut des champs
		$titre=""; $description=""; $dateDebut = date("d/m/Y", time()); $dateFin = date("d/m/Y", time());
		
		if(isset($_POST['envoi'])) {
			// Traitement de l'envoi de l'événement
			$titre = htmlentities(addslashes($_POST['titre']));
			$description = nl2br(htmlentities(addslashes($_POST['description'])));
			$dateDebut = htmlentities($_POST['debut']);
			$dateFin = htmlentities($_POST['fin']);
			
			$typeDate = "#^[0-3]?[0-9]/[01]?[0-9]/[0-9]{4}$#";
			
			if (preg_match($typeDate, $dateDebut) && preg_match($typeDate, $dateFin)) {
				$tabDateDeb = explode("/", $dateDebut);
				$timestampDebut = mktime(0, 0, 0, $tabDateDeb[1], $tabDateDeb[0], $tabDateDeb[2]);
				
				$tabDateFin = explode("/", $dateFin);
				$timestampFin = mktime(0, 0, 0, $tabDateFin[1], $tabDateFin[0], $tabDateFin[2]);
				
				$timestampDiff = $timestampFin - $timestampDebut;
				$nbreJours = intval($timestampDiff / 86400)+1;
				if($nbreJours <= 0) $nbreJours = 1;


				//&& !empty($_POST['img']
				
				
				
				if(!empty($titre) && !empty($description) ) {
					// Traitement de l'enregistrement de l'événement
					$identifiantCommun = time();
					$timeDuJour = $timestampDebut;
					
					include("sql_connect.php");
					//print_r($_FILES);
					//$img = $_FILES ['img'];
					//$adresse_image = $img['tmp_name'];
					//$nom_image = $img['img'];
					if (!empty($_FILES['img']['name']))
					{
					$nom_photo= addslashes($_FILES['img']['name']);
					$tmp_photo = addslashes(file_get_contents($_FILES['img']['tmp_name']));
					//$type_photo = base64_encode($img_photo);
					$type_photo=addslashes($_FILES['img']['type']);
					}
					else
					{
					$nom_photo= "";
					$tmp_photo= "";
					}

					for($i=0 ; $i<$nbreJours ; $i++) {
						$req = "INSERT INTO date_evenement  VALUES ('', ".date('d', $timeDuJour).", ".date('m', $timeDuJour).", ".date('Y', $timeDuJour).", $identifiantCommun, '$titre', '$description','$tmp_photo','$nom_photo')";
						//echo $req;
						mysqli_query($connection,$req) or die(mysqli_error($connection));
						
						$timeDuJour += 86400; // On augmente le timestamp d'un jour
					}
										
					mysqli_close($connection);
					
					echo '<ul><li>Evénement enregistré !</li></ul>';
				} else {
					echo '<ul><li>Titre ou description de l\'événement non renseigné.</li></ul>';
				}
			}
			else
			{
				echo '<ul><li>Date de début ou de fin d\'événement non conforme (ex. 12/02/2008).</li></ul>';
			}
		}
	?>
    
    <!-- Formulaire d'envoi -->
	<h1>Ajouter un événement</h1>
    
    <form method="post" action="ajoutevent.php" enctype = "multipart/form-data">
    	<table id="tabAjoutEvent">
        	<tr>
            	<td><label>Du : <input type="text" name="debut" value="<?php echo $dateDebut ?>" /></label></td>
                <td><label>Au : <input type="text" name="fin" value="<?php echo $dateFin; ?>" /></label></td>
            </tr>
       		<tr>
       			<td colspan="2"><br/>
                	<label for="titre">Titre de l'événement :</label><br/>
       				<input type="text" name="titre" id="titre" size="30" value="<?php echo $titre ?>" /><br/><br/>
                </td>
       		</tr>
            <tr>
            	<td colspan="2">
       				<label for="description">Description de l'événement :</label><br/>
       				<textarea rows="10" cols="50" id="description" name="description"><?php echo $description ?></textarea>
                </td>
            </tr>
            <tr>
            	<td colspan="2"><input type = "file" name = "img" /><br></br>
            					<input type="submit" name="envoi" value="Enregistrer"/></td>
            </tr>
		</table>
	</form>
    

</body>  
 <p class="centre"><br/><a href="calendrier.php">Revenir à l'accueil</a></p>
</script>

</html>