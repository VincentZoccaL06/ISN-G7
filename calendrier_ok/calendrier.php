<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<!--  affichage titre dans onglet  -->
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>Gestion de calendrier </title>
	    <link rel="stylesheet" type="text/css" href="design/calendrier.css" media="screen" /> <!---appel des  fonction d' affichage  CSS -->
	</head>
	</head>


	<body>
		<!--  affichage du titre dans la page html  -->
		<h1>Calendrier </h1>
		<!--  affichage de la date du jour-->
		<h1><?php echo ("Nous sommes le :").date('d/m/Y') ?></h1>

		<ul>
			<!--affichage  raccourci menu   -->
    		<h1><a href="ajoutevent.php"><img src="design/ajouter.png">ajouter un évenement</a>
        	<a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </a> <!-- espace-->
        	<a href="supprevent.php"><img src="design/supprimer.png">supprimer un évenement</a></h1>
    	</ul>  

		<?php
			#  creation de la fonction  gestion des evenements ----------------

			function getEventsDate($mois, $annee)
				{
					$result = array(); # # stock  result dans un tableau 
					
					include("sql_connect.php"); # appel connection basse de données 
					# requette recupére dans la table date_evenement  le jour  et tire  du mois et année en cours et  les trie par  jour d'evenement.
					
					$sql = 'SELECT DISTINCT jour_evenement, titre_evenement FROM date_evenement WHERE mois_evenement='.$mois.' AND annee_evenement='.$annee.' ORDER BY jour_evenement';
					
					#execute le requette  
					$query = mysqli_query($connection,$sql) or die("Une requête a échouée.");
					# parcours le tableau  de 2 colonne 'jour (row0) et titre(row1)  les stock dans le tableau resultat tant qu il y a  des données
					while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) 
					{
						$result[] = $row[0];
						$result[] = $row[1];
					}
					# fermeture de la base 
					mysqli_close($connection);
					
					return $result;
				}
			#  creation de la fonction  affichage des evenements ----------------

			function afficheEvent($i, $event)
				{
					$texte = "";
					$suivant = false;	
					foreach($event as $cle => $element) 
					{
						if($suivant)
							{$texte .= $element."<br/>";}
						if($element == $i) 
							{$suivant = true;}
						else
							{$suivant = false;}
					}
					
					return $texte;
				}

			#   ----------------

			if(isset($_GET['m']) && isset($_GET['y']) && is_numeric($_GET['m']) && is_numeric($_GET['y'])) 
				{
					$timestamp = mktime(0, 0, 0, $_GET['m'], 1, $_GET['y']);
					$event = getEventsDate($_GET['m'], $_GET['y']); // Récupère les jour où il y a des évènements
				}
			// Si on ne récupère rien dans l'url, on prends la date du jour
			else 
				{ 
					$timestamp = mktime(0, 0, 0, date('m'), 1, date('Y'));
					$event = getEventsDate(date('m'), date('Y')); // Récupère les jour où il y a des évènements
				}
			
			
			// ------- Si le mois correspond au mois actuel et l'année aussi, on retient le jour actuel pour le griser plus tard (sinon le jour actuel ne se situe pas dans le mois)

			if(date('m', $timestamp) == date('m') && date('Y', $timestamp) == date('Y')) $coloreNum = date('d');
			
				$m = array("01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril", "05" => "Mai", "06" => "Juin", "07" => "Juillet", "08" => "Août", "09" => "Septembre", "10" => "Octobre",  "11" => "Novembre", "12" => "Décembre");
				$j = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
				$numero_mois = date('m', $timestamp);
				$annee = date('Y', $timestamp);
			
			if($numero_mois == 12) 
				{
					$annee_avant = $annee;
					$annee_apres = $annee + 1;
					$mois_avant = $numero_mois - 1;
					$mois_apres = 01;
				}
			elseif($numero_mois == 01) 
				{
					$annee_avant = $annee - 1;
					$annee_apres = $annee;
					$mois_avant = 12;
					$mois_apres = $numero_mois + 1;
				}
			else 
				{
					$annee_avant = $annee;
					$annee_apres = $annee;
					$mois_avant = $numero_mois - 1;
					$mois_apres = $numero_mois + 1;
				}
			
			// 0 => Dimanche, 1 => Lundi, 2 = > Mardi...
			$numero_jour1er = date('w', $timestamp);
			
			// Changement du numéro du jour car l'array commence à l'indice 0
			if ($numero_jour1er == 0) $numero_jour1er = 6; // Si c'est Dimanche, on le place en 6ème position (après samedi)
			else $numero_jour1er--; // Sinon on mets lundi à 0, Mardi à 1, Mercredi à 2...
		?>
	    
		<table class="calendrier">
			<!--affichage du mois en cours  est selection  des mois suivant ou precedant  -->
			<caption><h1><?php echo '<a href="?m='.$mois_avant.'&amp;y='.$annee_avant.'"><img src="design/fg.png"></a>  '.$m[$numero_mois].' '.$annee.'  <a href="?m='.$mois_apres.'&amp;y='.$annee_apres.'"><img src="design/fd.png"></a>'; ?></h1></caption>
			
			<!--  affichage  des jours de la semaine dans le tableau  -->
			<tr><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th><th>Dimanche</th></tr>
			<?php
				// Ecriture de la 1ère ligne
				echo '<tr>';
					// Ecriture des colones vides tant que le mois ne démarre pas
					for($i = 0 ; $i < $numero_jour1er ; $i++)
						{echo '<td></td>';	}
					for($i = 1 ; $i <= 7 - $numero_jour1er; $i++)
					{
						// Ce jour possède un événement
						if (in_array($i, $event)) 
							{
								echo '<td class="jourEvenement'; # grise le jour de l'évenement  appel  a la classe dans le css
								if(isset($coloreNum) && $coloreNum == $i) echo ' lienCalendrierJour';
								echo '"><a href="evenement.php?d='.$i.'/'.$numero_mois.'/'.$annee.'" class="info">'.$i.'<span>'.afficheEvent($i, $event).'</span></a></div></td>'; # affiche l'évenement  en pop up "block"
							} 
						else 	
						{
							echo '<td ';
							if(isset($coloreNum) && $coloreNum == $i) echo 'class="lienCalendrierJour"';
							echo '>'.$i.'</td>';
						}

					}
				echo '</tr>';
				# ecriture des lignes suivantes
				$nbLignes = ceil((date('t', $timestamp) - ($i-1))/ 7); // Calcul du nombre de lignes à afficher en fonction de la 1ère (surtout pour les mois à 31 jours)
				
				for($ligne = 0 ; $ligne < $nbLignes ; $ligne++) 
					{
						echo '<tr>';
						for($colone = 0 ; $colone < 7 ; $colone++)
						{
							if($i <= date('t', $timestamp))	
							{
								// Ce jour possède un événement
								if (in_array($i, $event)) 
								{
									echo '<td class="jourEvenement';
									if(isset($coloreNum) && $coloreNum == $i) echo ' lienCalendrierJour';
									echo '"><a href="evenement.php?d='.$i.'/'.$numero_mois.'/'.$annee.'" class="info">'.$i.'<span>'.afficheEvent($i, $event).'</span></a></td>';
								} else
								{
									echo '<td ';
									if(isset($coloreNum) && $coloreNum == $i) echo 'class="lienCalendrierJour"';
									echo '>'.$i.'</td>';
								}
							} 
							else 
								{echo '<td></td>';}
								$i = $i +1;
						}
							echo '</tr>';
					}

					#--------------------------suppression auto 1 mois avant--------------- 

					$ref=1;
				for($i=0; $i<$ref; $i++)
				{ #pour le faire 1 seule fois
					$mois=date('m');
					$mois_suppr= date("m",strtotime("- 1 month")); 
					//echo $mois_suppr;
					$annee1=date('Y');
					include("sql_connect.php");
					$suppr='DELETE FROM date_evenement WHERE mois_evenement<='.$mois_suppr.' AND annee_evenement<='.$annee1.''; #requete de suppr
					$query = mysqli_query($connection,$suppr) or die("Une requête a échouée.");
					mysqli_close($connection);

					#--------Pour la suppression des donnee de l'annee precedente----------	

					//$rempla=strtotime($annee1.'-01-01');
					$annee_a_suppr=date($annee1.'-01-31');
					$date_du_jour=date("Y-m-d");
					$annee_a_delete=date("Y",strtotime("- 1 year"));
					//echo $annee_a_suppr;
					//echo $date_du_jour;
					if ($date_du_jour>$annee_a_suppr) 
					{ 
						include("sql_connect.php");
						$suppr_annee='DELETE FROM date_evenement WHERE annee_evenement<='.$annee_a_delete.'';
						$query = mysqli_query($connection,$suppr_annee) or die("Une requête a échouée.");
						mysqli_close($connection);
				
					}
					
					#--------------------------------------------------------------------		
				
				}
			?>
		</table>
		
		<br/>
		
	    <?php echo 'Les évenements antérieurs à un mois seront supprimés automatiquement.' ; ?>

	</body>
</html>
