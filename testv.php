<!DOCTYPE html>

<html>
    <head>
        <title>Calendrier</title>
    </head>

  <!-- Partie vincent --> 
   
<style>
body{
margin:0;
padding:0;
background: url(fond1.jpg) no-repeat center fixed; /*image de fond*/
background-size: cover; /*taille image de fond*/
}
</style> 
    
   
        <header>
            <h1>Mon agenda</h1>
             <?php
        require('calytdonnee.php'); #recup donnee fichier 
        $date = new Date();
        $annee=date('Y');
        $dates=$date->getAll($annee); #recup toutes les dates du tableau         
        echo ("la date du jour est :").date('d/m/Y')
        ?>
            <p>lien utile</p>
        </header>
        <nav>
            <ul>
                <!--Boutons hyperliens -->
                <li><a href="http://google.fr">acces à Google.fr</a></li>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Me contacter</a></li>
            </ul>
        </nav>

    </body>

<script type='text/javascript' src='http://code.jquery.com/jquery-1.9.1.js'></script>
<script type='text/javascript'>
$(window).load(function(){
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
             
            reader.onload = function (e) {
                $('#adresse').attr('src', e.target.result);
            }
             
            reader.readAsDataURL(input.files[0]);
        }
    }
     
    $("#photo1").change(function(){
        readURL(this);
    });
});
 
</script>



    <input type= "file" id="photo1"></p>
    <img id="adresse" src="#" width="150" height="150" />

    
        <!-- Partie alex --> 

    <body>
        <?php
        #require('calytdonnee.php'); #recup donnee fichier 
        $date = new Date();
        $annee=date('Y');
        $dates=$date->getAll($annee); #recup toutes les dates du tableau        
        #echo date('d/m/Y')
        ?>

        <div class="periodes">
            <div class="annee">
                <?php 
                #echo $annee;
                ?>
            </div>
            <div class="mois">
                <ul>
                    <?php foreach ($date->mois as $mois):  ?> 
                    <th> <?php echo $mois;   ?> </th>
                        
                   
                <?php endforeach;?>
  
                </ul>
            </div>
        </div>
        <?php 
        print_r($dates);
        ?>
</html>