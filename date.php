<?php
class Date{
#declaration des variable pour les jours et pour les mois dans un tableau 
	var $nom_jour = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','dimanche');
	var $nom_mois = array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');


function getAll($an){
	$r = array();#creation du  tableau 
	$date = strtotime($an.'-01-01');#1 jour de  l'annee
	while (date ('Y',$date) <= $an)
	{
		
		$annee = date('Y',$date); 
		$mois = date('n',$date); #n permet d'enlever les 0 devant le mois
		$jour = date('j',$date);# j permet d'enlever les 0 devant le jour 
		$w = str_replace('0','7',date('w',$date));#date du jour"
		$r[$annee][$mois][$jour]=$w;#dans mon tableau  je met  annee mois  jour 
		$date = $date + 24 * 3600;# rejoute une annee 
	}
	return $r;
	
}






}