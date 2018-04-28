<!DOCTYPE html>

<html>
    <head>
        <title>Calendrier</title>

        
       <!--<li>rel ="stylesheet" type "texte/css herf ="style.css"</li> -->
       <script type='text/javascript' src='http://code.jquery.com/jquery-1.9.1.js'></script>
    </head>
    <body>
    	
<?php 
require('date.php');
$date = new Date();
$an = date('Y');
$dates = $date->getAll($an);
?>
<div class="periods"> 
	<div class="an"><?php echo $an; ?></div>
	<div class="nom_mois">
		<ul>
			<?php foreach ($date->nom_mois as $id=>$nom_mois): ?> <!-- affiche le nom des mois du tableau  -->
				<li><a href="#" id="lien_mois"><?php echo $nom_mois; ?></a></li> <!-- href = rend cliquable les mois -->
			<?php endforeach; ?>

		</ul>
	</div>
	<?php $dates = current($dates); ?>
	<?php foreach ($dates as $nom_mois => $nom_jour): ?>
		<div class"month" id="month<?php echo $nom_mois; ?>">
		<table>
			<thead>
				<tr>
					<?php foreach ($date->nom_jour as $jour): ?>
						<th>
							<?php echo substr($jour,0,3); ?>
						</th>
					<?php endforeach; ?>					
				</tr>
			</thead>

			<tbody>
				<tr>
				<?php foreach ($nom_jour as $jour=>$w): ?>
					<?php if ($jour == 1): ?>
						<td colspan="<?php echo $w-1; ?>"></td>

					<?php endif; ?>
					<td><?php echo $jour; ?></td>
					<?php if ($w == 7): ?>
					</tr><tr>
					<?php endif; ?>
				<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
		</div>
		<?php endforeach; ?>
</div>

<pre> <?php print_r($dates);?> </pre>


    </body>
</html>


 

















