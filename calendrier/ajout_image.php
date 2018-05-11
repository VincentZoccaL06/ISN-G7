

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
	<?php
echo"<pre>";
     print_r($_FILES);
echo"</pre>";

if (!empty($_FILES)){
	print_r($_FILES);
	$img = $_FILES ['envoie'];
	move_uploaded_file($img['tmp_name'], "images/".$img['name']);
}
?>
<!---
//include ("sql_connect.php");
///$lien_Img = $_POST ('lien_Images');
//echo (lien_Images);

//$req = "INSERT INTO image VALUES('',"lien_Img")";
//$exec = mysqli_query($req);
//?> -->

<center></br></br></br></br>
<form  method = "POST" enctype = "multipart/form-data">

	<LABEL>CHOISIR UNE IMAGE  A INSERER </LABEL>
	<input type= "file" name="image"/></p>
	<input type="submit" name="envoie" value="Enregistrement  de l'image"/>
</form>
</center>
<?php
echo"<pre>";
     print_r($_FILES);
echo"</pre>";

if (!empty($_FILES)){
	print_r($_FILES);
	$img = $_FILES ['envoie'];
	move_uploaded_file($img['tmp_name'], "images/".$img['name']);
}
?>
</body>
</html>