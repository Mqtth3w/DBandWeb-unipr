<html>
<head> <title>Classifica</title> </head>

<body>

<?php
	if (!empty($_REQUEST['evento'])) {
		$evento=$_REQUEST['evento'];
		$query=str_replace("#evento#", $evento, "SELECT nome, (numlike - numdislike) as voto, numlike, numdislike 
		from piatti where evento='#evento#' order by (numlike - numdislike) DESC");
		echo "<br><br><b><center>Classifica piatti evento <h1>$evento</h1></center></b><br>";
	}
	else {
		$query="SELECT nome, (numlike - numdislike) as voto, numlike, numdislike 
		from piatti order by (numlike - numdislike) DESC";
		echo "<br><br><b><center><h1>Classifica globale piatti</h1></center></b><br>";
	}

?>	
<center>
<?php
	
	#reperisce e stampa la classifica dei piatti (like-dislike)
	$user="root"; $password=""; $host="localhost"; $database="cookevents";
	$con=@mysqli_connect($host,$user,$password,$database) or die( "Unable to select database");
	
	$result=mysqli_query($con,$query);
	mysqli_close($con);
	$num=mysqli_num_rows($result);
	$i=1;
	while ($i <= $num) {
		$row=mysqli_fetch_assoc($result);
		$nome=$row["nome"];
		$voto=$row["voto"];
		$like=$row["numlike"];
		$dislike=$row["numdislike"];
		echo "<b>$i - </b>Nome piatto: <b><a href='piatto.php?piatto=" . $nome . "'>" . $nome . "</a></b><br> Voto (like-dislike): <b>$voto</b><br>like: $like dislike: $dislike <br><br>";
		$i++;
	}
?>

</center>

</body>
</html>