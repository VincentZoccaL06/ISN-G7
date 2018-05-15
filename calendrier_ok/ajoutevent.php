<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


	<!-- affiche image de fond  -->
	<style>
	body{margin:0;padding:0;background: url(..design/fond5.png) no-repeat center fixed; /*image de fond*/
	background-size: cover; /*taille image de fond*/}
	</style> 

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Gestion de calendrier </title>
	    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" /> <!---appel des  fonction d' affichage  CSS -->
	</head>
	</head>

	<body>
		<?php
			// initialisation des Variables par défaut des champs
			$titre=""; 
			$description="";
			$dateDebut = date("d/m/Y", time());
			$dateFin = date("d/m/Y", time());
			# ajout  d' une image  
			if(isset($_POST['envoi'])) # si la  selectiond'une image est vrai
				{
					// recuperation par la commande  POST du bouton "envoi"  des variables titre, description , date... saisie par  l'utilisateur  dans les zones texte
					$titre = htmlentities(addslashes($_POST['titre'])); #convertion  en html et repére les caractères speciaux ' avec un \ devant pour une bonne interpretation 
					$description = nl2br(htmlentities(addslashes($_POST['description'])));
					$dateDebut = htmlentities($_POST['debut']);
					$dateFin = htmlentities($_POST['fin']);
					
					$typeDate = "#^[0-3]?[0-9]/[01]?[0-9]/[0-9]{4}$#"; # format de la date 
					
					if (preg_match($typeDate, $dateDebut) && preg_match($typeDate, $dateFin)) 
						{
								$tabDateDeb = explode("/", $dateDebut);
								$timestampDebut = mktime(0, 0, 0, $tabDateDeb[1], $tabDateDeb[0], $tabDateDeb[2]);
								
								$tabDateFin = explode("/", $dateFin);
								$timestampFin = mktime(0, 0, 0, $tabDateFin[1], $tabDateFin[0], $tabDateFin[2]);
								
								$timestampDiff = $timestampFin - $timestampDebut; 
								$nbreJours = intval($timestampDiff / 86400)+1; # calcul du nombres de jour 86400 sec = 1 jour
								if($nbreJours <= 0) $nbreJours = 1;					
								 # verifie  si le titre ou  evenement  n' est pas vide						
								if(!empty($titre) && !empty($description) )
								{
									// Traitement de l'enregistrement de l'événement
									$identifiantCommun = time(); # calcul d 'un iddentifiant  en fonction de  l'heure et la date'
									$timeDuJour = $timestampDebut;
									# appel de la connection à la  base 
									include("sql_connect.php");
									# test ---
									//print_r($_FILES);
									//$img = $_FILES ['img'];
									//$adresse_image = $img['tmp_name'];
									//$nom_image = $img['img'];

									# si une image est selectionnée  controle du  contenu   selectionné avec  parcourrir 
									if (!empty($_FILES['img']['name']))
									{
										# intitialisation des variables(type ,nom, adresse..) retournées  par la commande $_FILES ~ $POST du bouton  name=img
										$nom_photo= addslashes($_FILES['img']['name']);
										$tmp_photo = addslashes(file_get_contents($_FILES['img']['tmp_name']));
										//$type_photo = base64_encode($img_photo);
										$type_photo=addslashes($_FILES['img']['type']);
									}
									else # si par  de selection ne rien enregistrer
									{
										$nom_photo= "";
										$tmp_photo= "";
									}
									#controle du nombre de jour je la periode  choisie
									for($i=0 ; $i<$nbreJours ; $i++)
										{
											# requette  insertion  dans la table evenement   des differentes variables ( id,date.... nom photo ....)
											$req = "INSERT INTO date_evenement  VALUES ('', ".date('d', $timeDuJour).", ".date('m', $timeDuJour).", ".date('Y', $timeDuJour).", $identifiantCommun, '$titre', '$description','$tmp_photo','$nom_photo')";
											//echo $req; 
											# execute la requette 
											mysqli_query($connection,$req) or die(mysqli_error($connection));
											
											$timeDuJour += 86400; // On augmente le timestamp d'un jour pour  un identifiant  different par jour 
										}
													
									mysqli_close($connection); # fermeture de la connection à la base
								
									echo '<ul>enregistrement effectué</ul>'; # affiche un message   de validation
								} 
							else
								 {echo '<ul><li>Titre ou description de l\'événement non renseigné.</li></ul>';}  # affiche un message si pas de titre ou description 
						}
					else
						{echo '<ul><li>Date de début ou de fin d\'événement non conforme (ex. 12/02/2008).</li></ul>';}# affiche un message  si erreur sur les dates
				}
		?>
	    
	    <!-- Formulaire d'enregistrement  affichage des zones de saisie  et boutons sur la page html -->
		<h1>Ajouter un événement</h1>
	    
	    <form method="post" action="ajoutevent.php" enctype = "multipart/form-data"> <!--- gestion des bouton par POST por recuperation de  differentes données saisies  quand un bouton est actionner ( action="ajoutevent.php" ) retour  au debut  de la page  --->
	    	<!--  structure de la page  --->
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
	            	<td colspan="2"><input type = "file" name = "img" /><br></br> <!--- bouton  img de  type file => permet la recheche  d' fiche  parcourrir --->
	            					<input type="submit" name="envoi" value="Enregistrer"/> <!---bouton  ' d'enregistrement   --->
	            				</td>
	            </tr>
			</table>
		</form>
	    

	</body>
	  
	 <p class="centre"><br/><a href="calendrier.php"><img src="design/retour.png"></a></p> <!--- retour à la page calendrier.php --->

	</script>

</html>