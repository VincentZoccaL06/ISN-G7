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
			
			if(isset($_POST['envoi'])) 
				{
					// récupération par la commande  POST du bouton "envoi"  des variables titre, description , date... saisie par  l'utilisateur  dans les zones textes.
					$titre = htmlentities(addslashes($_POST['titre'])); #convertion  en html et repère les caractères spéciaux ' avec un \ devant pour une bonne interprétation 
					$description = nl2br(htmlentities(addslashes($_POST['description'])));
					$dateDebut = htmlentities($_POST['debut']);
					$dateFin = htmlentities($_POST['fin']);
					
					$typeDate = "#^[0-3]?[0-9]/[01]?[0-9]/[0-9]{4}$#"; # format de la date 
					
					if (preg_match($typeDate, $dateDebut) && preg_match($typeDate, $dateFin)) # test si les dates sont au bon format
						{
								$tabDateDeb = explode("/", $dateDebut);
								$timestampDebut = mktime(0, 0, 0, $tabDateDeb[1], $tabDateDeb[0], $tabDateDeb[2]);
								
								$tabDateFin = explode("/", $dateFin); # explode coupe une chaine en segment  
								$timestampFin = mktime(0, 0, 0, $tabDateFin[1], $tabDateFin[0], $tabDateFin[2]);
								
								$timestampDiff = $timestampFin - $timestampDebut; 
								$nbreJours = intval($timestampDiff / 86400)+1; # calcul du nombres de jours 86400 sec = 1 jour
								if($nbreJours <= 0) $nbreJours = 1;										
								if(!empty($titre) && !empty($description) ) # vérifie  si le titre ou évènement n'est pas vide	
								{
									// Traitement de l'enregistrement de l'évènement-----------------------------------
									$identifiantCommun = time(); # calcul d'un identifiant en fonction de l'heure et la date
									$timeDuJour = $timestampDebut;
									 
									include("sql_connect.php"); # appel de la connection à la base
									
									// Traitemnt de l'enregitrement de l'image------------------------------------------
									if (!empty($_FILES['img']['name']))# si une image est selectionnée
									{
										# intitialisation des variables(type ,nom, adresse..) retournées par la commande $_FILES ~ $_POST du bouton  name=img
										$nom_photo= addslashes($_FILES['img']['name']); #convertion en html et repère les caractères spéciaux ' avec un \ devant pour une bonne interprétation du php
										$tmp_photo = addslashes(file_get_contents($_FILES['img']['tmp_name'])); # récupère la photo
									}
									else # si par de selection ne rien enregistrer
									{
										$nom_photo= "";
										$tmp_photo= "";
									}
									
									for($i=0 ; $i<$nbreJours ; $i++) #controle du nombre de jour je la periode  choisie
										{
											
											$req = "INSERT INTO date_evenement  VALUES ('', ".date('d', $timeDuJour).", ".date('m', $timeDuJour).", ".date('Y', $timeDuJour).", $identifiantCommun, '$titre', '$description','$tmp_photo','$nom_photo')";  # requette  insertion  dans la table evenement des differentes variables ( id,date.... nom photo ....)
											//echo $req; 
										
											mysqli_query($connection,$req) or die(mysqli_error($connection));	# execute la requette 
											
											$timeDuJour += 86400; // On augmente le timestamp d'un jour=86400s pour un identifiant different par jour 
										}
													
									mysqli_close($connection); # fermeture de la connection à la base
								
									echo '<ul>enregistrement effectué</ul>'; # affiche un message de validation
								} 
							else
								 {echo '<ul><li>Titre ou description de l\'événement non renseigné.</li></ul>';}  # affiche un message si pas de titre ou description 
						}
					else
						{echo '<ul><li>Date de début ou de fin d\'événement non conforme (ex. 12/02/2008).</li></ul>';}# affiche un message si erreur sur les dates
				}
		?>
	    
	    <!-- Formulaire d'enregistrement, affichage des zones de saisie et boutons sur la page html -->
		<h1>Ajouter un événement</h1>
	    
	    <form method="post" action="ajoutevent.php" enctype = "multipart/form-data"> <!--- Gestion des boutons compris dans la balise « form » (formulaire) par la méthode « POST » qui récupère les différentes données saisies dans les zones textes.Lorsqu’un bouton est actionner celui-ci permet le retour au début de la page « boucle » (action="ajoutevent.php»).--->
	    	<!--  structure de la page  --->
	    	<table id="tabAjoutEvent">
	        	<tr>
	            	<td><label>Du : <input type="text" name="debut" value="<?php echo $dateDebut ?>" /></label></td>  <!-- créé une variable $dateDebut contenant la date du début de l'évènement saisi ---> 
	                <td><label>Au : <input type="text" name="fin" value="<?php echo $dateFin; ?>" /></label></td>  <!-- créé une variable $dateFin contenant la date de fin de l'évènement saisi ---> 
	       		<tr>
	       			<td colspan="2"><br/>
	                	<label for="titre">Titre de l'événement :</label><br/>
	       				<input type="text" name="titre" id="titre" size="30" value="<?php echo $titre ?>" /><br/><br/>  <!-- créé une variable $titre contenant le titre de l'évènement saisi --->
	                </td>
	       		</tr>
	            <tr>
	            	<td colspan="2">
	       				<label for="description">Description de l'événement :</label><br/>
	       				<textarea rows="10" cols="50" id="description" name="description"><?php echo $description ?></textarea>  <!-- créé une variable $description contenant la description de l'évènement saisi --->
	                </td>
	            </tr>
	            <tr>
	            	<td colspan="2"><input type = "file" name = "img" /><br></br> <!--- bouton "img" de type file => permet la recheche d'un fichier avec parcourrir --->
	            					<input type="submit" name="envoi" value="Enregistrer"/> <!---bouton d'enregistrement   --->
	            				</td>
	            </tr>
			</table>
		</form>
	    

	</body>
	  
	 <p class="centre"><br/><a href="calendrier.php"><img src="design/retour.png"></a></p> <!--- retour à la page calendrier.php --->

	</script>

</html>